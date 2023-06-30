<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\controls;

use BeastBytes\Widgets\Leaflet\controls\AttributionControl;
use BeastBytes\Widgets\Leaflet\Map;
use PHPUnit\Framework\TestCase;

class AttributionControlTest extends TestCase
{
    public function test_attribution_control()
    {
        $control = new AttributionControl();

        $this->assertSame(
            Map::LEAFLET_VAR . ".control.attribution()",
            $control->toJs(Map::LEAFLET_VAR)
        );
    }
}
