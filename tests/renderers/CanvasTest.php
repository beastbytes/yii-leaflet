<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Tests\renderers;

use BeastBytes\Yii\Leaflet\Map;
use BeastBytes\Yii\Leaflet\Renderers\Canvas;
use PHPUnit\Framework\TestCase;

class CanvasTest extends TestCase
{
    public function test_canvas_renderer()
    {
        $renderer = new Canvas();
        $this->assertSame(Map::LEAFLET_VAR . ".canvas()", $renderer->toJs(Map::LEAFLET_VAR));
    }
}