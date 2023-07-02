<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\Tests;

use BeastBytes\Widgets\Leaflet\Tests\support\TestTrait;
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
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

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
        $centre = new LatLng(0, 0);
        $map = Map::widget()
            ->attributes(['style' => 'height:800px;'])
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
            . Map::LEAFLET_VAR . '.map("' . $id . '",{center:' . Map::LEAFLET_VAR . '.latLng(0,0),zoom:10});',
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
            '<div id="' . Map::ID_PREFIX . '%d" style="height:800px;"></div>',
            $content
        );

        $html = $this->webView->render( '/layout.php', ['content' => $content]);
        $matches = [];
        preg_match('/id="(' . Map::ID_PREFIX . '\d+)"/', $html, $matches);
        $id = $matches[1];

        $this->assertStringContainsString(
            'const ' . $leafletVar . '=' . Map::LEAFLET_VAR . '.noConflict();'
            . 'const ' . $id . '='
            . $leafletVar . '.map("' . $id . '",{center:' . $leafletVar . '.latLng(0,0),zoom:10});',
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
            '<' . $tag . ' id="' . Map::ID_PREFIX . '%d" style="height:800px;"></' . $tag . '>',
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
            'const layer0=' . Map::LEAFLET_VAR . '.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{maxZoom:19,attribution:"&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors"});const ' . $id . '=' . Map::LEAFLET_VAR . '.map("' . $id . '",{center:' . Map::LEAFLET_VAR . '.latLng(51.77255,-4.95325),layers:[layer0],zoom:12});const layer1=' . Map::LEAFLET_VAR . '.layerGroup([' . Map::LEAFLET_VAR . '.circle(' . Map::LEAFLET_VAR . '.latLng(51.77255,-4.95325),{radius:15000,color:"#20ffcd"}).bindTooltip("15km radius"),' . Map::LEAFLET_VAR . '.circle(' . Map::LEAFLET_VAR . '.latLng(51.77255,-4.95325),{radius:10000,color:"#3388ff"}).bindTooltip("10km radius"),' . Map::LEAFLET_VAR . '.circle(' . Map::LEAFLET_VAR . '.latLng(51.77255,-4.95325),{radius:5000,color:"#573CFF"}).bindTooltip("5km radius"),' . Map::LEAFLET_VAR . '.marker(' . Map::LEAFLET_VAR . '.latLng(51.77255,-4.95325),{icon:' . Map::LEAFLET_VAR . '.icon({iconAnchor:' . Map::LEAFLET_VAR . '.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>Little Dumpledale Farm</b></p><p>Ashdale Lane<br>Sardis<br>Haverfordwest<br>Pembrokeshire<br>SA62 4NT</p><p>Tel: +44 1646 602754</p>")]).addTo(' . $id . ');const layer2=' . Map::LEAFLET_VAR . '.layerGroup([' . Map::LEAFLET_VAR . '.marker(' . Map::LEAFLET_VAR . '.latLng(51.749151,-4.913822),{icon:' . Map::LEAFLET_VAR . '.icon({iconAnchor:' . Map::LEAFLET_VAR . '.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>The Cottage Inn</b></p><p>Llangwm<br>Haverfordwest<br>Pembrokeshire<br>SA62 4HH</p><p>Tel: +44 1437 891494</p>"),' . Map::LEAFLET_VAR . '.marker(' . Map::LEAFLET_VAR . '.latLng(51.7079864,-4.925951),{icon:' . Map::LEAFLET_VAR . '.icon({iconAnchor:' . Map::LEAFLET_VAR . '.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>Jolly Sailor</b></p><p>Burton<br>Milford Haven<br>Pembrokeshire<br>SA73 1NX</p><p>Tel: +44 1646 600378</p>")]);const layer3=' . Map::LEAFLET_VAR . '.marker(' . Map::LEAFLET_VAR . '.latLng(51.786979,-4.977206),{draggable:true,icon:' . Map::LEAFLET_VAR . '.icon({iconAnchor:' . Map::LEAFLET_VAR . '.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("Drag me and see what happens").on("dragend",function(e){const position=e.target.getLatLng();window.alert("Moved by " + Math.floor(e.distance) + " pixels\nNew position " + position.lat + ", " + position.lng);});const control0=' . Map::LEAFLET_VAR . '.control.layers(null,{"Little Dumpledale":layer1,"Pubs":layer2,"Draggable":layer3}).addTo(' . $id . ');const control1=' . Map::LEAFLET_VAR . '.control.scale().addTo(' . $id . ');',
            $html
        );
    }
}
