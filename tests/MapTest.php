<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Tests;

use BeastBytes\Yii\Leaflet\Tests\support\TestTrait;
use BeastBytes\Yii\Leaflet\controls\LayersControl;
use BeastBytes\Yii\Leaflet\controls\ScaleControl;
use BeastBytes\Yii\Leaflet\layers\other\LayerGroup;
use BeastBytes\Yii\Leaflet\layers\raster\TileProvider;
use BeastBytes\Yii\Leaflet\layers\ui\Marker;
use BeastBytes\Yii\Leaflet\layers\vector\Circle;
use BeastBytes\Yii\Leaflet\Map;
use BeastBytes\Yii\Leaflet\types\Icon;
use BeastBytes\Yii\Leaflet\types\LatLng;
use BeastBytes\Yii\Leaflet\types\Point;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Strings\Inflector;

class MapTest extends TestCase
{
    use TestTrait;

    public function test_no_center()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Map::CENTER_NOT_SET_MESSAGE);
        Map::widget()
            ->render();
    }

    public function test_no_zoom()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Map::ZOOM_NOT_SET_MESSAGE);

        $centre = new LatLng(0, 0);
        Map::widget()
            ->options([
                'center' => $centre
            ])
            ->render();
    }

    public function test_no_height()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Map::HEIGHT_NOT_SET_MESSAGE);

        $centre = new LatLng(0, 0);
        Map::widget()
            ->options([
                'center' => $centre,
                'zoom' => 10
           ])
           ->render();
    }

    public function test_minimal_config()
    {
        $lat = 51.5032359;
        $lng = -0.127242;
        $centre = [$lat, $lng];

        $map = Map::widget()
            ->attributes(['style' => 'height:800px;'])
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
                'const %s=%s.map("%s",{center:%2$s.latLng(%s,%s),zoom:10});',
                (new Inflector())->toSnakeCase($map->getId()),
                $map->getLeafletVar(),
                $map->getId(),
                $lat,
                $lng
            ),
            $html
        );
    }

    public function test_centre_as_LatLng()
    {
        $lat = 51.5018582;
        $lng = -0.1243539;
        $centre = new LatLng($lat, $lng);

        $map = Map::widget()
            ->attributes(['style' => 'height:800px;'])
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
                'const %s=%s.map("%s",{center:%2$s.latLng(%s,%s),zoom:10});',
                (new Inflector())->toSnakeCase($map->getId()),
                $map->getLeafletVar(),
                $map->getId(),
                $lat,
                $lng
            ),
            $html
        );
    }

    public function test_MaxBounds()
    {
        $lat = 51.5183446;
        $lng = -0.1228841;
        $latNW = 51.5422190;
        $lngNW = -0.17459705;
        $latSE = 51.4947917;
        $lngSE = -0.0650771;
        $centre = new LatLng($lat, $lng);

        $map = Map::widget()
            ->attributes(['style' => 'height:800px;'])
            ->options([
                'center' => $centre,
                'maxBounds' => [[$latNW, $lngNW], [$latSE, $lngSE]],
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
                'const %s=%s.map("%s",{center:%2$s.latLng(%s,%s),maxBounds:%2$s.latLngBounds(%2$s.latLng(%s,%s),%2$s.latLng(%s,%s)),zoom:10});',
                (new Inflector())->toSnakeCase($map->getId()),
                $map->getLeafletVar(),
                $map->getId(),
                $lat,
                $lng,
                $latNW,
                $lngNW,
                $latSE,
                $lngSE
            ),
            $html
        );
    }

    public function test_leaflet_var()
    {
        $leafletVar = 'X';

        $centre = new LatLng(0, 0);
        $map = Map::widget()
            ->attributes(['style' => 'height:800px;'])
            ->leafletVar($leafletVar)
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
                'const %s=%s.noConflict();const %s=%1$s.map("%3$s",{center:%1$s.latLng(0,0),zoom:10});',
                $map->getLeafletVar(),
                Map::LEAFLET_VAR,
                $map->getId()
        ),
            $html
        );
    }

    public function test_tag()
    {
        $tag = 'tag';
        $centre = new LatLng(0, 0);
        $map = Map::widget()
            ->attributes(['style' => 'height:800px;'])
            ->tag($tag)
            ->options([
                'center' => $centre,
                'zoom' => 10
            ]);

        $content = $map->render();
        $this->assertStringMatchesFormat(
            sprintf('<%s id="%s" style="height:800px;"></%1$s>', $tag, $map->getId()),
            $content
        );
    }

    public function test_map()
    {
        // Centre of map
        $centre = new LatLng(51.772550, -4.953250);

        // Layer group with a marker and circle
        $centreLayerGroup = new LayerGroup([
            (new Circle($centre, [
                'radius' => 15000,
                'color' => "#20ffcd"
            ]))
                ->tooltip('15km radius')
            ,
            (new Circle($centre, [
                'radius' => 10000,
                'color' => "#3388ff"
            ]))
                ->tooltip('10km radius')
            ,
            (new Circle($centre, [
                'radius' => 5000,
                'color' => "#573CFF"
            ]))
                ->tooltip('5km radius')
            ,
            (new Marker($centre, [
                'icon' => new Icon([
                    'iconAnchor' => new Point(12, 40),
                    'iconUrl' => "leaflet/images/marker-icon.png",
                    'shadowUrl' => 'leaflet/images/marker-shadow.png'
                ])
            ]))
                ->popup(
                    '<p><b>Little Dumpledale Farm</b></p>'
                    . '<p>Ashdale Lane<br>Sardis<br>Haverfordwest<br>Pembrokeshire<br>SA62 4NT</p>'
                    . '<p>Tel: +44 1646 602754</p>'
                )
        ]);

        $pubLayers = [];
        $pubs = [
            [
                'name' => 'The Cottage Inn',
                'address' => 'Llangwm, Haverfordwest, Pembrokeshire, SA62 4HH',
                'tel' => '+44 1437 891494',
                'location' => [51.749151, -4.913822]
            ],
            [
                'name' => 'Jolly Sailor',
                'address' => 'Burton, Milford Haven, Pembrokeshire, SA73 1NX',
                'tel' => '+44 1646 600378',
                'location' => [51.7079864, -4.925951]
            ]
        ];

        foreach ($pubs as $i => $pub) {
            $pubLayers[] = (new Marker($pub['location'], [
                'icon' => [
                    'iconAnchor' => new Point(12, 40),
                    'iconUrl' => "leaflet/images/marker-icon.png",
                    'shadowUrl' => 'leaflet/images/marker-shadow.png'
                ]
            ]))
                ->popup(
                    '<p><b>' . $pub['name'] . '</b></p>'
                    . '<p>' . str_replace(', ', '<br>', $pub['address']) . '</p>'
                    . '<p>Tel: ' . $pub['tel'] . '</p>'
                )
            ;
        }

        // group the pub layers
        $pubsLayerGroup = (new LayerGroup($pubLayers))
            ->addToMap(false)
        ;

        $draggable = (new Marker([51.786979, -4.977206], [
            'draggable' => true,
            'icon' => new Icon([
                'iconAnchor' => new Point(12, 40),
                'iconUrl' => "leaflet/images/marker-icon.png",
                'shadowUrl' => 'leaflet/images/marker-shadow.png'
            ])
        ]))
            ->addToMap(false)
            ->popup('Drag me and see what happens')
            ->events([
                 'dragend' => 'function(e){const position=e.target.getLatLng();window.alert("Moved by " + Math.floor(e.distance) + " pixels\nNew position " + position.lat + ", " + position.lng);}'
            ]);

        $overlays = [
            'Little Dumpledale' => $centreLayerGroup,
            'Pubs' => $pubsLayerGroup,
            'Draggable' => $draggable
        ];

        $map = Map::widget()
            ->attributes([
                'style' => 'height:800px;' // a height must be specified
            ])
            ->options([
                'center' => $centre,
                'layers' => [
                    'Roads' => (new TileProvider())->use('OpenStreetMap') // base tile layer
                ],
                'zoom' => 12
            ])
            ->addControls(
                new LayersControl(overlays: array_keys($overlays)), // layers control to control layer visibility
                new ScaleControl()
            )
            ->addLayers($overlays)
        ;

        $content = $map->render();
        $this->assertStringMatchesFormat(
            sprintf('<div id="%s" style="height:800px;"></div>', $map->getId()),
            $content
        );

        $html = $this->view->render( '//view.php', ['content' => $content]);

        $this->assertStringContainsString(
            sprintf(
            'const layer0=%1$s.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{maxZoom:19,attribution:"&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors"});const %2$s=%1$s.map("%2$s",{center:%1$s.latLng(51.77255,-4.95325),layers:[layer0],zoom:12});const layer1=%1$s.layerGroup([' . Map::LEAFLET_VAR . '.circle(' . Map::LEAFLET_VAR . '.latLng(51.77255,-4.95325),{radius:15000,color:"#20ffcd"}).bindTooltip("15km radius"),%1$s.circle(%1$s.latLng(51.77255,-4.95325),{radius:10000,color:"#3388ff"}).bindTooltip("10km radius"),%1$s.circle(%1$s.latLng(51.77255,-4.95325),{radius:5000,color:"#573CFF"}).bindTooltip("5km radius"),%1$s.marker(%1$s.latLng(51.77255,-4.95325),{icon:%1$s.icon({iconAnchor:%1$s.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>Little Dumpledale Farm</b></p><p>Ashdale Lane<br>Sardis<br>Haverfordwest<br>Pembrokeshire<br>SA62 4NT</p><p>Tel: +44 1646 602754</p>")]).addTo(%2$s);const layer2=%1$s.layerGroup([%1$s.marker(%1$s.latLng(51.749151,-4.913822),{icon:%1$s.icon({iconAnchor:%1$s.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>The Cottage Inn</b></p><p>Llangwm<br>Haverfordwest<br>Pembrokeshire<br>SA62 4HH</p><p>Tel: +44 1437 891494</p>"),' . Map::LEAFLET_VAR . '.marker(' . Map::LEAFLET_VAR . '.latLng(51.7079864,-4.925951),{icon:%1$s.icon({iconAnchor:%1$s.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>Jolly Sailor</b></p><p>Burton<br>Milford Haven<br>Pembrokeshire<br>SA73 1NX</p><p>Tel: +44 1646 600378</p>")]);const layer3=%1$s.marker(%1$s.latLng(51.786979,-4.977206),{draggable:true,icon:%1$s.icon({iconAnchor:%1$s.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("Drag me and see what happens").on("dragend",function(e){const position=e.target.getLatLng();window.alert("Moved by " + Math.floor(e.distance) + " pixels\nNew position " + position.lat + ", " + position.lng);});const control0=%1$s.control.layers(null,{"Little Dumpledale":layer1,"Pubs":layer2,"Draggable":layer3}).addTo(%2$s);const control1=%1$s.control.scale().addTo(%2$s);',
                $map->getLeafletVar(),
                $map->getId()
            ),
            $html
        );
    }
}