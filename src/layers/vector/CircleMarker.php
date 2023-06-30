<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\vector;

/**
 * Represents a circle of a fixed size with radius specified in pixels; default radius 10 pixels
 *
 * @link https://leafletjs.com/reference.html#circlemarker
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 */
class CircleMarker extends Circle {}
