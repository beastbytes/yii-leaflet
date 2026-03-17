Usage
=====

The example below demonstrates how to use Yii Leaflet.
It shows the source PHP code, the generated JavaScript, and the map.

A simplistic description is:

* Define the centre of the map
* Prepare the map layers
* Instantiate the map specifying the centre, initial layers, and a zoom level
* Add additional layers, controls, plugins to the map as required
* Render the map

Yii Leaflet generates the JavaScript, registers it and Leaflet JavaScript and CSS in the view, and creates the map `div`
element.

Example
-------
The example shows the churches - *bells* -
that are cited in the nursery rhyme `Oranges and Lemons <https://en.wikipedia.org/wiki/Oranges_and_Lemons>`__.

The map is initialised with its centre at St Paul's Cathedral (not part of the nursery rhyme, but conveniently central)
and shows three circles of 1km, 2km, and 4km radius centred on St Paul's.
These are in a layer group and their visibility can be toggled using the layers control at the top right of the map.

The churches in the nursery rhyme are in a layer group that is initially not shown on the map;
their visibility can be toggled using the layers control.
The markers are clickable and show the name of the church and the relevant line of the nursery rhyme.

.. note::
    St Sepulchre-without-Newgate is the closest church to the Old Bailey

A draggable marker can be made visible using the layers control; it demonstrates events generated on the map.
When dragged and dropped it will show the number of pixels it has moved and its new location

The map uses OpenStreetMap as the tile provider.

.. code-block:: php

    use BeastBytes\Yii\Leaflet\Map;
    use BeastBytes\Yii\Leaflet\Controls\Layers;
    use BeastBytes\Yii\Leaflet\Controls\Scale;
    use BeastBytes\Yii\Leaflet\Layers\Other\LayerGroup;
    use BeastBytes\Yii\Leaflet\Layers\Raster\TileProvider;
    use BeastBytes\Yii\Leaflet\Layers\UI\Marker;
    use BeastBytes\Yii\Leaflet\Layers\Vector\Circle;
    use BeastBytes\Yii\Leaflet\plugins\Fullscreen\FullscreenControl;
    use BeastBytes\Yii\Leaflet\Types\Icon;
    use BeastBytes\Yii\Leaflet\Types\LatLng;
    use BeastBytes\Yii\Leaflet\Types\Point;

    // Centre of map
    $centre = new LatLng(51.51383, -0.0985);

    // Layer group with a marker and circles
    $centreLayerGroup = new LayerGroup([
        new Circle($centre, [
            'radius' => 15000,
            'color' => '#20ffcd'
        ])->tooltip('15km radius'),
        new Circle($centre, [
            'radius' => 10000,
            'color' => '#3388ff'
        ])->tooltip('10km radius'),
        new Circle($centre, [
            'radius' => 5000,
            'color' => '#573CFF'
        ])->tooltip('5km radius'),
        new Marker($centre, [
            'icon' => new Icon([
                'iconAnchor' => new Point(12, 40),
                'iconUrl' => '_static/leaflet/images/marker-icon-green.png',
                'shadowUrl' => '_static/leaflet/images/marker-shadow.png'
            ])
        ])->popup("<p><b>St Paul's Cathedral</b></p>")
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
        $churchLayers[] = new Marker($church['location'], [
            'icon' => [
                'iconAnchor' => new Point(12, 40),
                'iconUrl' => '_static/leaflet/images/marker-icon.png',
                'shadowUrl' => '_static/leaflet/images/marker-shadow.png'
            ]
        ])->popup('<p><b>' . $church['name'] . '</b></p>' .
            '<p>' . $church['line'] . '</p>');
    }

    // group the church layers
    $churchesLayerGroup = new LayerGroup($churchLayers)->addToMap(false);

    $draggable = new Marker([51.5138,-0.1000], [
            'draggable' => true,
            'icon' => new Icon([
                'iconAnchor' => new Point(12, 40),
                'iconUrl' => '_static/leaflet/images/marker-icon-red.png',
                'shadowUrl' => '_static/leaflet/images/marker-shadow.png'
            ])
        ])
        ->addToMap(false)
        ->popup('Drag me and see what happens'),
        ->events([
            'dragend' => 'function(e){const position=e.target.getLatLng();window.alert("Moved by " + Math.floor(e.distance) + " pixels\nNew position " + position.lat + ", " + position.lng);}'
        ]);

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
            'zoom' => self::ZOOM
        ])
        ->addCcontrols(
            new Layers(overlays: array_keys($overlays)), // layers control to control layer visibility
            new Scale()
        )
        ->addLayers($overlays)
        ->addPlugins(new FullscreenControl())
    ]);

    echo $map->render();

Generated JavaScript
---------------------
The PHP above generates the following JavaScript.

.. note::
    The JavaScript is shown formatted for clarity. The generated JaveScript is not formatted to reduce its size.

.. code-block:: javascript

    const layer0 = L.tileLayer(
        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        {
            maxZoom: 19,
            attribution: "&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors"
        }
    );
    const map_467619187270731 = L.map(
        "map_467619187270731",
        {
            center: L.latLng(51.51383,-0.0985),
            layers: [layer0],
            zoom: 13
        }
    );
    const layer1 = L.layerGroup([
        L.circle(
            L.latLng(51.51383,-0.0985),
            {
                radius: 4000,
                color: "#20ffcd"
            }
        )
            .bindTooltip("4km radius")
        ,
        L.circle(
            L.latLng(51.51383,-0.0985),
            {
                radius: 2000,
                color:"#3388ff"
            }
        )
            .bindTooltip("2km radius")
        ,
        L.circle(
            L.latLng(51.51383,-0.0985),
            {
                radius:1000,
                color:"#573CFF"
            }
        )
            .bindTooltip("1km radius")
        ,
        L.marker(
            L.latLng(51.51383,-0.0985),
            {
                icon: L.icon({
                    iconAnchor: L.point(12,40),
                    iconUrl: "_static/leaflet/images/marker-icon-green.png",
                    shadowUrl: "_static/leaflet/images/marker-shadow.png"
                })
            }
        )
            .bindPopup("<p><b>St Paul\'s Cathedral</b></p>")
    ])
        .addTo(map_467619187270731)
    ;
    const layer2 = L.layerGroup([
        L.marker(
            L.latLng(51.5131, -0.1139),
            {
                icon: L.icon({
                    iconAnchor: L.point(12,40),
                    iconUrl: "_static/leaflet/images/marker-icon.png",
                    shadowUrl: "_static/leaflet/images/marker-shadow.png"
                })
            }
        )
            .bindPopup("<p><b>St Clement Danes</b></p><p>Oranges and lemons</p>")
        ,
        L.marker(
            L.latLng(51.5088, -0.1267),
            {
                icon: L.icon({
                    iconAnchor:L.point(12,40),
                    iconUrl:"_static/leaflet/images/marker-icon.png",
                    shadowUrl:"_static/leaflet/images/marker-shadow.png"
                })
            }
        )
            .bindPopup("<p><b>St Martin-in-the-Fields</b></p><p>You owe me five farthings</p>")
        ,
        L.marker(
            L.latLng(51.5167,-0.10227),
            {
                icon: L.icon({
                    iconAnchor: L.point(12,40),
                    iconUrl: "_static/leaflet/images/marker-icon.png",
                    shadowUrl: "_static/leaflet/images/marker-shadow.png"
                })
            }
        )
            .bindPopup("<p><b>St Sepulchre-without-Newgate</b></p><p>When will you pay me?</p>")
        ,
        L.marker(
            L.latLng(51.5268, -0.0772),
            {
                icon: L.icon({
                    iconAnchor: L.point(12,40),
                    iconUrl:"_static/leaflet/images/marker-icon.png",
                    shadowUrl:"_static/leaflet/images/marker-shadow.png"
                })
            }
        )
            .bindPopup("<p><b>St Leonard\'s, Shoreditch</b></p><p>When I grow rich</p>")
        ,
        L.marker(
            L.latLng(51.5168, -0.0417),
            {
                icon: L.icon({
                    iconAnchor: L.point(12,40),
                    iconUrl: "_static/leaflet/images/marker-icon.png",
                    shadowUrl: "_static/leaflet/images/marker-shadow.png"
                })
            }
        )
            .bindPopup("<p><b>St Dunstan\'s, Stepney</b></p><p>When will that be</p>")
        ,
        L.marker(
            L.latLng(51.5137, -0.0935),
            {
                icon: L.icon({
                    iconAnchor: L.point(12,40),
                    iconUrl:"_static/leaflet/images/marker-icon.png",
                    shadowUrl:"_static/leaflet/images/marker-shadow.png"
                })
            }
        )
            .bindPopup("<p><b>St Mary-le-Bow</b></p><p>I do not know</p>")
    ]);
    const layer3 = L.marker(
        L.latLng(51.5138,-0.1000),
        {
            draggable: true,
            icon: L.icon({
                iconAnchor: L.point(12,40),
                iconUrl: "_static/leaflet/images/marker-icon-red.png",
                shadowUrl: "_static/leaflet/images/marker-shadow.png"
            })
        }
    )
        .bindPopup("Drag me and see what happens")
        .on(
            "dragend",
            function(e) {
                const position=e.target.getLatLng();
                window.alert("Moved by " + Math.floor(e.distance) + " pixels\nNew position " + position.lat + ", " + position.lng);
            }
        )
    ;
    const control0 = L.control.layers(
        null,
        {
            "St Paul's Cathedral": layer1,
            "Oranges & Lemons": layer2,
            "Draggable": layer3
        }
    )
        .addTo(map_467619187270731)
    ;
    const control1 = L.control.scale()
        .addTo(map_467619187270731)
    ;

Map
---
.. raw:: html

    <link rel="stylesheet" href="_static/leaflet/leaflet.css" />
    <script src="_static/leaflet/leaflet.js"></script>

    <div id="map_467619187270731" style="height:800px"></div>
    <script>
        const layer0 = L.tileLayer(
            "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            {
                maxZoom: 19,
                attribution: "&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors"
            }
        );
        const map_467619187270731 = L.map(
            "map_467619187270731",
            {
                center: L.latLng(51.51383,-0.0985),
                layers: [layer0],
                zoom: 13
            }
        );
        const layer1 = L.layerGroup([
            L.circle(
                L.latLng(51.51383,-0.0985),
                {
                    radius: 4000,
                    color: "#20ffcd"
                }
            )
                .bindTooltip("4km radius")
            ,
            L.circle(
                L.latLng(51.51383,-0.0985),
                {
                    radius: 2000,
                    color:"#3388ff"
                }
            )
                .bindTooltip("2km radius")
            ,
            L.circle(
                L.latLng(51.51383,-0.0985),
                {
                    radius:1000,
                    color:"#573CFF"
                }
            )
                .bindTooltip("1km radius")
            ,
            L.marker(
                L.latLng(51.51383,-0.0985),
                {
                    icon: L.icon({
                        iconAnchor: L.point(12,40),
                        iconUrl: "_static/leaflet/images/marker-icon-green.png",
                        shadowUrl: "_static/leaflet/images/marker-shadow.png"
                    })
                }
            )
                .bindPopup("<p><b>St Paul\'s Cathedral</b></p>")
        ])
            .addTo(map_467619187270731)
        ;
        const layer2 = L.layerGroup([
            L.marker(
                L.latLng(51.5131, -0.1139),
                {
                    icon: L.icon({
                        iconAnchor: L.point(12,40),
                        iconUrl: "_static/leaflet/images/marker-icon.png",
                        shadowUrl: "_static/leaflet/images/marker-shadow.png"
                    })
                }
            )
                .bindPopup("<p><b>St Clement Danes</b></p><p>Oranges and lemons</p>")
            ,
            L.marker(
                L.latLng(51.5088, -0.1267),
                {
                    icon: L.icon({
                        iconAnchor:L.point(12,40),
                        iconUrl:"_static/leaflet/images/marker-icon.png",
                        shadowUrl:"_static/leaflet/images/marker-shadow.png"
                    })
                }
            )
                .bindPopup("<p><b>St Martin-in-the-Fields</b></p><p>You owe me five farthings</p>")
            ,
            L.marker(
                L.latLng(51.5167,-0.10227),
                {
                    icon: L.icon({
                        iconAnchor: L.point(12,40),
                        iconUrl: "_static/leaflet/images/marker-icon.png",
                        shadowUrl: "_static/leaflet/images/marker-shadow.png"
                    })
                }
            )
                .bindPopup("<p><b>St Sepulchre-without-Newgate</b></p><p>When will you pay me?</p>")
            ,
            L.marker(
                L.latLng(51.5268, -0.0772),
                {
                    icon: L.icon({
                        iconAnchor: L.point(12,40),
                        iconUrl:"_static/leaflet/images/marker-icon.png",
                        shadowUrl:"_static/leaflet/images/marker-shadow.png"
                    })
                }
            )
                .bindPopup("<p><b>St Leonard\'s, Shoreditch</b></p><p>When I grow rich</p>")
            ,
            L.marker(
                L.latLng(51.5168, -0.0417),
                {
                    icon: L.icon({
                        iconAnchor: L.point(12,40),
                        iconUrl: "_static/leaflet/images/marker-icon.png",
                        shadowUrl: "_static/leaflet/images/marker-shadow.png"
                    })
                }
            )
                .bindPopup("<p><b>St Dunstan\'s, Stepney</b></p><p>When will that be?</p>")
            ,
            L.marker(
                L.latLng(51.5137, -0.0935),
                {
                    icon: L.icon({
                        iconAnchor: L.point(12,40),
                        iconUrl:"_static/leaflet/images/marker-icon.png",
                        shadowUrl:"_static/leaflet/images/marker-shadow.png"
                    })
                }
            )
                .bindPopup("<p><b>St Mary-le-Bow</b></p><p>I do not know</p>")
        ]);
        const layer3 = L.marker(
            L.latLng(51.5138,-0.1000),
            {
                draggable: true,
                icon: L.icon({
                    iconAnchor: L.point(12,40),
                    iconUrl: "_static/leaflet/images/marker-icon-red.png",
                    shadowUrl: "_static/leaflet/images/marker-shadow.png"
                })
            }
        )
            .bindPopup("Drag me and see what happens")
            .on(
                "dragend",
                function(e) {
                    const position=e.target.getLatLng();
                    window.alert("Moved by " + Math.floor(e.distance) + " pixels\nNew position " + position.lat + ", " + position.lng);
                }
            )
        ;
        const control0 = L.control.layers(
            null,
            {
                "St Paul's Cathedral": layer1,
                "Oranges & Lemons": layer2,
                "Draggable": layer3
            }
        )
            .addTo(map_467619187270731)
        ;
        const control1 = L.control.scale()
            .addTo(map_467619187270731)
        ;
    </script>