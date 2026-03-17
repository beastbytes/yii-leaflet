FeatureGroup Class
==================

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\Other

.. php:class:: FeatureGroup

    Represents a FeatureGroup; an extended LayerGroup that makes it easier to do the same thing to all its member layers:

    * bindPopup and bindTooltip bind a popup/tooltip to all of the layers
    * Events are propagated to the FeatureGroup, so if the group has an event handler,
        it will handle events, including mouse events and custom events, from any of the layers
    * Has `layeradd` and `layerremove` events

    .. php:method:: __construct(array $layers = [], array $options = [])

        Create a new FeatureGroup instance

        :param list<Layer>. $layers: The FeatureGroup geographical layers
        :param array<string, mixed>. $options: FeatureGroup options
        :returns: A new `FeatureGroup` instance
        :rtype: FeatureGroup

.. |component| replace:: FeatureGroup

.. include:: /snippets/layer.rst
.. include:: /snippets/component.rst

.. seealso::

    `Leaflet FeatureGroup documentation <https://leafletjs.com/reference.html#featuregroup>`__
