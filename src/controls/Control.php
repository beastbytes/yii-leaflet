<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\controls;

use BeastBytes\Widgets\Leaflet\Component;
use BeastBytes\Widgets\Leaflet\LeafletInterface;
use JsonException;

/**
 * Represents a UI control on a map
 *
 * @link https://leafletjs.com/reference.html#control
 */
abstract class Control extends Component implements LeafletInterface
{
    /**
     * @var string Bottom left of the map.
     */
    public const POSITION_BOTTOM_LEFT = 'bottomleft';
    /**
     * @var string Bottom right of the map.
     */
    public const POSITION_BOTTOM_RIGHT = 'bottomright';
    /**
     * @var string Top left of the map.
     */
    public const POSITION_TOP_LEFT = 'topleft';
    /**
     * @var string Top right of the map.
     */
    public const POSITION_TOP_RIGHT = 'topright';

    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        $name = lcfirst(substr(
            static::class,
            strrpos(static::class, '\\') + 1,
            -7
        ));

        return "$leafletVar.control.$name({$this->options2Js($leafletVar)})";
    }
}
