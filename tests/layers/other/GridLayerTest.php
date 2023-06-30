<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace Tests\layers\other;

use BeastBytes\Widgets\Leaflet\layers\other\GridLayer;
use PHPUnit\Framework\TestCase;

class GridLayerTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_grid_layer()
    {
        $updateInterval = random_int(100, 500);
        $gridLayer = new GridLayer(['updateInterval' => $updateInterval]);

        $this->assertSame(
            self::LEAFLET_VAR . ".gridLayer({updateInterval:$updateInterval})",
            $gridLayer->toJs(self::LEAFLET_VAR)
        );
    }
}
