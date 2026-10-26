<?php

declare(strict_types=1);

use AiSdk\Concentrate;
use AiSdk\Concentrate\Tests\Fakes\FakeHttpClient;
use AiSdk\Generate;
use AiSdk\Schema;
use AiSdk\Support\Sdk;
use Nyholm\Psr7\Factory\Psr17Factory;

afterEach(function () {
    Generate::reset();
    Concentrate::reset();
});

function configureConcentrateWith(FakeHttpClient $client): void
{
    $factory = new Psr17Factory;
    Generate::configure(new Sdk(
        httpClient: $client,
        requestFactory: $factory,
        streamFactory: $factory,
    ));
}

it('generates text through Concentrate', function () {
    $client = new FakeHttpClient(200, json_encode([
        'id' => 'chatcmpl-concentrate',
        'model' => 'claude-opus-4-8',
        'choices' => [[
            'message' => ['content' => 'Hello from Concentrate'],
            'finish_reason' => 'stop',
        ]],
        'usage' => ['prompt_tokens' => 7, 'completion_tokens' => 3],
    ]));
    configureConcentrateWith($client);
    Concentrate::create(['apiKey' => 'sk-cn-test']);

    $result = Generate::text('Hi')->model(Concentrate::model('claude-opus-4-8'))->run();

    expect($result->text)->toBe('Hello from Concentrate')
        ->and($result->usage->inputTokens)->toBe(7)
        ->and($result->providerMetadata['concentrate']['id'])->toBe('chatcmpl-concentrate');

    expect($client->sentBody()['model'])->toBe('claude-opus-4-8')
        ->and($client->lastRequest->getUri()->getPath())->toBe('/v1/chat/completions')
        ->and($client->lastRequest->getHeaderLine('Authorization'))->toBe('Bearer sk-cn-test');
});

it('uses structured output through the compatible request profile', function () {
    $client = new FakeHttpClient(200, json_encode([
        'choices' => [['message' => ['content' => '{"city":"Lahore"}'], 'finish_reason' => 'stop']],
        'usage' => [],
    ]));
    configureConcentrateWith($client);
    Concentrate::create(['apiKey' => 'sk-cn-test']);

    Generate::text('Extract the city from Lahore.')
        ->model(Concentrate::model('gpt-5.2'))
        ->output(Schema::object(
            name: 'city',
            properties: [Schema::string(name: 'city')->required()],
        ))
        ->maxTokens(1024)
        ->run();

    $body = $client->sentBody();
    expect($body['response_format']['type'])->toBe('json_schema')
        ->and($body['max_completion_tokens'])->toBe(1024);
});

it('accepts opaque model identifiers', function () {
    Concentrate::create(['apiKey' => 'sk-cn-test']);

    expect(Concentrate::model('my-private-model')->modelId())->toBe('my-private-model');
});
