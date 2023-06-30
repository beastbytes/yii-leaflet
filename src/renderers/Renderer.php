<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\renderers;

use BeastBytes\Widgets\Leaflet\Component;
use BeastBytes\Widgets\Leaflet\LeafletInterface;
use JsonException;

/**
 * Base class for renderers
 *
 * @link https://leafletjs.com/reference.html#renderer
 */
abstract class Renderer extends Component implements LeafletInterface
{
    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        $name = lcfirst(substr(static::class, strrpos(static::class, '\\') + 1));
        return "$leafletVar.$name({$this->options2Js($leafletVar)})";
    }
}
