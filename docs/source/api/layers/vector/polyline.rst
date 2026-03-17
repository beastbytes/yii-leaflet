Polyline Class
==============

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\Vector

.. php:class:: Polyline

    Represents one or more lines on a map

    @Template T of array{float, float}|array{float, float, float}|array{lat\: float, lng\: float}|array{lat\: float, lng\: float, alt\: float}|LatLng

    .. php:method:: __construct(array $locations, array $options = [])

        Create a new `Polyline` instance

        A line is defined by a list of geographical locations

        Multiple lines can be defined by passing a list of line definitions

        :param list<T|list<T>>. $locations: A list of geographical locations or a list of lists of geographical locations
        :param array<string, mixed>. $options: Polyline options

.. |component| replace:: Polyline
.. include:: /snippets/layer.rst
.. include:: /snippets/component.rst

.. seealso::

    `Leaflet Polyline documentation <https://leafletjs.com/reference.html#polyline>`__
