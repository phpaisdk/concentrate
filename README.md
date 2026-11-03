# PHP AI SDK — Concentrate

Text generation, streaming, and tool calling through Concentrate AI. Part of the framework-agnostic [PHP AI SDK](https://phpaisdk.com).

## Installation

```bash
composer require aisdk/concentrate
```

Set `CONCENTRATE_API_KEY` in your environment.

## Usage

```php
use AiSdk\Concentrate;
use AiSdk\Generate;

$result = Generate::text('Explain closures in PHP in one sentence.')
    ->model(Concentrate::model('claude-sonnet-5-5'))
    ->run();

echo $result->text;
```

## Documentation

[Read the documentation](https://phpaisdk.com/docs/0.x/providers/concentrate) for configuration, supported features, and more examples.

[Contributing](https://github.com/phpaisdk/.github/blob/main/CONTRIBUTING.md) · [Support](https://github.com/phpaisdk/.github/blob/main/SUPPORT.md)

## License

The MIT License (MIT). See [LICENSE](LICENSE) for details.
