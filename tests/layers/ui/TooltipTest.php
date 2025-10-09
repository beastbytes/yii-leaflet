<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Tests\layers\ui;

use BeastBytes\Yii\Leaflet\layers\ui\Tooltip;
use BeastBytes\Yii\Leaflet\Map;
use PHPUnit\Framework\TestCase;

class TooltipTest extends TestCase
{
    public function test_tooltip()
    {
        $content = 'Tooltip content';
        $tooltip = new Tooltip($content, ['opacity' => 0.75]);

        $this->assertSame(
            Map::LEAFLET_VAR . '.tooltip({opacity:0.75})'
            . ".setContent('$content')",
            $tooltip->toJs(Map::LEAFLET_VAR)
        );
    }
}