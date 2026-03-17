Rectangle Class
===============

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\Vector

.. php:class:: Rectangle

    Represents a rectangle on a map with its corners at defined geographical points

    @template T of array{float, float}array{float, float, float}|array{lat\: float, lng\: float}|array{lat\: float, lng\: float, alt\: float}|LatLng

    .. php:method:: __construct(array|LatLngBounds $bounds, array $options = [])

        Create a new `Rectangle` instance

        :param array{T, T}|LatLngBounds $bounds: The rectangle geographical bounds; either an array of corners or a LatLngBounds object
        :param array<string, mixed>. $options: Rectangle options
        :returns: A new `Rectangle` instance
        :rtype: Rectangle

.. |component| replace:: Rectangle
.. include:: /snippets/layer.rst
.. include:: /snippets/component.rst

.. seealso::

    `Leaflet Rectangle documentation <https://leafletjs.com/reference.html#rectangle>`__
