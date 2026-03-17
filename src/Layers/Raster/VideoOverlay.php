<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Layers\Raster;

use BeastBytes\Yii\Leaflet\Types\LatLngBounds;

/**
 * Represents a VideoOverlay on the map
 *
 * Used to load and display a video over specific bounds of the map
 *
 * @link https://leafletjs.com/reference.html#videooverlay
 *
 * @property bool $addToMap
 * @property array|LatLngBounds $bounds The image bounds
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 * @property array|string $url
 */
class VideoOverlay extends ImageOverlay {}