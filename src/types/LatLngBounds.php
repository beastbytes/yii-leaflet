<?php
/**
 * @copyright Copyright (c) 2022 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\types;

use BeastBytes\Widgets\Leaflet\LeafletInterface;

/**
 * Represents a rectangular geographical area on a map
 *
 * @link https://leafletjs.com/reference.html#latlngbounds
 */
final class LatLngBounds implements LeafletInterface
{
    /**
     * @var LatLng[] Corners of the bounds
     */
    private array $corners;

    public function __construct(array|LatLng $corner1, array|LatLng $corner2)
    {
        $this->corners[0] = is_array($corner1) ? new LatLng($corner1) : $corner1;
        $this->corners[1] = is_array($corner2) ? new LatLng($corner2) : $corner2;
    }

    /**
     * @param string $leafletVar
     * @return string
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        return "$leafletVar.latLngBounds({$this->corners[0]->toJs($leafletVar)},{$this->corners[1]->toJs($leafletVar)})";
    }
}
