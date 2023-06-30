<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\layers\other;

use BeastBytes\Widgets\Leaflet\layers\other\LayerGroup;
use BeastBytes\Widgets\Leaflet\layers\ui\Marker;
use BeastBytes\Widgets\Leaflet\types\Point;
use PHPUnit\Framework\TestCase;

class LayerGroupTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_layer_group()
    {
        $layers = [];

        $locations = [
            [51.749151, -4.913822],
            [51.7079864, -4.925951],
        ];

        foreach ($locations as $location) {
            $layers[] = new Marker($location, [
                'icon' => [
                    'iconAnchor' => new Point(12, 40),
                    'iconUrl' => "leaflet/images/marker-icon.png",
                    'shadowUrl' => 'leaflet/images/marker-shadow.png'
                ]
            ]);
        }

        $layerGroup = new LayerGroup($layers);

        $this->assertSame(
            self::LEAFLET_VAR . '.layerGroup(['
                . self::LEAFLET_VAR . '.marker(' . self::LEAFLET_VAR . '.latLng(51.749151,-4.913822),{'
                    . 'icon:' . self::LEAFLET_VAR . '.icon({'
                        . 'iconAnchor:' . self::LEAFLET_VAR . '.point(12,40),'
                        . 'iconUrl:"leaflet/images/marker-icon.png",'
                        . 'shadowUrl:"leaflet/images/marker-shadow.png"'
                    . '})'
                . '}),'
                . self::LEAFLET_VAR . '.marker(' . self::LEAFLET_VAR . '.latLng(51.7079864,-4.925951),{'
                    . 'icon:' . self::LEAFLET_VAR . '.icon({'
                        . 'iconAnchor:' . self::LEAFLET_VAR . '.point(12,40),'
                        . 'iconUrl:"leaflet/images/marker-icon.png",'
                        . 'shadowUrl:"leaflet/images/marker-shadow.png"'
                    . '})'
                . '})'
            . '])',
            $layerGroup->toJs(self::LEAFLET_VAR)
        );
    }
}
