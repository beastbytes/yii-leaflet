<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\other;

use BeastBytes\Widgets\Leaflet\layers\Layer;
use BeastBytes\Widgets\Leaflet\LeafletInterface;
use JsonException;

/**
 * Represents a LayerGroup
 *
 * LayerGroup is used to group several layers and handle them as one
 *
 * @link https://leafletjs.com/reference.html#layergroup
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 */
class LayerGroup extends Layer implements LeafletInterface
{
    public function __construct(private array $layers, $options = [])
    {
        parent::__construct($options);
    }

    /**
     * Adds layers to the layer group
     *
     * @param array<Layer> $layers The layer(s) to add
     * @return self
     */
    public function addLayers(array $layers): self
    {
        $new = clone $this;
        $new->layers = array_merge($this->layers, $layers);

        return $new;
    }

    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        $layers = [];
        foreach ($this->layers as $layer) {
            $layer->addToMap(false); // the LayerGroup is added to the map, not individual layers
            $layers[] = $layer->toJs($leafletVar);
        }

        $classname = static::class;
        $name = lcfirst(substr($classname, strrpos($classname, '\\') + 1));

        return "$leafletVar.$name(" . '[' . implode(',', $layers) . ']' . ')'
            . $this->bind($leafletVar);
    }
}
