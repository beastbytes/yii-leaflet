<?php
/**
 * @copyright Copyright (c) 2022 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\types;

use BeastBytes\Widgets\Leaflet\LeafletInterface;
use InvalidArgumentException;

/**
 * Represents a rectangular area in pixel coordinates
 *
 * @link https://leafletjs.com/reference.html#bounds
 */
final class Bounds implements LeafletInterface
{
    /**
     * @var Point[] Corners of the bounds
     */
    private array $corners;

    public function __construct(array|Point $corner1, array|Point $corner2)
    {
        $this->corners[0] = is_array($corner1) ? new Point($corner1) : $corner1;
        $this->corners[1] = is_array($corner2) ? new Point($corner2) : $corner2;
    }

    /**
     * @param string $leafletVar
     * @return string
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        return "$leafletVar.bounds({$this->corners[0]->toJs($leafletVar)},{$this->corners[1]->toJs($leafletVar)})";
    }
}
