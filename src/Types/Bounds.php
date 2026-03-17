<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Types;

use BeastBytes\Yii\Leaflet\LeafletInterface;
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

    /**
     * @param T $corner1 A point that is a corner of the bounding box
     * @param T $corner2 A point that is the diagonally opposite corner of the bounding box from $corner1
     */
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