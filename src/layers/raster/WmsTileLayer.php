<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\raster;

use JsonException;

/**
 * Represents a {@link https://en.wikipedia.org/wiki/Web_Map_Service WMS} tile layer
 * used to display a WMS service as a tile layer on the map
 *
 * @link https://leafletjs.com/reference.html#tilelayer-wms
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 * @property string $url
 */
final class WmsTileLayer extends TileLayer
{
    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        $options = $this->options2Js($leafletVar);

        return "$leafletVar.tileLayer.wms(\"$this->url\"" . (!empty($options) ? ",$options" : '') . ')'
            . $this->bind($leafletVar);
    }
}
