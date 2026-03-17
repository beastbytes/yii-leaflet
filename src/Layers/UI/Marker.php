<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Layers\UI;

use BeastBytes\Yii\Leaflet\Layers\Layer;
use BeastBytes\Yii\Leaflet\LocationTrait;
use BeastBytes\Yii\Leaflet\Types\Icon;
use BeastBytes\Yii\Leaflet\Types\LatLng;
use JsonException;

/**
 * Represents a marker on the map
 *
 * @link https://leafletjs.com/reference.html#marker
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
final class Marker extends Layer
{
    use LocationTrait;

    /**
     * @param T $location Geographical location of the marker
     * @param array<string, mixed> $options Marker options
     */
    public function __construct(array|LatLng $location, array $options = [])
    {
        $this->setLocation($location);

        if (isset($options['icon']) && is_array($options['icon'])) {
            $options['icon'] = new Icon($options['icon']);
        }

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
        $location = $this->location->toJs($leafletVar);
        $options = $this->options2Js($leafletVar);

        return "$leafletVar.marker($location" . (!empty($options) ? ",$options" : '') . ')'
            . $this->bind($leafletVar);
    }
}