<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\vector;

use BeastBytes\Widgets\Leaflet\layers\Layer;
use BeastBytes\Widgets\Leaflet\LeafletInterface;
use BeastBytes\Widgets\Leaflet\LocationTrait;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use JsonException;

/**
 * Represents a circle of a fixed size with a radius specified in metres
 *
 * @link https://leafletjs.com/reference.html#circle
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 */
class Circle extends Layer implements LeafletInterface
{
    use LocationTrait;

    public function __construct(array|LatLng $location, array $options = [])
    {
        $this->setLocation($location);
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
        $name = lcfirst(substr(static::class, strrpos(static::class, '\\') + 1));
        $location = $this->location->toJs($leafletVar);
        $options = $this->options2Js($leafletVar);

        return "$leafletVar.$name($location" . (!empty($options) ? ",$options" : '') . ')'
            . $this->bind($leafletVar);
    }
}
