<?php
/**
 * @copyright Copyright (c) 2022 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\raster;

use BeastBytes\Widgets\Leaflet\types\LatLngBounds;

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
