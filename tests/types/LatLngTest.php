<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\types;

use BeastBytes\Widgets\Leaflet\Map;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use PHPUnit\Framework\TestCase;

class LatLngTest extends TestCase
{
    public function test_lat_lng()
    {
        $lat = random_int(-9000, 9000) / 100;
        $lng = random_int(-18000, 18000) / 100;

        $latLng = new LatLng($lat, $lng);
        $this->assertSame(Map::LEAFLET_VAR . ".latLng($lat,$lng)", $latLng->toJs(Map::LEAFLET_VAR));

        $latLng = new LatLng([$lat, $lng]);
        $this->assertSame(Map::LEAFLET_VAR . ".latLng($lat,$lng)", $latLng->toJs(Map::LEAFLET_VAR));
    }
}
