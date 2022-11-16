<?php
/**
 * @copyright Copyright (c) 2022 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\vector;

use BeastBytes\Widgets\Leaflet\layers\Layer;
use BeastBytes\Widgets\Leaflet\BoundsTrait;
use BeastBytes\Widgets\Leaflet\LeafletInterface;
use BeastBytes\Widgets\Leaflet\types\LatLngBounds;
use JsonException;

/**
 * Represents a Rectangle on the map
 *
 * @link https://leafletjs.com/reference.html#rectangle
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 */
final class Rectangle extends Layer implements LeafletInterface
{
    use BoundsTrait;

    public function __construct(array|LatLngBounds $bounds, array $options = [])
    {
        $this->setBounds($bounds);
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
        $bounds = $this->bounds->toJs($leafletVar);
        $options = $this->options2Js($leafletVar);

        return "$leafletVar.rectangle($bounds" . (!empty($options) ? ",$options" : '') . ')'
            . $this->bind($leafletVar);
    }
}
