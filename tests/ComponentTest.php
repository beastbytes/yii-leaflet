<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests;

use BeastBytes\Widgets\Leaflet\controls\ZoomControl;
use BeastBytes\Widgets\Leaflet\Map;
use BeastBytes\Widgets\Leaflet\Tests\support\plugins\TestPlugin;
use BeastBytes\Widgets\Leaflet\Tests\support\TestTrait;
use PHPUnit\Framework\TestCase;

class ComponentTest extends TestCase
{
    use TestTrait;

    public function test_set_js_var()
    {
        $jsVar = 'jsVar';
        $lat = 51.5032359;
        $lng = -0.127242;
        $centre = [$lat, $lng];

        $map = Map::widget()
            ->attributes(['style' => 'height:800px;'])
            ->options([
                'center' => $centre,
                'zoom' => 10
            ])
            ->addControls(
                (new ZoomControl())->jsVar($jsVar)
            );

        $content = $map->render();
        $this->assertStringMatchesFormat(
            '<div id="' . Map::ID_PREFIX . '%d" style="height:800px;"></div>',
            $content
        );

        $html = $this->webView->render( '/layout.php', ['content' => $content]);
        $matches = [];
        preg_match('/id="(' . Map::ID_PREFIX . '\d+)"/', $html, $matches);
        $id = $matches[1];

        $this->assertStringContainsString(
            "const $id="
            . Map::LEAFLET_VAR . '.map("' . $id . '",{center:' . Map::LEAFLET_VAR . ".latLng($lat,$lng),zoom:10});"
            . "const $jsVar=L.control.zoom().addTo($id);",
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
            '<div id="' . Map::ID_PREFIX . '%d" style="height:800px;"></div>',
            $content
        );

        $html = $this->webView->render( '/layout.php', ['content' => $content]);
        $matches = [];
        preg_match('/id="(' . Map::ID_PREFIX . '\d+)"/', $html, $matches);
        $id = $matches[1];

        $this->assertStringContainsString(
            'const ' . $id . '='
            . Map::LEAFLET_VAR . '.map("' . $id . '",{center:' . Map::LEAFLET_VAR . ".latLng($lat,$lng),zoom:10});"
            . "const plugin0=L.testPlugin().addTo($id);",
            $html
        );
    }
}
