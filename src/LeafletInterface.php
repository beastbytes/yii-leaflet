<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet;

/**
 * LeafletInterface should be implemented by all Leaflet objects
 */
interface LeafletInterface
{
    /**
     * @param string $leafletVar
     * @return string Object JavaScript
     */
    public function toJs(string $leafletVar): string;
}