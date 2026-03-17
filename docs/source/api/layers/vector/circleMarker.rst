CircleMarker Class
==================

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\Vector

.. php:class:: CircleMarker

    Represents a circle on the map with its centre at a geographical location with a radius given in pixels

    @template T of array{float, float}|array{float, float, float}|array{lat: float, lng: float}|array{lat: float, lng: float, alt: float}|LatLng

    .. php:method:: __construct(array|LatLng $location, array $options)

        Create a new `CircleMarker` instance

        :param T $location: The geographical location - centre - of the circle
        :param array<string, mixed>. $options: CircleMarker options. 'radius' is required and must be a positive integer
        :returns: A new `CircleMarker` instance
        :rtype: CircleMarker

.. |component| replace:: CircleMarker
.. include:: /snippets/layer.rst
.. include:: /snippets/component.rst

.. seealso::

    `Leaflet CircleMarker documentation <https://leafletjs.com/reference.html#circlemarker>`__
