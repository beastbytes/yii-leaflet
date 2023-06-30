<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\renderers;

use BeastBytes\Widgets\Leaflet\renderers\Canvas;
use BeastBytes\Widgets\Leaflet\types\Point;
use PHPUnit\Framework\TestCase;

class CanvasTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_canvas_renderer()
    {
        $renderer = new Canvas();
        $this->assertSame(self::LEAFLET_VAR . ".canvas()", $renderer->toJs(self::LEAFLET_VAR));
    }
}
