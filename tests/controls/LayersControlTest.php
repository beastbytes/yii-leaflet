<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\controls;

use BeastBytes\Widgets\Leaflet\controls\LayersControl;
use BeastBytes\Widgets\Leaflet\layers\ui\Marker;
use PHPUnit\Framework\TestCase;

class LayersControlTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_layers_control()
    {
        $overlays = [
            'Marker' => 'marker'
        ];

        $control = new LayersControl(overlays: array_keys($overlays), options: ['hideSingleBase' => true]);
        $control->setOverlays($overlays);

        $this->assertSame(
            self::LEAFLET_VAR . '.control.layers(null,{"Marker":marker},{hideSingleBase:true})',
            $control->toJs(self::LEAFLET_VAR)
        );
    }
}
