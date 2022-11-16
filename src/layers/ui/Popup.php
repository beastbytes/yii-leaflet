<?php
/**
 * @copyright Copyright (c) 2022 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\ui;

use BeastBytes\Widgets\Leaflet\layers\Layer;
use BeastBytes\Widgets\Leaflet\LeafletInterface;
use BeastBytes\Widgets\Leaflet\LocationTrait;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use JsonException;

/**
 * Represents a Popup on the map
 *
 * @link https://leafletjs.com/reference.html#popup
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 */
final class Popup extends Layer implements LeafletInterface
{
    use LocationTrait;

    public function __construct(private string $content, array|LatLng $location = [], array $options = [])
    {
        if (!empty($location)) { // Bound popups do not have a location
            $this->setLocation($location);
        }
        parent::__construct($options);
    }

    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        return "$leafletVar.popup({$this->options2Js($leafletVar)})"
            . ".setContent('$this->content').setLatLng({$this->location->toJs($leafletVar)})"
            . $this->bind($leafletVar);
    }
}
