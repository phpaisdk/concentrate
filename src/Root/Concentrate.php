<?php

declare(strict_types=1);

namespace AiSdk;

use AiSdk\Concentrate\ConcentrateOptions;
use AiSdk\Concentrate\ConcentrateProvider;
use AiSdk\Contracts\Model;

/**
 * Friendly facade for the Concentrate AI provider.
 *
 *   $model = Concentrate::model('claude-opus-4-8');
 */
final class Concentrate
{
    private static ?ConcentrateProvider $default = null;

    /**
     * @param  array<string, mixed>  $config
     */
    public static function create(array $config = []): ConcentrateProvider
    {
        return self::$default = new ConcentrateProvider(ConcentrateOptions::fromArray($config));
    }

    public static function default(): ConcentrateProvider
    {
        return self::$default ??= self::create();
    }

    public static function reset(): void
    {
        self::$default = null;
    }

    public static function model(string $modelId): Model
    {
        return self::default()->model($modelId);
    }
}
