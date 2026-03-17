<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Types;

use BeastBytes\Yii\Leaflet\LeafletInterface;
use InvalidArgumentException;

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
     * @param int|array{int, int}|array{x: int, y: int} $x x or x and y coordinate in pixels
     * @param ?int $y y coordinate in pixels. Ignored if $x is an array
     * @throws InvalidArgumentException If $x is an integer and $y is null
     */
    public function __construct(array|int $x, ?int $y = null) {
        if (is_array($x)) {
            if (array_key_exists('x', $x)) {
                $this->x = $x['x'];
                $this->y = $x['y'];
            } else {
                $this->x = $x[0];
                $this->y = $x[1];
            }
        } elseif ($y !== null) {
            $this->x = $x;
            $this->y = $y;
        } else {
            throw new InvalidArgumentException('$y must be an integer if $x is an integer');
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