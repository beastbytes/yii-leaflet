<?php
/**
 * @copyright Copyright (c) 2022 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\raster;

use BeastBytes\Widgets\Leaflet\BoundsTrait;
use BeastBytes\Widgets\Leaflet\LeafletInterface;
use BeastBytes\Widgets\Leaflet\types\LatLngBounds;
use JsonException;

/**
 * Represents a ImageOverlay on the map
 *
 * Used to load and display a single image over specific bounds of the map
 *
 * @link https://leafletjs.com/reference.html#imageoverlay
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 * @property string $url
 */
class ImageOverlay extends TileLayer
{
    use BoundsTrait;

    public function __construct(string $url, array|LatLngBounds $bounds, $options = [])
    {
        $this->setBounds($bounds);
        parent::__construct($url, $options);
    }

    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        $name = lcfirst(substr(static::class, strrpos(static::class, '\\') + 1));
        $bounds = $this->bounds->toJs($leafletVar);
        $options = $this->options2Js($leafletVar);

        return "$leafletVar.$name(\"$this->url\",$bounds" . (!empty($options) ? ",$options" : '') . ')'
            . $this->bind($leafletVar);
    }
}
