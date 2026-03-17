<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Layers\Raster;

use BeastBytes\Yii\Leaflet\Layers\Layer;
use JsonException;

/**
 * Represents a tile layer used to load and display a tile layer on the map
 *
 * Use this class for providers not implemented by the TileProvider class
 *
 * @link https://leafletjs.com/reference.html#tilelayer
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 */
class TileLayer extends Layer
{
    /**
     * @param string $url Tile provider URL
     * @param array<string, mixed> $options
     */
    public function __construct(protected string $url, array $options = [])
    {
        parent::__construct($options);
    }

    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        $options = $this->options2Js($leafletVar);

        return "$leafletVar.tileLayer(\"$this->url\"" . (!empty($options) ? ",$options" : '') . ')'
            . $this->bind($leafletVar);
    }
}