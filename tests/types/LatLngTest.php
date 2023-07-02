<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\types;

use BeastBytes\Widgets\Leaflet\Map;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
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

    public function test_lat_lng_alt()
    {
        $alt = random_int(-10000, 10000) / 10;
        $lat = random_int(-9000, 9000) / 100;
        $lng = random_int(-18000, 18000) / 100;

        $latLng = new LatLng($lat, $lng, $alt);
        $this->assertSame(
            Map::LEAFLET_VAR . ".latLng($lat,$lng,$alt)",
            $latLng->toJs(Map::LEAFLET_VAR)
        );

        $latLng = new LatLng([$lat, $lng, $alt]);
        $this->assertSame(
            Map::LEAFLET_VAR . ".latLng($lat,$lng,$alt)",
            $latLng->toJs(Map::LEAFLET_VAR)
        );
    }

    #[DataProvider('badLatLngProvider')]
    public function test_bad_lat_lng($lat, $lng, $message)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($message);
        new LatLng($lat, $lng);
    }

    public static function badLatLngProvider(): Generator
    {
        foreach ([
            'lat too low' => [
                'lat' => -91,
                'lng' => random_int(-18000, 18000) / 100,
                'message' => strtr(LatLng::INVALID_LATITUDE_MESSAGE, ['{value}' => -91])
            ],
            'lat too high' => [
                'lat' => 91,
                'lng' => random_int(-18000, 18000) / 100,
                'message' => strtr(LatLng::INVALID_LATITUDE_MESSAGE, ['{value}' => 91])
            ],
            'lng too low' => [
                'lat' => random_int(-9000, 9000) / 100,
                'lng' => -181,
                'message' => strtr(LatLng::INVALID_LONGITUDE_MESSAGE, ['{value}' => -181])
            ],
            'lng too high' => [
                'lat' => random_int(-9000, 9000) / 100,
                'lng' => 181,
                'message' => strtr(LatLng::INVALID_LONGITUDE_MESSAGE, ['{value}' => 181])
            ],
        ] as $name => $data) {
            yield $name => $data;
        }
    }
}
