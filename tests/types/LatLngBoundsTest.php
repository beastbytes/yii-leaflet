<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\types;

use BeastBytes\Widgets\Leaflet\Map;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use BeastBytes\Widgets\Leaflet\types\LatLngBounds;
use PHPUnit\Framework\TestCase;

class LatLngBoundsTest extends TestCase
{
    public function test_Lat_lng_bounds()
    {
        $lat1 = random_int(-9000, 9000) / 100;
        $lng1 = random_int(-18000, 18000) / 100;
        $lat2 = random_int(-9000, 9000) / 100;
        $lng2 = random_int(-18000, 18000) / 100;
        $latLng1 = new LatLng($lat1, $lng1);
        $latLng2 = new LatLng($lat2, $lng2);

        $latLngBounds = new LatLngBounds($latLng1, $latLng2);
        $this->assertSame(
            Map::LEAFLET_VAR . ".latLngBounds("
            . Map::LEAFLET_VAR . ".latLng($lat1,$lng1),"
            . Map::LEAFLET_VAR . ".latLng($lat2,$lng2)"
            . ")",
            $latLngBounds->toJs(Map::LEAFLET_VAR)
        );

        $latLngBounds = new LatLngBounds($latLng1, $latLng2);
        $this->assertSame(
            Map::LEAFLET_VAR . ".latLngBounds("
            . Map::LEAFLET_VAR . ".latLng($lat1,$lng1),"
            . Map::LEAFLET_VAR . ".latLng($lat2,$lng2)"
            . ")",
            $latLngBounds->toJs(Map::LEAFLET_VAR)
        );

        $latLngBounds = new LatLngBounds([$lat1, $lng1], [$lat2, $lng2]);
        $this->assertSame(
            Map::LEAFLET_VAR . ".latLngBounds("
            . Map::LEAFLET_VAR . ".latLng($lat1,$lng1),"
            . Map::LEAFLET_VAR . ".latLng($lat2,$lng2)"
            . ")",
            $latLngBounds->toJs(Map::LEAFLET_VAR)
        );
    }
}
