LatLng Class
============

.. php:namespace:: BeastBytes\Yii\Leaflet\Types

.. php:class:: LatLng

    Represents a geographical location at a given latitude and longitude, optionally with an altitude

    Latitude is checked to ensure it is in range -90 <= latitude <= 90

    .. note::
        Longitude is not checked as an *out of bounds* longitude is necessary if a :php:class:`LatLngBounds` spans the antemeridian

    .. php:method:: __construct(array|float $latitude, ?float $longitude = null, ?float $altitude = null, bool $checkLng = true)

        Create a new LatLng instance

        Latitude and longitude are given in degrees decimal, altitude is given in metres

        :param array{float, float}|array{float, float, float}|array{lat\: float, lng\: float}|array{lat\: float, lng\: float, alt\: float}|float $latitude:

            * float - Latitude
            * array{float, float}|array{lat: float, lng: float} - Latitude and Longitude
            * array{float, float, float}|array{lat: float, lng: float, alt: float} - Latitude, Longitude, and Altitude

        :param ?float $longitude: Longitude (ignored if `$latitude` is an array)
        :param ?float $altitude: Altitude (ignored if `$latitude` is an array)
        :returns: A new `LatLng` instance
        :rtype: LatLng
        :throws: InvalidArgumentException if `$latitude` out of bounds

.. seealso::

    `Leaflet LatLng documentation <https://leafletjs.com/reference.html#latlng>`__
