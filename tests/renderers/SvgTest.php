<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\renderers;

use BeastBytes\Widgets\Leaflet\Map;
use BeastBytes\Widgets\Leaflet\renderers\Svg;
use PHPUnit\Framework\TestCase;

class SvgTest extends TestCase
{
    public function test_svg_renderer()
    {
        $renderer = new Svg();
        $this->assertSame(Map::LEAFLET_VAR . ".svg()", $renderer->toJs(Map::LEAFLET_VAR));
    }
}
