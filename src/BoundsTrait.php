<?php
/**
 * @copyright Copyright (c) 2022 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet;

use BeastBytes\Widgets\Leaflet\types\LatLngBounds;

/**
 * Defines the LatLngBounds for Leaflet components
 *
 * Use in components that have a bounds defined by a LatLngBounds
 */
trait BoundsTrait
{
    /**
     * @param LatLngBounds The bounds
     */
    private LatLngBounds $bounds;

    /**
     * Sets the bounds property
     * 
     * The bounds can be a LatLngBounds object, an array of the corners of the bounds where a corner can be a LatLng
     * object or an array of the form or [$lat, $lng]
     *
     * @param array|LatLngBounds $bounds The bounds
     */
    private function setBounds(array|LatLngBounds $bounds): void
    {
        $this->bounds = is_array($bounds) ? new LatLngBounds($bounds[0], $bounds[1]) : $bounds;
    }
}
