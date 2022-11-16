<?php
/**
 * @copyright Copyright © 2022 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace Tests\layers\other;

use BeastBytes\Widgets\Leaflet\layers\other\GeoJson;
use PHPUnit\Framework\TestCase;

class GeoJsonTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_geo_json()
    {
        $data = [
            'type' => 'Feature',
            'properties' => [
                'name' => 'Twickenham Stadium',
                'amenity' => 'Rugby Union Stadium',
                'popupContent' => 'The home of English Rugby'
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [51.45517,-0.33873]
            ]
        ];

        $geoJson = new GeoJson($data);

        $this->assertSame(
            self::LEAFLET_VAR . '.geoJson({"type":"Feature","properties":'
                . '{"name":"Twickenham Stadium","amenity":"Rugby Union Stadium","popupContent":"The home of English Rugby"},'
                . '"geometry":{"type":"Point","coordinates":[51.45517,-0.33873]}})',
            $geoJson->toJs(self::LEAFLET_VAR)
        );
    }
}
