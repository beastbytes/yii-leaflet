<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\layers\raster;

use BeastBytes\Widgets\Leaflet\layers\raster\TileProvider;
use PHPUnit\Framework\TestCase;

class TileProviderTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_tile_provider()
    {
        $minZoom = 10;
        $tileLayer = (new TileProvider())->use('OpenStreetMap', ['minZoom' => $minZoom]);

        $this->assertSame(
            self::LEAFLET_VAR . '.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",'
            . '{'
                . 'maxZoom:19,'
                . 'attribution:"&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors",'
                . "minZoom:$minZoom"
            . '})',
            $tileLayer->toJs(self::LEAFLET_VAR)
        );
    }
}
