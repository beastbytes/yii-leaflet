<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Layers\Vector;

use BeastBytes\Yii\Leaflet\Layers\Layer;
use BeastBytes\Yii\Leaflet\LocationTrait;
use BeastBytes\Yii\Leaflet\Types\LatLng;
use InvalidArgumentException;

/**
 * Represents a circle of a fixed size with radius specified in pixels; default radius 10 pixels
 *
 * @link https://leafletjs.com/reference.html#circlemarker
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
class CircleMarker extends Layer
{
    use CircleTrait;
    use LocationTrait;

    public const RADIUS_NOT_POSITIVE_INT_MESSAGE = "If set, `options['radius']` must be a positive integer";

    /**
     * @param T $location Location - centre - of CircleMarker
     * @param array<string, mixed> $options CircleMarker options. $options['radius'] must be a positive integer
     */
    public function __construct(array|LatLng $location, array $options)
    {
        if (array_key_exists('radius', $options) && (!is_int($options['radius']) || $options['radius'] <= 0)) {
            throw new InvalidArgumentException(self::RADIUS_NOT_POSITIVE_INT_MESSAGE);
        }

        $this->setLocation($location);
        parent::__construct($options);
    }
}