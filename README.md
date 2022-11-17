# BeastBytes\Widgets\Leaflet
Widget that integrates the [Leaflet](https://leafletjs.com/) JavaScript mapping library.

## Features

-   For Leaflet V1.*
-   Easy to use predefined tile providers (port of [Leaflet Providers](https://github.com/leaflet-extras/leaflet-providers))
-   Simple popup creation for markers and vector components; just set the 'content' option
-   Leaflet plugin support

For license information see the [LICENSE](LICENSE.md) file.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist beastbytes/leaflet
```

or add

```json
"beastbytes/leaflet": "*"
```

to the require section of your composer.json.

## Usage
An instance of the map widget must be assigned to a variable; this instance is used to render the HTML then
to get the JavaScript to be registered in the view.

The example below displays a map using OpenStreetMap as the tile provider. It has a marker in the centre of the map and a 5km radius circle centred on the marker; these are in a layer group that is not initially displayed. When the layer is shown using the Layers control, the centre marker can be dragged and dropped and its new position is shown - this demonstrates using component events. Three other markers are added in another layer group, and a layers and fullscreen control is added to the map; the fullscreen control is a plugin.

### Example

```php
use BeastBytes\Widgets\Leaflet\Map;
use BeastBytes\Widgets\Leaflet\controls\LayersControl;
use BeastBytes\Widgets\Leaflet\controls\ScaleControl;
use BeastBytes\Widgets\Leaflet\layers\other\LayerGroup;
use BeastBytes\Widgets\Leaflet\layers\raster\TileProvider;
use BeastBytes\Widgets\Leaflet\layers\ui\Marker;
use BeastBytes\Widgets\Leaflet\layers\vector\Circle;
use BeastBytes\Widgets\Leaflet\plugins\Fullscreen\FullscreenControl;
use BeastBytes\Widgets\Leaflet\types\Icon;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use BeastBytes\Widgets\Leaflet\types\Point;

// Centre of map
$centre = new LatLng(51.772550, -4.953250);

// Layer group with a marker and circle
$centreLayerGroup = new LayerGroup([
    new Circle($centre, [
        'radius' => 15000,
        'color' => "#20ffcd"
    ])->tooltip('15km radius'),
    new Circle($centre, [
        'radius' => 10000,
        'color' => "#3388ff"
    ])->tooltip('10km radius'),
    new Circle($centre, [
        'radius' => 5000,
        'color' => "#573CFF"
    ])->tooltip('5km radius'),
    new Marker($centre, [
        'icon' => new Icon([
            'iconAnchor' => new Point(12, 40),
            'iconUrl' => "leaflet/images/marker-icon.png",
            'shadowUrl' => 'leaflet/images/marker-shadow.png'
        ])
    ])->popup('<p><b>Little Dumpledale Farm</b></p>' .
        '<p>Ashdale Lane<br>Sardis<br>Haverfordwest<br>Pembrokeshire<br>SA62 4NT</p>' .
        '<p>Tel: +44 1646 602754</p>')
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
    $pubLayers[] = new Marker($pub['location'], [
        'icon' => [
            'iconAnchor' => new Point(12, 40),
            'iconUrl' => "leaflet/images/marker-icon.png",
            'shadowUrl' => 'leaflet/images/marker-shadow.png'
        ]
    ])->popup('<p><b>' . $pub['name'] . '</b></p>' .
        '<p>' . str_replace(', ', '<br>', $pub['address']) . '</p>' .
        '<p>Tel: ' . $pub['tel'] . '</p>');
}

// group the pub layers
$pubsLayerGroup = new LayerGroup($pubLayers)->addToMap(false);

$draggable = new Marker([51.786979, -4.977206], [
        'draggable' => true,
        'icon' => new Icon([
            'iconAnchor' => new Point(12, 40),
            'iconUrl' => "leaflet/images/marker-icon.png",
            'shadowUrl' => 'leaflet/images/marker-shadow.png'
        ])
    ])
    ->addToMap(false)
    ->popup('Drag me and see what happens'),
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
            (new TileProvider())->use('OpenStreetMap') // base tile layer
        ],
        'zoom' => self::ZOOM
    ])
    ->addCcontrols(
        new LayersControl(overlays: array_keys($overlays)), // layers control to control layer visibility
        new ScaleControl()
    )
    ->addLayers($overlays)
    ->addPlugins(new FullscreenControl())
]);

$map->render(); // before $map->getJs()
$this->registerJs($map->getJs()); // $this is the view
```
