Bounds Class
============

.. php:namespace:: BeastBytes\Yii\Leaflet\Types

.. php:class:: Bounds

    Represents a rectangular area on a map in pixel coordinates

    @template T array{0\: int, 1\: int}|array{x\: int, y\: int}|Point

    .. php:method:: __construct(array|Point $corner1, array|Point $corner2)

        Create a new `Bounds` instance

        :param T $corner1: The top-left corner
        :param T $corner2: The bottom-right corner
        :returns: A new `Bounds` instance
        :rtype: Bounds

.. seealso::

    `Leaflet Bounds documentation <https://leafletjs.com/reference.html#bounds>`__
