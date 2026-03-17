VideoOverlay Class
==================

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\Raster

.. php:class:: VideoOverlay

    VideoOverlay loads and displays a video player over specific bounds of the map

    @template T of array{float, float}|array{float, float, float}|array{lat: float, lng: float}|array{lat: float, lng: float, alt: float}|LatLng

    .. php:method:: __construct(string $url, array|LatLngBounds $bounds, array $options = [])

        Create a new VideoOverlay instance

        :param string $url: Video URL
        :param array{T, T}|LatLngBounds $bounds: The bounds of the overlay
        :param array<string, mixed>. $options: VideoOverlay options
        :returns: A new `VideoOverlay` instance
        :rtype: VideoOverlay

.. |component| replace:: VideoOverlay

.. include:: /snippets/layer.rst
.. include:: /snippets/component.rst

.. seealso::

    `Leaflet VideoOverlay documentation <https://leafletjs.com/reference.html#videooverlay>`__
