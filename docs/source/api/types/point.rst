Point Class
===========

.. php:namespace:: BeastBytes\Yii\Leaflet\Types

.. php:class:: Point

    Represents a point on a map with x and y coordinates in pixels

    .. php:method:: __construct(array|int $x, ?int $y = null)

        Create a new `Point` instance

        :param array{int, int}|array{x\: int, y\: int}|int $x:

            * int - x coordinate
            * array{0: int, 1: int}|array{x: int, y: int} - x and y coordinates

        :param ?int $y: y coordinate (ignored if `$x` is an array)
        :returns: A new `Point` instance
        :rtype: Point
        :throws: `InvalidArgumentException` If $x is an integer and $y is null

.. seealso::

    `Leaflet Point documentation <https://leafletjs.com/reference.html#point>`__
