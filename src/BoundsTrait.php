<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet;

use BeastBytes\Yii\Leaflet\Types\LatLng;
use BeastBytes\Yii\Leaflet\Types\LatLngBounds;

/**
 * Defines the LatLngBounds for Leaflet components
 *
 * Use in components that have a bounds defined by a LatLngBounds
 *
 * @template T of array{float, float}|array{float, float, float}|array{lat: float, lng: float}|array{lat: float, lng: float, alt: float}|LatLng
 */
trait BoundsTrait
{
    /**
     * @param LatLngBounds $bounds The bounds
     */
    private LatLngBounds $bounds;

    /**
     * Sets the bounds property
     *
     * @param array{0: T, 1: T}|LatLngBounds $bounds The bounds
     */
    private function setBounds(array|LatLngBounds $bounds): void
    {
        $this->bounds = $bounds instanceof LatLngBounds ? $bounds : new LatLngBounds($bounds[0], $bounds[1]);
    }
}