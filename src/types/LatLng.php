<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\types;

use BeastBytes\Widgets\Leaflet\LeafletInterface;
use InvalidArgumentException;

/**
 * Represents a geographical point with a certain latitude and longitude
 *
 * @link https://leafletjs.com/reference.html#point
 */
final class LatLng implements LeafletInterface
{
    public const INVALID_LATITUDE_MESSAGE = 'Invalid `latitude`: {value}; must be in range -' . self::LATITUDE_MAX
        . ' and ' . self::LATITUDE_MAX;
    public const INVALID_LONGITUDE_MESSAGE = 'Invalid `longitude`: {value}; must be in range -' . self::LONGITUDE_MAX
    . ' and ' . self::LONGITUDE_MAX;
    /**
     * Maximum latitude value
     */
    public const LATITUDE_MAX = 90;
    /**
     * Maximum longitude value
     */
    public const LONGITUDE_MAX = 180;

    private float $latitude = 0;

    /**
     * @param float|array $latitude Latitude in degrees [-90 <= lat <= 90]
     * | [float $latitude, float $longitude, float $altitude]
     * | [float $latitude, float $longitude]
     * @param float|null $longitude Longitude in degrees [-180 <= lng <= 180]
     * @param float|null $altitude Altitude in metres
     */
    public function __construct(
        array|float $latitude,
        private ?float $longitude = null,
        private ?float $altitude = null
    )
    {
        if (is_array($latitude)) {
            $this->latitude = $latitude[0];
            $this->longitude = $latitude[1];
            if (count($latitude) === 3) {
                $this->altitude = $latitude[2];
            }
        } else {
            $this->latitude = $latitude;
        }

        if (abs($this->latitude) > self::LATITUDE_MAX) {
            throw new InvalidArgumentException(strtr(self::INVALID_LATITUDE_MESSAGE, ['{value}' => $this->latitude]));
        }

        if (abs($this->longitude) > self::LONGITUDE_MAX) {
            throw new InvalidArgumentException(strtr(self::INVALID_LONGITUDE_MESSAGE, ['{value}' => $this->longitude]));
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
