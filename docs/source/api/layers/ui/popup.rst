Popup Class
===========

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\UI

.. php:class:: Popup

    Represents a popup

    @template T of array{float, float}|array{float, float, float}|array{lat\: float, lng\: float}|array{lat\: float, lng\: float, alt\: float}|LatLng

    .. php:method:: __construct(string $content, array|LatLng $location = [], array $options = [])

        :param string $content: The popup content
        :param T $location: The popup geographical location
        :param array<string, mixed>. $options: popup options
        :returns: A new `Popup` instance
        :rtype: Popup

.. seealso::

    `Leaflet Popup documentation <https://leafletjs.com/reference.html#popup>`__
