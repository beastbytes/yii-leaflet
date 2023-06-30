<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests;

use BeastBytes\Widgets\Leaflet\controls\LayersControl;
use BeastBytes\Widgets\Leaflet\controls\ScaleControl;
use BeastBytes\Widgets\Leaflet\layers\other\LayerGroup;
use BeastBytes\Widgets\Leaflet\layers\raster\TileProvider;
use BeastBytes\Widgets\Leaflet\layers\ui\Marker;
use BeastBytes\Widgets\Leaflet\layers\vector\Circle;
use BeastBytes\Widgets\Leaflet\Map;
use BeastBytes\Widgets\Leaflet\types\Icon;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use BeastBytes\Widgets\Leaflet\types\Point;
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

    public function test_minimal_config()
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
            'const map0=L.map("map0",{center:L.latLng(0,0),zoom:10});',
            $map->getJs()
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

        foreach ($pubs as $pub) {
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

        $this->assertSame('<div id="map1" style="height:800px;"></div>', $map->render());
        $this->assertSame(
            'const layer0=L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{maxZoom:19,attribution:"&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors"});const map1=L.map("map1",{center:L.latLng(51.77255,-4.95325),layers:[layer0],zoom:12});const layer1=L.layerGroup([L.circle(L.latLng(51.77255,-4.95325),{radius:15000,color:"#20ffcd"}).bindTooltip("15km radius"),L.circle(L.latLng(51.77255,-4.95325),{radius:10000,color:"#3388ff"}).bindTooltip("10km radius"),L.circle(L.latLng(51.77255,-4.95325),{radius:5000,color:"#573CFF"}).bindTooltip("5km radius"),L.marker(L.latLng(51.77255,-4.95325),{icon:L.icon({iconAnchor:L.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>Little Dumpledale Farm</b></p><p>Ashdale Lane<br>Sardis<br>Haverfordwest<br>Pembrokeshire<br>SA62 4NT</p><p>Tel: +44 1646 602754</p>")]).addTo(map1);const layer2=L.layerGroup([L.marker(L.latLng(51.749151,-4.913822),{icon:L.icon({iconAnchor:L.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>The Cottage Inn</b></p><p>Llangwm<br>Haverfordwest<br>Pembrokeshire<br>SA62 4HH</p><p>Tel: +44 1437 891494</p>"),L.marker(L.latLng(51.7079864,-4.925951),{icon:L.icon({iconAnchor:L.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>Jolly Sailor</b></p><p>Burton<br>Milford Haven<br>Pembrokeshire<br>SA73 1NX</p><p>Tel: +44 1646 600378</p>")]);const layer3=L.marker(L.latLng(51.786979,-4.977206),{draggable:true,icon:L.icon({iconAnchor:L.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("Drag me and see what happens").on("dragend",function(e){const position=e.target.getLatLng();window.alert("Moved by " + Math.floor(e.distance) + " pixels\nNew position " + position.lat + ", " + position.lng);});const control0=L.control.layers(null,{"Little Dumpledale":layer1,"Pubs":layer2,"Draggable":layer3}).addTo(map1);const control1=L.control.scale().addTo(map1);',
            $map->getJs()
        );
    }
}
