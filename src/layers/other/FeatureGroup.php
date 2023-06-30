<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\other;

/**
 * Represents a feature group
 *
 * @link https://leafletjs.com/reference.html#featuregroup
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $layers
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 */
final class FeatureGroup extends LayerGroup {}
