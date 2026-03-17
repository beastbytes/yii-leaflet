<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Tests\layers\other;

use BeastBytes\Yii\Leaflet\Layers\Other\FeatureGroup;
use BeastBytes\Yii\Leaflet\Layers\UI\Marker;
use BeastBytes\Yii\Leaflet\Map;
use BeastBytes\Yii\Leaflet\Types\Point;
use PHPUnit\Framework\TestCase;

class FeatureGroupTest extends TestCase
{
    public function test_feature_group()
    {
        $layers = [];

        $locations = [
            [51.749151, -4.913822],
            [51.7079864, -4.925951],
        ];

        foreach ($locations as $location) {
            $layers[] = new Marker($location, [
                'icon' => [
                    'iconAnchor' => new Point(12, 40),
                    'iconUrl' => "leaflet/images/marker-icon.png",
                    'shadowUrl' => 'leaflet/images/marker-shadow.png'
                ]
            ]);
        }

        $featureGroup = new FeatureGroup($layers);

        $this->assertSame(
            Map::LEAFLET_VAR . '.featureGroup(['
                . Map::LEAFLET_VAR . '.marker(' . Map::LEAFLET_VAR . '.latLng(51.749151,-4.913822),{'
                    . 'icon:' . Map::LEAFLET_VAR . '.icon({'
                        . 'iconAnchor:' . Map::LEAFLET_VAR . '.point(12,40),'
                        . 'iconUrl:"leaflet/images/marker-icon.png",'
                        . 'shadowUrl:"leaflet/images/marker-shadow.png"'
                    . '})'
                . '}),'
                    . Map::LEAFLET_VAR . '.marker(' . Map::LEAFLET_VAR . '.latLng(51.7079864,-4.925951),{'
                    . 'icon:' . Map::LEAFLET_VAR . '.icon({'
                        . 'iconAnchor:' . Map::LEAFLET_VAR . '.point(12,40),'
                        . 'iconUrl:"leaflet/images/marker-icon.png",'
                        . 'shadowUrl:"leaflet/images/marker-shadow.png"'
                    . '})'
                . '})'
            . '])',
            $featureGroup->toJs(Map::LEAFLET_VAR)
        );
    }
}