<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\ui;

use BeastBytes\Widgets\Leaflet\layers\Layer;
use BeastBytes\Widgets\Leaflet\LeafletInterface;
use BeastBytes\Widgets\Leaflet\LocationTrait;
use BeastBytes\Widgets\Leaflet\types\Icon;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use JsonException;

/**
 * Represents a marker on the map
 *
 * @link https://leafletjs.com/reference.html#marker
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 */
final class Marker extends Layer implements LeafletInterface
{
    use LocationTrait;

    public function __construct(array|LatLng $location, array $options = [])
    {
        $this->setLocation($location);

        if (isset($options['icon']) && is_array($options['icon'])) {
            $options['icon'] = new Icon($options['icon']);
        }

        parent::__construct($options);
    }

    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        $location = $this->location->toJs($leafletVar);
        $options = $this->options2Js($leafletVar);

        return "$leafletVar.marker($location" . (!empty($options) ? ",$options" : '') . ')'
            . $this->bind($leafletVar);
    }
}
