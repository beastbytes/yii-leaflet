<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace Tests\controls;

use BeastBytes\Widgets\Leaflet\controls\ScaleControl;
use BeastBytes\Widgets\Leaflet\types\Point;
use PHPUnit\Framework\TestCase;

class ScaleControlTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_scale_control()
    {
        $control = new ScaleControl();

        $this->assertSame(
            self::LEAFLET_VAR . ".control.scale()",
            $control->toJs(self::LEAFLET_VAR)
        );
    }
}
