<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace Tests\types;

use BeastBytes\Widgets\Leaflet\types\Bounds;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use BeastBytes\Widgets\Leaflet\types\LatLngBounds;
use BeastBytes\Widgets\Leaflet\types\Point;
use PHPUnit\Framework\TestCase;

class LatLngBoundsTest extends TestCase
{
    const LEAFLET_VAR = 'L';

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
            self::LEAFLET_VAR . ".latLngBounds("
            . self::LEAFLET_VAR . ".latLng($lat1,$lng1),"
            . self::LEAFLET_VAR . ".latLng($lat2,$lng2)"
            . ")",
            $latLngBounds->toJs(self::LEAFLET_VAR)
        );

        $latLngBounds = new LatLngBounds($latLng1, $latLng2);
        $this->assertSame(
            self::LEAFLET_VAR . ".latLngBounds("
            . self::LEAFLET_VAR . ".latLng($lat1,$lng1),"
            . self::LEAFLET_VAR . ".latLng($lat2,$lng2)"
            . ")",
            $latLngBounds->toJs(self::LEAFLET_VAR)
        );

        $latLngBounds = new LatLngBounds([$lat1, $lng1], [$lat2, $lng2]);
        $this->assertSame(
            self::LEAFLET_VAR . ".latLngBounds("
            . self::LEAFLET_VAR . ".latLng($lat1,$lng1),"
            . self::LEAFLET_VAR . ".latLng($lat2,$lng2)"
            . ")",
            $latLngBounds->toJs(self::LEAFLET_VAR)
        );
    }
}
