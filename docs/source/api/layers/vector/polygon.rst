Polygon Class
=============

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\Vector

.. php:class:: Polygon

    Represents a Polygon on a map

    @Template T of array{float, float}|array{float, float, float}|array{lat\: float, lng\: float}|array{lat\: float, lng\: float, alt\: float}|LatLng

    .. php:method:: __construct(array $locations, array $options = [])

        Create a new `Polygon` instance

        A polygon is defined by a list of geographical locations

        The polygon is automatically closed and the list of geographical locations *should not* have a final location equal to the first

        Multiple polygon definitions can be defined by passing a list of polygon definitions;
        the first polygon definition is the outer polygon, the other polygon definitions define holes in the outer polygon

        :param list<T|list<T>>. $locations: A list of geographical locations or a list of lists of geographical locations
        :param array<string, mixed>. $options: Polygon options

.. |component| replace:: Polygon
.. include:: /snippets/layer.rst
.. include:: /snippets/component.rst

.. seealso::

    `Leaflet Polygon documentation <https://leafletjs.com/reference.html#polygon>`__
