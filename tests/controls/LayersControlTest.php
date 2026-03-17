<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Tests\controls;

use BeastBytes\Yii\Leaflet\Controls\Layers;
use BeastBytes\Yii\Leaflet\Map;
use PHPUnit\Framework\TestCase;

class LayersControlTest extends TestCase
{
    public function test_layers_control()
    {
        $overlays = [
            'Marker' => 'marker'
        ];

        $control = new Layers(overlays: array_keys($overlays), options: ['hideSingleBase' => true]);
        $control->setOverlays($overlays);

        $this->assertSame(
            Map::LEAFLET_VAR . '.control.layers(null,{"Marker":marker},{hideSingleBase:true})',
            $control->toJs(Map::LEAFLET_VAR)
        );
    }
}