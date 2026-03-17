TileLayer Class
===============

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\Raster

.. php:class:: TileLayer

    TileLayer loads and displays tile layers on the map

    .. note::
        Most tile servers require attribution, which can be set using the `attribution` option

    .. php:method:: __construct(string $url, array $options = [])

        Create a new TileLayer instance

        :param string $url: Tile URL template
        :param array<string, mixed>. $options: TileLayer options
        :returns: A new `TileLayer` instance
        :rtype: TileLayer

.. |component| replace:: TileLayer

.. include:: /snippets/layer.rst
.. include:: /snippets/component.rst

.. seealso::

    `Leaflet TileLayer documentation <https://leafletjs.com/reference.html#tilelayer>`__
