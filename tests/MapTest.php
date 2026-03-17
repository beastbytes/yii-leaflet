<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Tests;

use BeastBytes\Yii\Leaflet\Tests\support\TestTrait;
use BeastBytes\Yii\Leaflet\Controls\Layers;
use BeastBytes\Yii\Leaflet\Controls\Scale;
use BeastBytes\Yii\Leaflet\Layers\Other\LayerGroup;
use BeastBytes\Yii\Leaflet\Layers\Raster\TileProvider;
use BeastBytes\Yii\Leaflet\Layers\UI\Marker;
use BeastBytes\Yii\Leaflet\Layers\Vector\Circle;
use BeastBytes\Yii\Leaflet\Map;
use BeastBytes\Yii\Leaflet\Types\Icon;
use BeastBytes\Yii\Leaflet\Types\LatLng;
use BeastBytes\Yii\Leaflet\Types\Point;
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
        $centre = new LatLng(51.5124951, -0.0966);

        // Layer group with a marker and circles
        $centreLayerGroup = new LayerGroup([
            (new Circle($centre, [
                'radius' => 15000,
                'color' => '#20ffcd'
            ]))
                ->tooltip('15km radius')
            ,
            (new Circle($centre, [
                'radius' => 10000,
                'color' => '#3388ff'
            ]))
                ->tooltip('10km radius')
            ,
            (new Circle($centre, [
                'radius' => 5000,
                'color' => '#573CFF'
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
                ->popup("<p><b>St Paul's Cathedral</b></p>")
        ]);

        $churchLayers = [];
        $churches = [
            [
                'name' => 'St Clement Danes',
                'line' => 'Oranges and lemons',
                'location' => [51.5136032, -0.097843]
            ],
            [
                'name' => 'St Martin-in-the-Fields',
                'line' => 'You owe me five farthings',
                'location' => [51.5086737, -0.1240034]
            ],
            [
                'name' => 'St Sepulchre-without-Newgate',
                'line' => 'When will you pay me?',
                'location' => [51.5166848, -0.1022407]
            ],
            [
                'name' => "St Leonard's, Shoreditch",
                'line' => 'When I grow rich',
                'location' => [51.5261309, -0.0766819]
            ],
            [
                'name' => "St Dunstan's, Stepney",
                'line' => 'When will that be',
                'location' => [51.518494, -0.0385945]
            ],
            [
                'name' => 'St Mary-le-Bow',
                'line' => 'I do not know',
                'location' => [51.5138205, -0.0917935]
            ],
        ];

        foreach ($churches as $church) {
            $churchLayers[] = (new Marker(
                $church['location'],
                [
                    'icon' => [
                        'iconAnchor' => new Point(12, 40),
                        'iconUrl' => "leaflet/images/marker-icon.png",
                        'shadowUrl' => 'leaflet/images/marker-shadow.png'
                    ]
                ]
            ))
                ->popup(sprintf('<p><b>%s</b></p><p>%s</p>', $church['name'], $church['line']))
            ;
        }

        // group the church layers
        $churchesLayerGroup = (new LayerGroup($churchLayers))
            ->addToMap(false)
        ;

        $draggable = (new Marker(
            [51.5124951, -0.0966],
            [
                'draggable' => true,
                'icon' => (new Icon([
                    'iconAnchor' => new Point(12, 40),
                    'iconUrl' => 'leaflet/images/marker-icon.png',
                    'shadowUrl' => 'leaflet/images/marker-shadow.png',
                ]))
            ]
        ))
            ->addToMap(false)
            ->popup('Drag me and see what happens')
            ->events([
                'dragend' => 'function(e){const position=e.target.getLatLng();window.alert("Moved by " + Math.floor(e.distance) + " pixels\nNew position " + position.lat + ", " + position.lng);}'
            ])
        ;

        $overlays = [
            "St Paul's Cathedral" => $centreLayerGroup,
            'Oranges & Lemons' => $churchesLayerGroup,
            'Draggable' => $draggable
        ];

        $map = Map::widget()
            ->attributes([
                'style' => 'height:800px;' // a height must be specified
            ])
            ->options([
                'center' => $centre,
                'layers' => [
                    (new TileProvider())->use('OpenStreetMap') // base tile layer
                ],
                'zoom' => 12
            ])
            ->addControls(
                new Layers(overlays: array_keys($overlays)), // layers control to control layer visibility
                new Scale()
            )
            ->addLayers($overlays)
            // ->addPlugins(new FullscreenControl())
        ;

        $content = $map->render();

        $this->assertStringMatchesFormat(
            sprintf('<div id="%s" style="height:800px;"></div>', $map->getId()),
            $content
        );

        $html = $this->view->render( '//view.php', ['content' => $content]);

        $this->assertStringContainsString(
            sprintf(
            'const layer0=%1$s.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{maxZoom:19,attribution:"&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors"});const %2$s=%1$s.map("%2$s",{center:%1$s.latLng(51.5124951,-0.0966),layers:[layer0],zoom:12});const layer1=%1$s.layerGroup([' . Map::LEAFLET_VAR . '.circle(' . Map::LEAFLET_VAR . '.latLng(51.5124951,-0.0966),{radius:15000,color:"#20ffcd"}).bindTooltip("15km radius"),%1$s.circle(%1$s.latLng(51.5124951,-0.0966),{radius:10000,color:"#3388ff"}).bindTooltip("10km radius"),%1$s.circle(%1$s.latLng(51.5124951,-0.0966),{radius:5000,color:"#573CFF"}).bindTooltip("5km radius"),%1$s.marker(%1$s.latLng(51.77255,-4.95325),{icon:%1$s.icon({iconAnchor:%1$s.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>Little Dumpledale Farm</b></p><p>Ashdale Lane<br>Sardis<br>Haverfordwest<br>Pembrokeshire<br>SA62 4NT</p><p>Tel: +44 1646 602754</p>")]).addTo(%2$s);const layer2=L.layerGroup([L.marker(L.latLng(51.5136032,-0.097843),{icon:L.icon({iconAnchor:L.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>St Clement Danes</b></p><p>Oranges and lemons</p>"),L.marker(L.latLng(51.5086737,-0.1240034),{icon:L.icon({iconAnchor:L.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>St Martin-in-the-Fields</b></p><p>You owe me five farthings</p>"),L.marker(L.latLng(51.5166848,-0.1022407),{icon:L.icon({iconAnchor:L.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>St Sepulchre-without-Newgate</b></p><p>When will you pay me?</p>"),L.marker(L.latLng(51.5261309,-0.0766819),{icon:L.icon({iconAnchor:L.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>St Leonard\'s, Shoreditch</b></p><p>When I grow rich</p>"),L.marker(L.latLng(51.518494,-0.0385945),{icon:L.icon({iconAnchor:L.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>St Dunstan\'s, Stepney</b></p><p>When will that be</p>"),L.marker(L.latLng(51.5138205,-0.0917935),{icon:L.icon({iconAnchor:L.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>St Mary-le-Bow</b></p><p>I do not know</p>")]);const layer3=%1$s.marker(%1$s.latLng(51.786979,-4.977206),{draggable:true,icon:%1$s.icon({iconAnchor:%1$s.point(12,40),iconUrl:"leaflet/images/marker-icon.png",shadowUrl:"leaflet/images/marker-shadow.png"})}).bindPopup("Drag me and see what happens").on("dragend",function(e){const position=e.target.getLatLng();window.alert("Moved by " + Math.floor(e.distance) + " pixels\nNew position " + position.lat + ", " + position.lng);});const control0=%1$s.control.layers(null,{"St Paul\'s Cathedral":layer1,"Churches":layer2,"Draggable":layer3}).addTo(%2$s);const control1=%1$s.control.scale().addTo(%2$s);',
                $map->getLeafletVar(),
                $map->getId()
            ),
            $html
        );
    }
}