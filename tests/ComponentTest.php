<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Tests;

use BeastBytes\Yii\Leaflet\Controls\Zoom;
use BeastBytes\Yii\Leaflet\Map;
use BeastBytes\Yii\Leaflet\Tests\support\plugins\TestPlugin;
use BeastBytes\Yii\Leaflet\Tests\support\TestTrait;
use PHPUnit\Framework\TestCase;
use Yiisoft\Strings\Inflector;

class ComponentTest extends TestCase
{
    use TestTrait;

    public function test_set_js_var()
    {
        $jsVar = 'jsVar';
        $lat = 51.5032359;
        $lng = -0.127242;

        $map = Map::widget()
            ->attributes(['style' => 'height:800px;'])
            ->options([
                'center' => [$lat, $lng],
                'zoom' => 10
            ])
            ->addControls(
                (new Zoom())->jsVar($jsVar)
            );

        $content = $map->render();
        $this->assertStringMatchesFormat(
            sprintf('<div id="%s" style="height:800px;"></div>', $map->getId()),
            $content
        );

        $html = $this->view->render( '//view.php', ['content' => $content]);

        $this->assertStringContainsString(
            sprintf(
                'const %s=%s.map("%s",{center:%2$s.latLng(%s,%s),zoom:10});const %s=%2$s.control.zoom().addTo(%s);',
                (new Inflector())->toSnakeCase($map->getId()),
                $map->getLeafletVar(),
                $map->getId(),
                $lat,
                $lng,
                $jsVar,
                $map->getId()
            ),
            $html
        );
    }

    public function test_plugin()
    {
        $lat = 51.5032359;
        $lng = -0.127242;
        $centre = [$lat, $lng];

        $map = Map::widget()
            ->attributes(['style' => 'height:800px;'])
            ->addPlugins(new TestPlugin())
            ->options([
                'center' => $centre,
                'zoom' => 10
            ]);

        $content = $map->render();
        $this->assertStringMatchesFormat(
            sprintf('<div id="%s" style="height:800px;"></div>', $map->getId()),
            $content
        );

        $html = $this->view->render( '//view.php', ['content' => $content]);

        $this->assertStringContainsString(
            sprintf(
                'const %s=%s.map("%s",{center:%2$s.latLng(%s,%s),zoom:10});const plugin0=%2$s.testPlugin().addTo(%s);',
                (new Inflector())->toSnakeCase($map->getId()),
                $map->getLeafletVar(),
                $map->getId(),
                $lat,
                $lng,
                $map->getId()
            ),
            $html
        );
    }
}