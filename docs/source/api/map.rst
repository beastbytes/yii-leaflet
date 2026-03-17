Map
===

.. php:namespace:: BeastBytes\Yii\Leaflet

.. php:class:: Map

    A Leaflet map

    .. php:method:: __construct(AssetManager $assetManager, private WebView $webView)

        Create a new `Map` instance

        :returns: A new `Map` instance
        :rtype: Map

    .. php:method:: addAttributes(array $valuesMap)

        Add HTML attributes for the container tag

        :returns: A new `Map` instance with the HTML attributes added
        :rtype: Map

    .. php:method:: addClass(string ...$value)

        Add classes to the container tag

        :param string ...$value: The class(es) to add
        :returns: A new `Map` instance with the class(es) added
        :rtype: Map

    .. php:method:: addControls(Control ...$controls)

        Add controls to the map

        :param Control ...$control: The control(s) to add
        :returns: A new `Map` instance with control(s) added
        :rtype: Map

    .. php:method:: addLayers(array $layers)

        Add layers to the map

        :param array[string=>Layer] $layers: The layer(s) to add where the keys are the layer names
        :returns: A new `Map` instance with the layer(s) added
        :rtype: Map

    .. php:method:: addPlugins(Component ...$plugins)

        Add plugins to the map

        :param Component ...$plugins: The plugin(s) to add
        :returns: A new `Map` instance with the plugin(s) added
        :rtype: Map

    .. php:method:: attributes(array $valuesMap)

        Set the HTML attributes for the container tag

        :rtype: Map

    .. php:method:: getId()

        Return the map HTML ID

        :returns: The map HTML ID
        :rtype: string

    .. php:method:: getLeafletVar()

        Return the map Leaflet variable name

        :returns: The map Leaflet variable name
        :rtype: string

    .. php:method:: id(string $value)

        Set the map widget HTML ID

        :param string $id: The map widget HTML ID
        :returns: A new `Map` instance with the map widget HTML ID
        :rtype: Map

    .. php:method:: leafletVar(string $leafletVar)

        Set the map Leaflet variable name

        :param string $leafletVar: The Leaflet variable name
        :returns: A new `Map` instance with the Leaflet variable name
        :rtype: Map

    .. php:method:: options(array $options)

        Set the map options

        :param array[string=>mixed]: The map options
        :returns: A new `Map` instance with the map options added
        :rtype: Map

    .. php:method:: render()

        Render the map HTML and register the Leaflet JavaScript

        :returns: The map HTML
        :rtype: string

    .. php:method:: tag(string $tag)

        Set the container tag containing the map

        Default `div`

        :param string $tag: The container tag
        :returns: A new `Map` instance with the container tag
        :rtype: Map