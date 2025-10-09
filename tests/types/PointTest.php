<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Tests\types;

use BeastBytes\Yii\Leaflet\Map;
use BeastBytes\Yii\Leaflet\types\Point;
use PHPUnit\Framework\TestCase;

class PointTest extends TestCase
{
    public function test_point()
    {
        $x = random_int(0, 10000);
        $y = random_int(0, 10000);
        $point = new Point($x, $y);

        $this->assertSame(Map::LEAFLET_VAR . ".point($x,$y)", $point->toJs(Map::LEAFLET_VAR));
    }
}