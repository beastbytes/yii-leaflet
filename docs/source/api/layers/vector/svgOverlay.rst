SvgOverlay Class
================

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\Vector

.. php:class:: SvgOverlay

    SvgOverlay allows the display of and provides DOM access to an SVG file over specific bounds of the map

    @template T of array{float, float}array{float, float, float}|array{lat\: float, lng\: float}|array{lat\: float, lng\: float, alt\: float}|LatLng

    .. php:method:: function __construct(string $innerHtml, array|string $viewBox, array|LatLngBounds $bounds, array $options = [])

        :param string $innerHtml: The SVG content
        :param array{int, int, int, int}|string $viewBox: The SVG view box
        :param array{T, T}|LatLngBounds $bounds: The overlay geographical bounds; either an array of corners or a LatLngBounds object
        :param array<string, mixed>. $options: SVGOverlay options

.. |component| replace:: SvgOverlay
.. include:: /snippets/layer.rst
.. include:: /snippets/component.rst

.. seealso::

    `Leaflet SvgOverlay documentation <https://leafletjs.com/reference.html#svgoverlay>`__
