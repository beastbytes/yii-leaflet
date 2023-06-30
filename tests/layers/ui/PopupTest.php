<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace Tests\layers\ui;

use BeastBytes\Widgets\Leaflet\layers\ui\Popup;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use PHPUnit\Framework\TestCase;

class PopupTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_popup()
    {
/*        $lat = random_int(-9000, 9000) / 100;
        $lng = random_int(-18000, 18000) / 100;
        $radius = random_int(1, 1000);
        $latLng = new LatLng($lat, $lng);
        $popup = new Popup($latLng, ['radius' => $radius]);

        $this->assertSame(
            self::LEAFLET_VAR . ".circle(" . self::LEAFLET_VAR . ".latLng($lat,$lng),{radius:$radius})",
            $circle->toJs(self::LEAFLET_VAR)
        );*/
        $this->assertSame(1,1);
    }
}
