<?php
/**
 * @copyright Copyright © 2022 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace Tests\controls;

use BeastBytes\Widgets\Leaflet\controls\AttributionControl;
use BeastBytes\Widgets\Leaflet\types\Point;
use PHPUnit\Framework\TestCase;

class AttributionControlTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_attribution_control()
    {
        $control = new AttributionControl();

        $this->assertSame(
            self::LEAFLET_VAR . ".control.attribution()",
            $control->toJs(self::LEAFLET_VAR)
        );
    }
}
