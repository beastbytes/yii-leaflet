<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\layers\vector;

use BeastBytes\Widgets\Leaflet\layers\vector\Polyline;
use BeastBytes\Widgets\Leaflet\Map;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PolylineTest extends TestCase
{
    /*
    public function test_polyline()
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
        $polyline = new Polyline([$latLng1, $latLng2, $latLng3, $latLng4], ['weight' => 2]);

        $this->assertSame(
            Map::LEAFLET_VAR . ".polyline(["
            . Map::LEAFLET_VAR . ".latLng($lat1,$lng1),"
            . Map::LEAFLET_VAR . ".latLng($lat2,$lng2),"
            . Map::LEAFLET_VAR . ".latLng($lat3,$lng3),"
            . Map::LEAFLET_VAR . ".latLng($lat4,$lng4)"
            . "],{weight:2})",
            $polyline->toJs(Map::LEAFLET_VAR)
        );
    }
    */

    #[DataProvider('locationsProvider')]
    public function test_polyline($location1, $location2, $location3, $location4, $str)
    {
        $polyline = new Polyline([$location1, $location2, $location3, $location4], ['weight' => 2]);

        $this->assertSame(
            Map::LEAFLET_VAR . ".polyline([$str],{weight:2})",
            $polyline->toJs(Map::LEAFLET_VAR)
        );
    }

    public static function locationsProvider(): Generator
    {
        for ($i = 0; $i < 16; $i++) {
            ${"lat$i"} = random_int(-9000, 9000) / 100;
            ${"lng$i"} = random_int(-18000, 18000) / 100;
        }

        $lineStr = Map::LEAFLET_VAR . ".latLng($lat0,$lng0),"
            . Map::LEAFLET_VAR . ".latLng($lat1,$lng1),"
            . Map::LEAFLET_VAR . ".latLng($lat2,$lng2),"
            . Map::LEAFLET_VAR . ".latLng($lat3,$lng3)";

        $multilineStr = '[' . Map::LEAFLET_VAR . ".latLng($lat0,$lng0),"
            . Map::LEAFLET_VAR . ".latLng($lat1,$lng1),"
            . Map::LEAFLET_VAR . ".latLng($lat2,$lng2),"
            . Map::LEAFLET_VAR . ".latLng($lat3,$lng3)],"
            . '[' . Map::LEAFLET_VAR . ".latLng($lat4,$lng4),"
            . Map::LEAFLET_VAR . ".latLng($lat5,$lng5),"
            . Map::LEAFLET_VAR . ".latLng($lat6,$lng6),"
            . Map::LEAFLET_VAR . ".latLng($lat7,$lng7)],"
            . '[' . Map::LEAFLET_VAR . ".latLng($lat8,$lng8),"
            . Map::LEAFLET_VAR . ".latLng($lat9,$lng9),"
            . Map::LEAFLET_VAR . ".latLng($lat10,$lng10),"
            . Map::LEAFLET_VAR . ".latLng($lat11,$lng11)],"
            . '[' . Map::LEAFLET_VAR . ".latLng($lat12,$lng12),"
            . Map::LEAFLET_VAR . ".latLng($lat13,$lng13),"
            . Map::LEAFLET_VAR . ".latLng($lat14,$lng14),"
            . Map::LEAFLET_VAR . ".latLng($lat15,$lng15)]"
        ;

        foreach([
            'arrays' => [
                'location1' => [$lat0, $lng0],
                'location2' => [$lat1, $lng1],
                'location3' => [$lat2, $lng2],
                'location4' => [$lat3, $lng3],
            ],
            'LatLngs' => [
                'location1' => new LatLng($lat0, $lng0),
                'location2' => new LatLng($lat1, $lng1),
                'location3' => new LatLng($lat2, $lng2),
                'location4' => new LatLng($lat3, $lng3),
            ],
            'multiline' => [
                'location1' => [
                    [$lat0, $lng0],
                    [$lat1, $lng1],
                    [$lat2, $lng2],
                    [$lat3, $lng3],
                ],
                'location2' => [
                    [$lat4, $lng4],
                    [$lat5, $lng5],
                    [$lat6, $lng6],
                    [$lat7, $lng7],
                ],
                'location3' => [
                    [$lat8, $lng8],
                    [$lat9, $lng9],
                    [$lat10, $lng10],
                    [$lat11, $lng11],
                ],
                'location4' => [
                    [$lat12, $lng12],
                    [$lat13, $lng13],
                    [$lat14, $lng14],
                    [$lat15, $lng15],
                ],
            ]
        ] as $name => $line) {
            if ($name === 'multiline') {
                $line['str'] = $multilineStr;
            } else {
                $line['str'] = $lineStr;
            }

            yield $name => $line;
        }
    }
}
