<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\layers\other;

use BeastBytes\Widgets\Leaflet\layers\other\GridLayer;
use BeastBytes\Widgets\Leaflet\Map;
use PHPUnit\Framework\TestCase;

class GridLayerTest extends TestCase
{
    public function test_grid_layer()
    {
        $updateInterval = random_int(100, 500);
        $gridLayer = new GridLayer(['updateInterval' => $updateInterval]);

        $this->assertSame(
            Map::LEAFLET_VAR . ".gridLayer({updateInterval:$updateInterval})",
            $gridLayer->toJs(Map::LEAFLET_VAR)
        );
    }
}
