<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Types;

use BeastBytes\Yii\Leaflet\LeafletInterface;
use InvalidArgumentException;

/**
 * Represents a rectangular geographical area on a map
 *
 * @link https://leafletjs.com/reference.html#latlngbounds
 *
 * @template T of array{float, float}|array{float, float, float}|array{lat: float, lng: float}|array{lat: float, lng: float, alt: float}|LatLng
 */
final class LatLngBounds implements LeafletInterface
{
    /**
     * @var LatLng[] $corners Corners of the bounds
     */
    private array $corners = [];

    /**
     * Create a LatLngBounds object representing a rectangular geographical area on a map
     *
     * If the area crosses the antimeridian,
     * a corner whose longitude is outside the range -180 <= longitude <= 180 must be specified
     *
     * @param T $corner1 A geographical location that is a corner of the bounding box
     * @param T $corner2 A geographical location that is the diagonally opposite corner of the bounding box from $corner1
     * @throws InvalidArgumentException If the latitude of either corner is out of range
     */
    public function __construct(array|LatLng $corner1, array|LatLng $corner2)
    {
        $this->corners[0] = $corner1 instanceof LatLng ? $corner1 : new LatLng($corner1);
        $this->corners[1] = $corner2 instanceof LatLng ? $corner2 : new LatLng($corner2);
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