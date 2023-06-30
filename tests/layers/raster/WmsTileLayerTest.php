<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace Tests\layers\raster;

use BeastBytes\Widgets\Leaflet\layers\raster\WmsTileLayer;
use PHPUnit\Framework\TestCase;

class WmsTileLayerTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_wms_tile_layer()
    {
        $url = 'https://example.com/tiles/wms';
        $layers = 'layer1,layer2';

        $wmsTileLayer = new WmsTileLayer($url, ['layers' => $layers]);

        $this->assertSame(
            self::LEAFLET_VAR . ".tileLayer.wms(\"$url\",{layers:\"$layers\"})",
            $wmsTileLayer->toJs(self::LEAFLET_VAR)
        );
    }
}
