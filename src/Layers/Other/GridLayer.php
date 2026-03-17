<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Layers\Other;

use BeastBytes\Yii\Leaflet\Layers\Layer;
use JsonException;

/**
 * Represents a grid layer
 *
 * GridLayer is a generic class for handling a tiled grid of HTML elements and is the base class for all tile layers
 *
 * @link https://leafletjs.com/reference.html#gridlayer
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 */
final class GridLayer extends Layer
{
    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        return "$leafletVar.gridLayer({$this->options2Js($leafletVar)})"
            . $this->bind($leafletVar);
    }
}