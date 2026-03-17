LayerGroup Class
================

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\Other

.. php:class:: LayerGroup

    Represents a group of layers in order to handle them as a single entity

    If the layer group is added to the map,
    any layers added to or removed from the group will also be added/removed on the map

    .. php:method:: __construct(array $layers = [], array $options = [])

        Create a new LayerGroup instance

        :param list<Layer>. $layers: Layers
        :param array<string, mixed>. $options: LayerGroup options
        :returns: A new `LayerGroup` instance
        :rtype: LayerGroup

.. |component| replace:: LayerGroup

.. include:: /snippets/layer.rst
.. include:: /snippets/component.rst

.. seealso::

    `Leaflet LayerGroup documentation <https://leafletjs.com/reference.html#layergroup>`__
