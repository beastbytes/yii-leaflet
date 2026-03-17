WmsTileLayer Class
==================

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\Raster

.. php:class:: WmsTileLayer

    WmsTileLayer is used to display WMS services as tile layers on the map

    .. php:method:: __construct(string $url, array $options = [])

        Create a new WmsTileLayer instance

        :param string $url: Base URL of the WMS service
        :param array<string, mixed>. $options: WmsTileLayer options
        :returns: A new `WmsTileLayer` instance
        :rtype: WmsTileLayer

.. |component| replace:: WmsTileLayer

.. include:: /snippets/layer.rst
.. include:: /snippets/component.rst

.. seealso::

    `Leaflet WmsTileLayer documentation <https://leafletjs.com/reference.html#tilelayer-wms>`__

    `Web Map Services <https://www.ogc.org/standards/wms/>`__
