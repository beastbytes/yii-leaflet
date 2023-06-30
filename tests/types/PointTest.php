<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace Tests\types;

use BeastBytes\Widgets\Leaflet\types\Point;
use PHPUnit\Framework\TestCase;

class PointTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_point()
    {
        $x = random_int(0, 10000);
        $y = random_int(0, 10000);
        $point = new Point($x, $y);

        $this->assertSame(self::LEAFLET_VAR . ".point($x,$y)", $point->toJs(self::LEAFLET_VAR));
    }
}
