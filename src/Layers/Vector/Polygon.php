<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Layers\Vector;

/**
 * Represents a Polygon on the map
 *
 * A Polygon is a Polyline that Leaflet closes,
 * therefore the locations given to define a polygon _should not_ have a last point equal to the first
 *
 * @link https://leafletjs.com/reference.html#polyline
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 */
final class Polygon extends Polyline {}