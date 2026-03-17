<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Layers\Vector;

use BeastBytes\Yii\Leaflet\Layers\Layer;
use BeastBytes\Yii\Leaflet\BoundsTrait;
use BeastBytes\Yii\Leaflet\Types\LatLng;
use BeastBytes\Yii\Leaflet\Types\LatLngBounds;
use JsonException;

/**
 * Represents a Rectangle on the map
 *
 * @link https://leafletjs.com/reference.html#rectangle
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 *
 * @template T of array{float, float}|array{float, float, float}|array{lat: float, lng: float}|array{lat: float, lng: float, alt: float}|LatLng
 */
final class Rectangle extends Layer
{
    use BoundsTrait;

    /**
     * @param array{T, T}|LatLngBounds $bounds The NW and SE geographical locations of the rectangle
     * @param array<string, mixed> $options
     */
    public function __construct(array|LatLngBounds $bounds, array $options = [])
    {
        $this->setBounds($bounds);
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
        $bounds = $this->bounds->toJs($leafletVar);
        $options = $this->options2Js($leafletVar);

        return "$leafletVar.rectangle($bounds" . (!empty($options) ? ",$options" : '') . ')'
            . $this->bind($leafletVar);
    }
}