<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace Tests\layers\vector;

use BeastBytes\Widgets\Leaflet\layers\vector\SvgOverlay;
use BeastBytes\Widgets\Leaflet\types\Bounds;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use BeastBytes\Widgets\Leaflet\types\LatLngBounds;
use PHPUnit\Framework\TestCase;

class SvgOverlayTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_svg_overlay()
    {
        $innerHtml = '<rect width="200" height="200"/><rect x="75" y="23" width="50" height="50" style="fill:red"/><rect x="75" y="123" width="50" height="50" style="fill:#0013ff"/>';
        $viewBox = '0 0 200 200';
        $lat1 = random_int(-9000, 9000) / 100;
        $lng1 = random_int(-18000, 18000) / 100;
        $lat2 = random_int(-9000, 9000) / 100;
        $lng2 = random_int(-18000, 18000) / 100;
        $latLng1 = new LatLng($lat1, $lng1);
        $latLng2 = new LatLng($lat2, $lng2);

        $latLngBounds = new LatLngBounds($latLng1, $latLng2);
        $svgOverlay = new SvgOverlay($innerHtml, $viewBox, $latLngBounds, ['alt' => 'svgOverlay']);

        $this->assertSame(
            'const svgElement0=document.createElementNS("http://www.w3.org/2000/svg","svg");'
            . 'svgElement0.setAttribute("xmlns","http://www.w3.org/2000/svg");'
            . 'svgElement0.setAttribute("viewBox","' . $viewBox . '");'
            . "svgElement0.innerHTML='$innerHtml';"
            . self::LEAFLET_VAR . '.svgOverlay(svgElement0,'
            . self::LEAFLET_VAR . ".latLngBounds("
                . self::LEAFLET_VAR . ".latLng($lat1,$lng1),"
                . self::LEAFLET_VAR . ".latLng($lat2,$lng2)"
            . "),"
            . '{alt:"svgOverlay"})',
            $svgOverlay->toJs(self::LEAFLET_VAR)
        );
    }
}
