<?php
/**
 * @copyright Copyright (c) 2022 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\raster;

use BeastBytes\Widgets\Leaflet\layers\Layer;
use BeastBytes\Widgets\Leaflet\LeafletInterface;
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
class TileLayer extends Layer implements LeafletInterface
{
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
