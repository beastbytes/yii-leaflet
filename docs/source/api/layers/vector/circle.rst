Circle Class
============

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\Vector

.. php:class:: Circle

    Represents a circle on the map with its centre at a geographical location with a radius given in metres

    @template T of array{float, float}|array{float, float, float}|array{lat: float, lng: float}|array{lat: float, lng: float, alt: float}|LatLng

    .. php:method:: __construct(array|LatLng $location, array $options)

        Create a new `Circle` instance

        :param T $location: The geographical location - centre - of the circle
        :param array<string, mixed>. $options: Circle options. 'radius' is required and must be a positive number
        :returns: A new `Circle` instance
        :rtype: Circle

.. |component| replace:: Circle
.. include:: /snippets/layer.rst
.. include:: /snippets/component.rst

.. seealso::

    `Leaflet Circle documentation <https://leafletjs.com/reference.html#circle>`__
