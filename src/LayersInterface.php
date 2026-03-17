<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet;

use JetBrains\PhpStorm\ArrayShape;

/**
 * LayerInterface should be implemented by Leaflet objects that are aware of layers
 */
interface LayersInterface
{
    /**
     * Return the labels of the base layers
     *
     * @return string[];
     */
    public function getBaseLayers(): array;

    /**
     * Return the labels of the overlays
     *
     * @return string[];
     */
    public function getOverlays(): array;

    /**
     * @param array $layers Base Layers as ['label' => 'layerJsVar']
     * @return self
     */
    #[ArrayShape(["string" => "string"])]
    public function setBaseLayers(array $layers): self;

    /**
     * @param array $layers Overlays as ['label' => 'layerJsVar']
     * @return self
     */
    #[ArrayShape(["string" => "string"])]
    public function setOverlays(array $layers): self;
}