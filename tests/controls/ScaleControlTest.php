<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Tests\controls;

use BeastBytes\Yii\Leaflet\Controls\Scale;
use BeastBytes\Yii\Leaflet\Map;
use PHPUnit\Framework\TestCase;

class ScaleControlTest extends TestCase
{
    public function test_scale_control()
    {
        $control = new Scale();

        $this->assertSame(
            Map::LEAFLET_VAR . ".control.scale()",
            $control->toJs(Map::LEAFLET_VAR)
        );
    }
}