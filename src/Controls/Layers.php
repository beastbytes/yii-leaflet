<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Controls;

use BeastBytes\Yii\Leaflet\LayersInterface;
use JetBrains\PhpStorm\ArrayShape;
use JsonException;

/**
 * Represents a layers control
 *
 * @link https://leafletjs.com/reference.html#control-layers
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 */
final class Layers extends Control implements LayersInterface
{
    /**
     * @param list<string> $baseLayers Labels of the base layers
     * @param list<string> $overlays Labels of overlay layers
     * @param array<string, mixed> $options
     */
    public function __construct(private array $baseLayers = [], private array $overlays = [], array $options = [])
    {
        parent::__construct($options);
    }

    /**
     * @return array
     * @internal
     */
    public function getBaseLayers(): array
    {
        return $this->baseLayers;
    }

    /**
     * @return array
     * @internal
     */
    public function getOverlays(): array
    {
        return $this->overlays;
    }

    /**
     * @param array $layers Base Layers as ['label' => 'layerJsVar']
     * @return \BeastBytes\Yii\Leaflet\LayersInterface
     * @internal
     */
    #[ArrayShape(["string" => "string"])]
    public function setBaseLayers(array $layers): LayersInterface
    {
        $this->baseLayers = $layers;
        return $this;
    }

    /**
     * @param array $layers Overlays as ['label' => 'layerJsVar']
     * @return \BeastBytes\Yii\Leaflet\LayersInterface
     * @internal
     */
    #[ArrayShape(["string" => "string"])]
    public function setOverlays(array $layers): LayersInterface
    {
        $this->overlays = $layers;
        return $this;
    }

    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        $baseLayers = empty($this->baseLayers) ? 'null' : $this->jsonEncode($this->baseLayers);
        $overlays = empty($this->overlays) ? 'null' : $this->jsonEncode($this->overlays);
        $options = $this->options2Js($leafletVar);

        return "$leafletVar.control.layers($baseLayers,$overlays" . (!empty($options) ? ",$options" : '') . ')';
    }

    private function jsonEncode(array $layers): string
    {
        $json = [];

        foreach ($layers as $label => $layer) {
            $json[] = "\"$label\":$layer";
        }

        return '{' . implode(',', $json) . '}';
    }
}