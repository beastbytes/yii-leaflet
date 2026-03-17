GeoJson Class
=============

.. php:namespace:: BeastBytes\Yii\Leaflet\Layers\Other

.. php:class:: GeoJson

    .. php:method:: __construct(array|string $data, array $options = [])

        Create a new GeoJson instance

        :param array|string $data: GeoJson data. Either a GeoJson object string or an array that `json_encode` can transform into a GeoJson object string
        :param array<string, mixed>. $options: GeoJson options
        :returns: A new `GeoJson` instance
        :rtype: GeoJson

.. |component| replace:: GeoJson

.. include:: /snippets/layer.rst
.. include:: /snippets/component.rst

.. seealso::

    `Leaflet GeoJson documentation <https://leafletjs.com/reference.html#geojson>`__

    `GeoJson Format <https://datatracker.ietf.org/doc/html/rfc7946>`__
