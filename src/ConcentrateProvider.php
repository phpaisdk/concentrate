<?php

declare(strict_types=1);

namespace AiSdk\Concentrate;

use AiSdk\Concentrate\Models\ConcentrateTextModel;
use AiSdk\Contracts\BaseProvider;
use AiSdk\Contracts\TextModelInterface;
use AiSdk\Contracts\TextProviderInterface;

final class ConcentrateProvider extends BaseProvider implements TextProviderInterface
{
    public function __construct(public readonly ConcentrateOptions $options) {}

    public function name(): string
    {
        return ConcentrateOptions::PROVIDER_NAME;
    }

    protected function textModel(string $modelId): TextModelInterface
    {
        return new ConcentrateTextModel($modelId, $this->options);
    }
}
