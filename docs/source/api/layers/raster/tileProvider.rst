TileProvider Class
==================

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\Raster

.. php:class:: TileProvider

    Register and provide a list of tile layers that can be used on the map

    The list of tile providers is an array where the keys are the names of tile providers
    and the values are tile provider configuration

    .. php:method:: __construct(array|string|null $tileProviders = null)

        Create a new TileProvider instance

        :param array{url\: string, options\: ?|string|null $tileProviders: Either:

            array: An array where the keys are the names of tile providers and the values are tile provider configuration
            string: Absolute path to a file that returns an array as described above
            null: use the package tile providers

        :param array<string, mixed>. $options: TileProvider options
        :returns: A new `TileProvider` instance
        :rtype: TileProvider

    .. php:method:: use(string $name, array $options = [], bool $forceHttp = false)

        Use the named TileLayer

        :param string $name: The name of the tile layer to use
        :param array<string, mixed>. $options: TileProvider options
        :returns: The named `TileLayer` instance
        :rtype: TileLayer

.. seealso::

    `Leaflet TileProvider documentation <https://leafletjs.com/reference.html#TileProvider>`__
