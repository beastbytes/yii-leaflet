<?php
/**
 * @copyright Copyright © 2022 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace Tests\controls;

use BeastBytes\Widgets\Leaflet\controls\ZoomControl;
use BeastBytes\Widgets\Leaflet\types\Point;
use PHPUnit\Framework\TestCase;

class ZoomControlTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_zoom_control()
    {
        $control = new ZoomControl();

        $this->assertSame(
            self::LEAFLET_VAR . ".control.zoom()",
            $control->toJs(self::LEAFLET_VAR)
        );
    }
}
