<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Tests\layers\other;

use BeastBytes\Yii\Leaflet\Layers\Other\GeoJson;
use BeastBytes\Yii\Leaflet\Map;
use PHPUnit\Framework\TestCase;

class GeoJsonTest extends TestCase
{
    public function test_geo_json_with_data()
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
            Map::LEAFLET_VAR . '.geoJson({"type":"Feature","properties":'
            . '{"name":"Twickenham Stadium","amenity":"Rugby Union Stadium","popupContent":"The home of English Rugby"},'
            . '"geometry":{"type":"Point","coordinates":[51.45517,-0.33873]}})',
            $geoJson->toJs(Map::LEAFLET_VAR)
        );
    }
}