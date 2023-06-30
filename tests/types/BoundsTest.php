<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace Tests\types;

use BeastBytes\Widgets\Leaflet\types\Bounds;
use BeastBytes\Widgets\Leaflet\types\Point;
use PHPUnit\Framework\TestCase;

class BoundsTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_bounds()
    {
        $x1 = random_int(0, 10000);
        $y1 = random_int(0, 10000);
        $x2 = random_int(0, 10000);
        $y2 = random_int(0, 10000);
        $point1 = new Point($x1, $y1);
        $point2 = new Point($x2, $y2);

        $bounds = new Bounds($point1, $point2);
        $this->assertSame(
            self::LEAFLET_VAR . ".bounds("
            . self::LEAFLET_VAR . ".point($x1,$y1),"
            . self::LEAFLET_VAR . ".point($x2,$y2)"
            . ")",
            $bounds->toJs(self::LEAFLET_VAR)
        );

        $bounds = new Bounds([$x1, $y1], [$x2, $y2]);
        $this->assertSame(
            self::LEAFLET_VAR . ".bounds("
            . self::LEAFLET_VAR . ".point($x1,$y1),"
            . self::LEAFLET_VAR . ".point($x2,$y2)"
            . ")",
            $bounds->toJs(self::LEAFLET_VAR)
        );
    }
}
