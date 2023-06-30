<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\layers\vector;

use BeastBytes\Widgets\Leaflet\layers\vector\Polygon;
use BeastBytes\Widgets\Leaflet\Map;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use PHPUnit\Framework\TestCase;

class PolygonTest extends TestCase
{
    public function test_polygon()
    {
        $lat1 = random_int(-9000, 9000) / 100;
        $lng1 = random_int(-18000, 18000) / 100;
        $lat2 = random_int(-9000, 9000) / 100;
        $lng2 = random_int(-18000, 18000) / 100;
        $lat3 = random_int(-9000, 9000) / 100;
        $lng3 = random_int(-18000, 18000) / 100;
        $lat4 = random_int(-9000, 9000) / 100;
        $lng4 = random_int(-18000, 18000) / 100;
        $latLng1 = new LatLng($lat1, $lng1);
        $latLng2 = new LatLng($lat2, $lng2);
        $latLng3 = new LatLng($lat3, $lng3);
        $latLng4 = new LatLng($lat4, $lng4);
        $polygon = new Polygon([$latLng1, $latLng2, $latLng3, $latLng4], ['weight' => 2]);

        $this->assertSame(
            Map::LEAFLET_VAR . ".polygon(["
                . Map::LEAFLET_VAR . ".latLng($lat1,$lng1),"
                . Map::LEAFLET_VAR . ".latLng($lat2,$lng2),"
                . Map::LEAFLET_VAR . ".latLng($lat3,$lng3),"
                . Map::LEAFLET_VAR . ".latLng($lat4,$lng4)"
            . "],{weight:2})",
            $polygon->toJs(Map::LEAFLET_VAR)
        );
    }
}
