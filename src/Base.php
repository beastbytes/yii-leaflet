<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet;

/**
 * Base class for Leaflet objects that accept options
 */
abstract class Base
{
    use OptionsTrait;

    /**
     * @param array<string, mixed> $options Object options
     */
    public function __construct(array $options = []) {
        $this->options = $options;
    }
}