<?php
/**
 * @copyright Copyright © 2022 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace Tests\layers\raster;

use BeastBytes\Widgets\Leaflet\layers\raster\ImageOverlay;
use BeastBytes\Widgets\Leaflet\types\Bounds;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use BeastBytes\Widgets\Leaflet\types\LatLngBounds;
use PHPUnit\Framework\TestCase;

class ImageOverlayTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_image_overlay()
    {
        $url = 'https://example.com/imageoverlay.jpg';
        $lat1 = random_int(-9000, 9000) / 100;
        $lng1 = random_int(-18000, 18000) / 100;
        $lat2 = random_int(-9000, 9000) / 100;
        $lng2 = random_int(-18000, 18000) / 100;
        $latLng1 = new LatLng($lat1, $lng1);
        $latLng2 = new LatLng($lat2, $lng2);

        $latLngBounds = new LatLngBounds($latLng1, $latLng2);
        $imageOverlay = new ImageOverlay($url, $latLngBounds, ['alt' => 'imageOverlay']);

        $this->assertSame(
            self::LEAFLET_VAR . ".imageOverlay(\"$url\","
            . self::LEAFLET_VAR . ".latLngBounds("
                . self::LEAFLET_VAR . ".latLng($lat1,$lng1),"
                . self::LEAFLET_VAR . ".latLng($lat2,$lng2)"
            . "),"
            . '{alt:"imageOverlay"})',
            $imageOverlay->toJs(self::LEAFLET_VAR)
        );
    }
}
