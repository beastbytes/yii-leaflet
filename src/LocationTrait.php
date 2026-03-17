<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet;

use BeastBytes\Yii\Leaflet\Types\LatLng;

/**
 * Defines the geographical location of Leaflet components
 *
 * Use in components that have a location defined by a LatLng
 *
 * @template T of array{float, float}|array{float, float, float}|array{lat: float, lng: float}|array{lat: float, lng: float, alt: float}|LatLng
 */
trait LocationTrait
{
    /**
     * @var LatLng The geographical location of a component
     */
    private LatLng $location;

    /**
     * Sets the geographical location of the component
     *
     * @param T $location The component's location
     */
    private function setLocation(array|LatLng $location): void
    {
        $this->location = $location instanceof LatLng ? $location : new LatLng($location);
    }
}