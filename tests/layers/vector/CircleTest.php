<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\layers\vector;

use BeastBytes\Widgets\Leaflet\layers\vector\Circle;
use BeastBytes\Widgets\Leaflet\Map;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use PHPUnit\Framework\TestCase;

class CircleTest extends TestCase
{
    public function test_circle()
    {
        $lat = random_int(-9000, 9000) / 100;
        $lng = random_int(-18000, 18000) / 100;
        $radius = random_int(1, 1000);
        $latLng = new LatLng($lat, $lng);
        $circle = new Circle($latLng, ['radius' => $radius]);

        $this->assertSame(
            Map::LEAFLET_VAR . ".circle(" . Map::LEAFLET_VAR . ".latLng($lat,$lng),{radius:$radius})",
            $circle->toJs(Map::LEAFLET_VAR)
        );
    }
}
