<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\layers\raster;

use BeastBytes\Widgets\Leaflet\layers\raster\TileProvider;
use BeastBytes\Widgets\Leaflet\Map;
use PHPUnit\Framework\TestCase;

class TileProviderTest extends TestCase
{
    public function test_tile_provider()
    {
        $minZoom = 10;
        $tileLayer = (new TileProvider())->use('OpenStreetMap', ['minZoom' => $minZoom]);

        $this->assertSame(
            Map::LEAFLET_VAR . '.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",'
            . '{'
            . 'maxZoom:19,'
            . 'attribution:"&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors",'
            . "minZoom:$minZoom"
            . '})',
            $tileLayer->toJs(Map::LEAFLET_VAR)
        );
    }

    public function test_tile_provider_array_variant()
    {
        $minZoom = 10;
        $tileLayer = (new TileProvider())->use('OpenStreetMap.France', ['minZoom' => $minZoom]);

        $this->assertSame(
            Map::LEAFLET_VAR . '.tileLayer("https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png",'
            . '{'
            . 'maxZoom:20,'
            . 'attribution:"&copy; OpenStreetMap France | '
            . '&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors",'
            . "minZoom:$minZoom"
            . '})',
            $tileLayer->toJs(Map::LEAFLET_VAR)
        );
    }

    public function test_tile_provider_string_variant()
    {
        $minZoom = 10;
        $tileLayer = (new TileProvider())->use('Thunderforest.OpenCycleMap', ['minZoom' => $minZoom]);

        $this->assertSame(
            Map::LEAFLET_VAR . '.tileLayer("https://{s}.tile.thunderforest.com/{variant}/{z}/{x}/{y}.png?apikey={apikey}",'
            . '{'
            . 'attribution:"&copy; <a href=\"http://www.thunderforest.com/\">Thunderforest</a>, '
            . '&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors",'
            . 'variant:"cycle",'
            . 'apikey:"<insert your api key here>",'
            . 'maxZoom:22,'
            . "minZoom:$minZoom"
            . '})',
            $tileLayer->toJs(Map::LEAFLET_VAR)
        );
    }

    public function test_force_http()
    {
        $minZoom = 10;
        $tileProvider = [
            'TestProvider' => [
                'url' => '//{s}.tile.testprovider.example.com/{z}/{x}/{y}.png',
                'options' => [
                    'maxZoom' => 19,
                    'attribution' =>
                        '&copy; <a href="http://testprovider.example.com/copyright">TestProvider</a>'
                ],
            ]
        ];

        $tileLayer = (new TileProvider($tileProvider))
            ->use('TestProvider', ['minZoom' => $minZoom], TileProvider::FORCE_HTTP)
        ;

        $this->assertSame(
            Map::LEAFLET_VAR . '.tileLayer("http://{s}.tile.testprovider.example.com/{z}/{x}/{y}.png",'
            . '{'
            . 'maxZoom:19,'
            . 'attribution:"&copy; <a href=\"http://testprovider.example.com/copyright\">TestProvider</a>",'
            . "minZoom:$minZoom"
            . '})',
            $tileLayer->toJs(Map::LEAFLET_VAR)
        );
    }
}
