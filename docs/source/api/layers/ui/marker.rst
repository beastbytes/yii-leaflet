Marker Class
============

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\UI

.. php:class:: Marker

    Represents a marker; a clickable/draggable icon on the map

    @template T of array{float, float}|array{float, float, float}|array{lat\: float, lng\: float}|array{lat\: float, lng\: float, alt\: float}|LatLng

    .. php:method:: __construct(array|LatLng $location, array $options = [])

        Create a new Marker instance

        :param T $location: The marker geographical location
        :param array<string, mixed>. $options: marker options
        :returns: A new `Marker` instance
        :rtype: Marker

.. seealso::

    `Leaflet Marker documentation <https://leafletjs.com/reference.html#marker>`__
