<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\layers\ui;

use BeastBytes\Widgets\Leaflet\layers\ui\Marker;
use BeastBytes\Widgets\Leaflet\types\Icon;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use BeastBytes\Widgets\Leaflet\types\Point;
use PHPUnit\Framework\TestCase;

class MarkerTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_marker()
    {
        $lat = random_int(-9000, 9000) / 100;
        $lng = random_int(-18000, 18000) / 100;
        $latLng = new LatLng($lat, $lng);
        $marker = new Marker($latLng, [
            'icon' => [
                'iconAnchor' => new Point(12, 40),
                'iconUrl' => "leaflet/images/marker-icon.png",
                'shadowUrl' => 'leaflet/images/marker-shadow.png'
            ],
            'riseOnHover' => true
        ]);

        $this->assertSame(
            self::LEAFLET_VAR . '.marker(' . self::LEAFLET_VAR . ".latLng($lat,$lng),"
                . '{'
                    . 'icon:' . self::LEAFLET_VAR . '.icon({'
                        . 'iconAnchor:' . self::LEAFLET_VAR . '.point(12,40),'
                        . 'iconUrl:"leaflet/images/marker-icon.png",'
                        . 'shadowUrl:"leaflet/images/marker-shadow.png"'
                    . '}),'
                    . 'riseOnHover:true'
                . '}'
            . ')',
            $marker->toJs(self::LEAFLET_VAR)
        );
    }
}
