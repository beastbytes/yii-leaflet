<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests\layers\ui;

use BeastBytes\Widgets\Leaflet\layers\ui\Popup;
use BeastBytes\Widgets\Leaflet\Map;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use PHPUnit\Framework\TestCase;

class PopupTest extends TestCase
{
    private const POPUP_CONTENT = "Popup content";

    public function test_popup()
    {
        $lat = random_int(-9000, 9000) / 100;
        $lng = random_int(-18000, 18000) / 100;
        $latLng = new LatLng($lat, $lng);
        $popup = new Popup(self::POPUP_CONTENT, $latLng);

        $this->assertSame(
            Map::LEAFLET_VAR . '.popup()'
            . ".setContent('" . self::POPUP_CONTENT . "')"
            . ".setLatLng(" . Map::LEAFLET_VAR . ".latLng($lat,$lng))",
            $popup->toJs(Map::LEAFLET_VAR)
        );
    }
}
