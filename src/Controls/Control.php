<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Controls;

use BeastBytes\Yii\Leaflet\Component;
use JsonException;

/**
 * Represents a UI control on a map
 *
 * @link https://leafletjs.com/reference.html#control
 */
abstract class Control extends Component
{
    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        $name = lcfirst(substr(static::class, strrpos(static::class, '\\') + 1));

        return "$leafletVar.control.$name({$this->options2Js($leafletVar)})";
    }
}