<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Types;

use BeastBytes\Yii\Leaflet\LeafletInterface;
use InvalidArgumentException;

/**
 * Represents a geographical location at a given latitude and longitude, and optionally altitude
 *
 * Latitude is checked to ensure it is in range -90 <= latitude <= 90
 *
 * Longitude is not as "out of bounds" longitudes are necessary if a LatLngBounds spans the antemeridian
 *
 * @link https://leafletjs.com/reference.html#point
 */
final class LatLng implements LeafletInterface
{
    public const INVALID_LATITUDE_MESSAGE = 'Invalid `latitude`: {value}; must be in range -' . self::LATITUDE_MAX
        . ' and ' . self::LATITUDE_MAX;
    /**
     * Maximum latitude value
     */
    public const LATITUDE_MAX = 90;

    private float $latitude = 0;

    /**
     * @param array{float, float}|array{float, float, float}|array{lat: float, lng: float}|array{lat: float, lng: float, alt: float}|float $latitude Latitude in degrees [-90 <= lat <= 90]
     * @param ?float $longitude Longitude in degrees
     * @param ?float $altitude Altitude in metres
     */
    public function __construct(
        array|float $latitude,
        private ?float $longitude = null,
        private ?float $altitude = null
    )
    {
        if (is_array($latitude)) {
            if (array_key_exists('lat', $latitude)) {
                $this->latitude = $latitude['lat'];
                $this->longitude = $latitude['lng'];
                if (array_key_exists('alt', $latitude)) {
                    $this->altitude = $latitude['alt'];
                }
            } else {
                $this->latitude = $latitude[0];
                $this->longitude = $latitude[1];
                if (count($latitude) === 3) {
                    $this->altitude = $latitude[2];
                }
            }
        } else {
            $this->latitude = $latitude;
        }

        if (abs($this->latitude) > self::LATITUDE_MAX) {
            throw new InvalidArgumentException(strtr(self::INVALID_LATITUDE_MESSAGE, ['{value}' => $this->latitude]));
        }
    }

    /**
     * @param string $leafletVar
     * @return string
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        return isset($this->altitude)
            ? "$leafletVar.latLng($this->latitude,$this->longitude,$this->altitude)"
            : "$leafletVar.latLng($this->latitude,$this->longitude)";
    }
}