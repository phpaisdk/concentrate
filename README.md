# aisdk/concentrate

Official Concentrate AI provider for the PHP AI SDK. It uses Concentrate's OpenAI-compatible Chat Completions API to access models from multiple providers through one endpoint.

## Installation

```bash
composer require aisdk/concentrate
```

## Basic Usage

```php
use AiSdk\Concentrate;
use AiSdk\Generate;

$result = Generate::text('Explain closures in PHP.')
    ->model(Concentrate::model('claude-opus-4-8'))
    ->run();

echo $result->text;
```

## Configuration

| Variable | Description | Default |
|---|---|---|
| `CONCENTRATE_API_KEY` | API key for authentication | Required |
| `CONCENTRATE_BASE_URL` | Base URL for API requests | `https://api.concentrate.ai/v1` |

```php
Concentrate::create([
    'apiKey' => 'sk-cn-...',
    'headers' => ['X-Custom-Header' => 'value'],
]);
```

## Supported Capabilities

| Capability | Support |
|---|---|
| Text generation | Native |
| Streaming | Native |
| Tool calling | Native |
| Reasoning | Native |
| Structured output | Native |
| Text input | Native |
| Image input | Native where supported by the selected model |

Model IDs are opaque strings. The package does not maintain a model catalog; Concentrate remains the authority on model availability and capability support.

## Testing

```bash
composer test:all
```
