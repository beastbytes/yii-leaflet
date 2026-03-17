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
        $centre = new LatLng(51.51383, -0.0985);

        // Layer group with a marker and circles
        $centreLayerGroup = new LayerGroup([
            (new Circle(
                $centre,
                [
                    'radius' => 4000,
                    'color' => '#20ffcd'
                ]
            ))
                ->tooltip('4km radius')
            ,
            (new Circle(
                $centre,
                [
                    'radius' => 2000,
                    'color' => '#3388ff'
                ]
            ))
                ->tooltip('2km radius')
            ,
            (new Circle(
                $centre,
                [
                    'radius' => 1000,
                    'color' => '#573CFF'
                ]
            ))
                ->tooltip('1km radius')
            ,
            (new Marker(
                $centre,
                [
                    'icon' => new Icon([
                        'iconAnchor' => new Point(12, 40),
                        'iconUrl' => '_static/leaflet/images/marker-icon-green.png',
                        'shadowUrl' => '_static/leaflet/images/marker-shadow.png'
                    ])
                ]
            ))
                ->popup("<p><b>St Paul's Cathedral</b></p>")
        ]);

        $churchLayers = [];
        $churches = [
            [
                'name' => 'St Clement Danes',
                'line' => 'Oranges and lemons',
                'location' => [51.5131, -0.1139]
            ],
            [
                'name' => 'St Martin-in-the-Fields',
                'line' => 'You owe me five farthings',
                'location' => [51.5088, -0.1267]
            ],
            [
                'name' => 'St Sepulchre-without-Newgate',
                'line' => 'When will you pay me?',
                'location' => [51.5167,-0.10227]
            ],
            [
                'name' => "St Leonard's, Shoreditch",
                'line' => 'When I grow rich',
                'location' => [51.5268, -0.0772]
            ],
            [
                'name' => "St Dunstan's, Stepney",
                'line' => 'When will that be?',
                'location' => [51.5168, -0.0417]
            ],
            [
                'name' => 'St Mary-le-Bow',
                'line' => 'I do not know',
                'location' => [51.5137, -0.0935]
            ],
        ];

        foreach ($churches as $church) {
            $churchLayers[] = (new Marker(
                $church['location'],
                [
                    'icon' => [
                        'iconAnchor' => new Point(12, 40),
                        'iconUrl' => '_static/leaflet/images/marker-icon.png',
                        'shadowUrl' => '_static/leaflet/images/marker-shadow.png'
                    ]
                ]
            ))
                ->popup('<p><b>' . $church['name'] . '</b></p>' . '<p>' . $church['line'] . '</p>')
            ;
        }

        // group the church layers
        $churchesLayerGroup = (new LayerGroup($churchLayers))->addToMap(false);

        $draggable = (new Marker(
            [51.5138,-0.1000],
            [
                'draggable' => true,
                'icon' => new Icon([
                    'iconAnchor' => new Point(12, 40),
                    'iconUrl' => '_static/leaflet/images/marker-icon-red.png',
                    'shadowUrl' => '_static/leaflet/images/marker-shadow.png'
                ])
            ]
        ))
            ->addToMap(false)
            ->popup('Drag me and see what happens')
            ->events([
                'dragend' => 'function(e) {const position=e.target.getLatLng();window.alert("Moved by " + Math.floor(e.distance) + " pixels\nNew position " + position.lat + ", " + position.lng);}'
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
                'zoom' => 13
            ])
            ->addControls(
                new Layers(overlays: array_keys($overlays)), // layers control to control layer visibility
                new Scale()
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
               'const layer0=%1$s.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{maxZoom:19,attribution:"&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors"});const %2$s=%1$s.map("%2$s",{center:%1$s.latLng(51.51383,-0.0985),layers:[layer0],zoom:13});const layer1=%1$s.layerGroup([%1$s.circle(%1$s.latLng(51.51383,-0.0985),{radius:4000,color:"#20ffcd"}).bindTooltip("4km radius"),%1$s.circle(%1$s.latLng(51.51383,-0.0985),{radius:2000,color:"#3388ff"}).bindTooltip("2km radius"),%1$s.circle(%1$s.latLng(51.51383,-0.0985),{radius:1000,color:"#573CFF"}).bindTooltip("1km radius"),%1$s.marker(%1$s.latLng(51.51383,-0.0985),{icon:%1$s.icon({iconAnchor:%1$s.point(12,40),iconUrl:"_static/leaflet/images/marker-icon-green.png",shadowUrl:"_static/leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>St Paul\\\'s Cathedral</b></p>")]).addTo(%2$s);const layer2=%1$s.layerGroup([%1$s.marker(%1$s.latLng(51.5131,-0.1139),{icon:%1$s.icon({iconAnchor:%1$s.point(12,40),iconUrl:"_static/leaflet/images/marker-icon.png",shadowUrl:"_static/leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>St Clement Danes</b></p><p>Oranges and lemons</p>"),%1$s.marker(%1$s.latLng(51.5088,-0.1267),{icon:%1$s.icon({iconAnchor:%1$s.point(12,40),iconUrl:"_static/leaflet/images/marker-icon.png",shadowUrl:"_static/leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>St Martin-in-the-Fields</b></p><p>You owe me five farthings</p>"),%1$s.marker(%1$s.latLng(51.5167,-0.10227),{icon:%1$s.icon({iconAnchor:%1$s.point(12,40),iconUrl:"_static/leaflet/images/marker-icon.png",shadowUrl:"_static/leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>St Sepulchre-without-Newgate</b></p><p>When will you pay me?</p>"),%1$s.marker(%1$s.latLng(51.5268,-0.0772),{icon:%1$s.icon({iconAnchor:%1$s.point(12,40),iconUrl:"_static/leaflet/images/marker-icon.png",shadowUrl:"_static/leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>St Leonard\\\'s, Shoreditch</b></p><p>When I grow rich</p>"),%1$s.marker(%1$s.latLng(51.5168,-0.0417),{icon:%1$s.icon({iconAnchor:%1$s.point(12,40),iconUrl:"_static/leaflet/images/marker-icon.png",shadowUrl:"_static/leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>St Dunstan\\\'s, Stepney</b></p><p>When will that be?</p>"),%1$s.marker(%1$s.latLng(51.5137,-0.0935),{icon:%1$s.icon({iconAnchor:%1$s.point(12,40),iconUrl:"_static/leaflet/images/marker-icon.png",shadowUrl:"_static/leaflet/images/marker-shadow.png"})}).bindPopup("<p><b>St Mary-le-Bow</b></p><p>I do not know</p>")]);const layer3=%1$s.marker(%1$s.latLng(51.5138,-0.1),{draggable:true,icon:%1$s.icon({iconAnchor:%1$s.point(12,40),iconUrl:"_static/leaflet/images/marker-icon-red.png",shadowUrl:"_static/leaflet/images/marker-shadow.png"})}).bindPopup("Drag me and see what happens").on("dragend",function(e) {const position=e.target.getLatLng();window.alert("Moved by " + Math.floor(e.distance) + " pixels\nNew position " + position.lat + ", " + position.lng);});const control0=%1$s.control.layers(null,{"St Paul\'s Cathedral":layer1,"Oranges & Lemons":layer2,"Draggable":layer3}).addTo(%2$s);const control1=%1$s.control.scale().addTo(%2$s);',
                $map->getLeafletVar(),
                $map->getId()
            ),
            $html
        );
    }
}