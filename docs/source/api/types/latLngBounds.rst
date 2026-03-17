LatLongBounds Class
===================

.. php:namespace:: BeastBytes\Yii\Leaflet\Types

.. php:class:: LatLngBounds

    Represents a rectangular geographical area on a map

    @template T of array{float, float}array{float, float, float}|array{lat\: float, lng\: float}|array{lat\: float, lng\: float, alt\: float}|LatLng

    .. php:method:: __construct(array|LatLng $corner1, array|LatLng $corner2)

        Create a new `LatLngBounds` instance

        .. note::
            If the area crosses the antimeridian,
            a corner whose longitude is outside the range -180 <= longitude <= 180 must be specified

        :param T $corner1: A geographical location that is a corner of the bounding box
        :param T $corner2: A geographical location that is the diagonally opposite corner of the bounding box from $corner1
        :returns: A new `LatLngBounds` instance
        :rtype: LatLngBounds

.. seealso::

    `Leaflet LatLngBounds documentation <https://leafletjs.com/reference.html#latlngbounds>`__
