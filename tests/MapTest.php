<?php
/**
 * @copyright Copyright © 2022 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace Tests;

use BeastBytes\Widgets\Leaflet\Map;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use PHPUnit\Framework\TestCase;
use Tests\support\TestTrait;
use Yiisoft\Definitions\Exception\InvalidConfigException;

class MapTest extends TestCase
{
    use TestTrait;

    const LEAFLET_VAR = 'L';

    public function test_no_center()
    {
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage("`options['center']` must be set");
        Map::widget()
            ->render();
    }

    public function test_no_zoom()
    {
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage("`options['zoom']` must be set");

        $centre = new LatLng(0, 0);
        Map::widget()
            ->options([
                'center' => $centre
            ])
            ->render();
    }

    public function test_no_height()
    {
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage("`attributes['style']` must be set and define the height of the map");

        $centre = new LatLng(0, 0);
        Map::widget()
            ->options([
                'center' => $centre,
                'zoom' => 10
           ])
           ->render();
    }

    public function test_correct_config()
    {
        $centre = new LatLng(0, 0);
        $map = Map::widget()
            ->attributes(['style' => 'height:800px;'])
            ->options([
                'center' => $centre,
                'zoom' => 10
            ]);

        $this->assertSame('<div id="map0" style="height:800px;"></div>', $map->render());
        $this->assertSame(
            'function fmap0(){const map0=L.map("map0",{center:L.latLng(0,0),zoom:10});}fmap0();',
            $map->getJs()
        );
    }
}
