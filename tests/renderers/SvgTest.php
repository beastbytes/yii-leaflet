<?php
/**
 * @copyright Copyright © 2022 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace Tests\renderers;

use BeastBytes\Widgets\Leaflet\renderers\Svg;
use BeastBytes\Widgets\Leaflet\types\Point;
use PHPUnit\Framework\TestCase;

class SvgTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_svg_renderer()
    {
        $renderer = new Svg();
        $this->assertSame(self::LEAFLET_VAR . ".svg()", $renderer->toJs(self::LEAFLET_VAR));
    }
}
