<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\types;

use BeastBytes\Widgets\Leaflet\LeafletInterface;

/**
 * Represents a point with x and y coordinates in pixels
 *
 * @link https://leafletjs.com/reference.html#point
 */
final class Point implements LeafletInterface
{
    private int $x = 0;
    private int $y = 0;

    /**
     * @param int|array $x x coordinate in pixels | [x, y]
     * @param ?int $y y coordinate in pixels
     */
    public function __construct(array|int $x, ?int $y = null) {
        if (is_array($x)) {
            $this->x = $x[0];
            $this->y = $x[1];
        } else {
            $this->x = $x;
            $this->y = $y;
        }
    }

    /**
     * @param string $leafletVar
     * @return string
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        return "$leafletVar.point($this->x,$this->y)";
    }
}
