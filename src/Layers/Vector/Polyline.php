<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Layers\Vector;

use BeastBytes\Yii\Leaflet\Layers\Layer;
use BeastBytes\Yii\Leaflet\Types\LatLng;
use JsonException;

/**
 * Represents a Polyline on the map
 *
 * @link https://leafletjs.com/reference.html#polyline
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
class Polyline extends Layer
{
    private array $locations;

    /**
     * @param list<T|list<T>> $locations A list of geographical locations or lists of geographical locations
     * @param array<string, mixed> $options
     */
    public function __construct(array $locations, array $options = [])
    {
        $this->locations = $this->parse($locations);
        parent::__construct($options);
    }

    /**
     * Parses locations into LatLng objects
     *
     * @param array $locations The locations to parse
     * @return array The parsed locations
     */
    private function parse(array $locations): array
    {
        foreach ($locations as &$location) {
            if (is_array($location)) {
                if (is_array($location[0])) {
                    $location = $this->parse($location);
                } elseif (!$location[0] instanceof LatLng) {
                    $location = new LatLng($location);
                }
            }
        }

        return $locations;
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
        $locations = $this->locations2Js($this->locations, $leafletVar);
        $options = $this->options2Js($leafletVar);

        return "$leafletVar.$name($locations". (!empty($options) ? ",$options" : '') . ')'
            . $this->bind($leafletVar);
    }

    /**
     * @param array $locations Array of locations
     * @param string $leafletVar The Leaflet variable name
     * @return string
     */
    private function locations2Js(array $locations, string $leafletVar): string
    {
        $js = [];

        foreach ($locations as $location) {
            $js[] = is_array($location)
                ? $this->locations2Js($location, $leafletVar)
                : $location->toJs($leafletVar)
            ;
        }

        return '[' . implode(',', $js) . ']';
    }
}