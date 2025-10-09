<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Tests\layers\raster;

use BeastBytes\Yii\Leaflet\layers\raster\WmsTileLayer;
use BeastBytes\Yii\Leaflet\Map;
use PHPUnit\Framework\TestCase;

class WmsTileLayerTest extends TestCase
{
    public function test_wms_tile_layer()
    {
        $url = 'https://example.com/tiles/wms';
        $layers = 'layer1,layer2';

        $wmsTileLayer = new WmsTileLayer($url, ['layers' => $layers]);

        $this->assertSame(
            Map::LEAFLET_VAR . ".tileLayer.wms(\"$url\",{layers:\"$layers\"})",
            $wmsTileLayer->toJs(Map::LEAFLET_VAR)
        );
    }
}