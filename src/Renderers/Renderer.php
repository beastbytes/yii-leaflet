<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Renderers;

use BeastBytes\Yii\Leaflet\Component;
use BeastBytes\Yii\Leaflet\LeafletInterface;
use JsonException;

/**
 * Base class for renderers
 *
 * @link https://leafletjs.com/reference.html#renderer
 */
abstract class Renderer extends Component
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

        return "$leafletVar.$name({$this->options2Js($leafletVar)})";
    }
}