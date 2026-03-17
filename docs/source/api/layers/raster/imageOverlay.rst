ImageOverlay Class
==================

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\Raster

.. php:class:: ImageOverlay

    ImageOverlay loads and displays an image file over specific bounds of the map

    @template T of array{float, float}|array{float, float, float}|array{lat: float, lng: float}|array{lat: float, lng: float, alt: float}|LatLng

    .. php:method:: __construct(string $url, array|LatLngBounds $bounds, array $options = [])

        Create a new ImageOverlay instance

        :param string $url: Image URL
        :param array{T, T}|LatLngBounds $bounds: The bounds of the overlay
        :param array<string, mixed>. $options: ImageOverlay options
        :returns: A new `ImageOverlay` instance
        :rtype: ImageOverlay

.. |component| replace:: ImageOverlay

.. include:: /snippets/layer.rst
.. include:: /snippets/component.rst

.. seealso::

    `Leaflet ImageOverlay documentation <https://leafletjs.com/reference.html#imageoverlay>`__
