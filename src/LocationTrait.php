<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet;

use BeastBytes\Widgets\Leaflet\types\LatLng;

/**
 * Defines the geographical location of Leaflet components
 *
 * Use in components that have a location defined by a LatLng
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
     * The value is an array in the form [$lat, $lng], or a LatLng object
     *
     * @param array|LatLng $location The component's location
     */
    private function setLocation(array|LatLng $location): void
    {
        $this->location = is_array($location) ? new LatLng($location[0], $location[1]) : $location;
    }
}
