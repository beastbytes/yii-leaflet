<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Layers\Raster;

use BeastBytes\Yii\Leaflet\BoundsTrait;
use BeastBytes\Yii\Leaflet\Types\LatLng;
use BeastBytes\Yii\Leaflet\Types\LatLngBounds;
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
 *
 * @template T of array{float, float}|array{float, float, float}|array{lat: float, lng: float}|array{lat: float, lng: float, alt: float}|LatLng
 */
class ImageOverlay extends TileLayer
{
    use BoundsTrait;

    /**
     * @param string $url Image URL
     * @param array{T, T}|LatLngBounds $bounds The bounds of the overlay
     * @param array<string, mixed> $options
     */
    public function __construct(string $url, array|LatLngBounds $bounds, array $options = [])
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