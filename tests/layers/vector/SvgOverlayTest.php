<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Tests\layers\vector;

use BeastBytes\Yii\Leaflet\Layers\Vector\SvgOverlay;
use BeastBytes\Yii\Leaflet\Map;
use BeastBytes\Yii\Leaflet\Types\LatLng;
use BeastBytes\Yii\Leaflet\Types\LatLngBounds;
use PHPUnit\Framework\TestCase;

const SVG_NAMESPACE = 'http://www.w3.org/2000/svg';
const SVG_OVERLAY = <<<'SVG_OVERLAY'
const svgElement%%d=document.createElementNS("%s","svg");
svgElement%%d.setAttribute("xmlns","%1$s");
svgElement%%d.setAttribute("viewBox","%s");
svgElement%%d.innerHTML='%s';
%s.svgOverlay(svgElement%%d,%4$s.latLngBounds(%4$s.latLng(%s,%s),%4$s.latLng(%s,%s)),{alt:"svgOverlay"})
SVG_OVERLAY;

class SvgOverlayTest extends TestCase
{
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

        $this->assertStringMatchesFormat(
            sprintf(SVG_OVERLAY,
                SVG_NAMESPACE,
                $viewBox,
                $innerHtml,
                Map::LEAFLET_VAR,
                $lat1,$lng1,$lat2,$lng2
            ),
            $svgOverlay->toJs(Map::LEAFLET_VAR)
        );
    }

    public function test_svg_overlay_view_box_array()
    {
        $innerHtml = '<rect width="200" height="200"/><rect x="75" y="23" width="50" height="50" style="fill:red"/><rect x="75" y="123" width="50" height="50" style="fill:#0013ff"/>';
        $viewBox = [0, 0, 200, 200];
        $lat1 = random_int(-9000, 9000) / 100;
        $lng1 = random_int(-18000, 18000) / 100;
        $lat2 = random_int(-9000, 9000) / 100;
        $lng2 = random_int(-18000, 18000) / 100;
        $latLng1 = new LatLng($lat1, $lng1);
        $latLng2 = new LatLng($lat2, $lng2);

        $latLngBounds = new LatLngBounds($latLng1, $latLng2);
        $svgOverlay = new SvgOverlay($innerHtml, $viewBox, $latLngBounds, ['alt' => 'svgOverlay']);

        $this->assertStringMatchesFormat(
            sprintf(SVG_OVERLAY,
                SVG_NAMESPACE,
                implode(' ', $viewBox),
                $innerHtml,
                Map::LEAFLET_VAR,
                $lat1,$lng1,$lat2,$lng2
            ),
            $svgOverlay->toJs(Map::LEAFLET_VAR)
        );
    }
    public function test_svg_overlay_namespace()
    {
        $namespace = 'https://example.com/svg';
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
        $svgOverlay = $svgOverlay->namespace($namespace);

        $this->assertStringMatchesFormat(
            sprintf(SVG_OVERLAY,
                $namespace,
                $viewBox,
                $innerHtml,
                Map::LEAFLET_VAR,
                $lat1,$lng1,$lat2,$lng2
            ),
            $svgOverlay->toJs(Map::LEAFLET_VAR)
        );
    }
}