<?php
/**
 * Polyline Class file
 * @copyright Copyright (c) 2022 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\vector;

use BeastBytes\Widgets\Leaflet\layers\Layer;
use BeastBytes\Widgets\Leaflet\LeafletInterface;
use BeastBytes\Widgets\Leaflet\types\LatLng;
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
 */
class Polyline extends Layer implements LeafletInterface
{
    /**
     * @param array Array, or an array of arrays, of geographical points
     */
    private array $locations;

    public function __construct(array $locations, array $options = [])
    {
        $this->locations = $this->parse($locations);
        parent::__construct($options);
    }

    /**
     * Parses locations into LatLng objects
     *
     * @param array $locations The locations to parse
     * @param int|null $j Index for multidimensional array of locations
     * @return array The parsed locations
     */
    private function parse(array $locations, int $j = null): array
    {
        foreach ($locations as $i => &$location) {
            if (is_array($location)) {
                if (is_array($location[0])) {
                    $location = $this->parse($location, $i);
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
