<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Layers\Other;

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