<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\types;

use BeastBytes\Widgets\Leaflet\Map;
use BeastBytes\Widgets\Leaflet\types\DivIcon;
use PHPUnit\Framework\TestCase;

class DivIconTest extends TestCase
{
    public function test_div_icon()
    {
        $divIcon = new DivIcon();

        $this->assertSame(
            Map::LEAFLET_VAR . '.divIcon()',
            $divIcon->toJs(Map::LEAFLET_VAR));
    }
}
