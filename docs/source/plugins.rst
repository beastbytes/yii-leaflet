Plugins
=======

Yii-Leaflet supports Leaflet Plugins.

Install the plugin according to its documentation.

A Leaflet Plugin requires a corresponding PHP class that extends :php:class:`Component`
and implement the :php:meth:`Component::getJs` method.

It will also require an AssetBundle to define the Plugin's JavaScript and CSS;
this is registered in the view in the normal way.

Example
-------

The PHP class for the `Fullscreen plugin by brunob <https://github.com/brunob/leaflet.fullscreen>`__

.. code-block:: php

    final class Fullscreen extends BeastBytes\Yii\Leaflet\Component
    {
        public function toJs(string $leafletVar): string
        {
            return "$leafletVar.control.FullScreen({$this->options2Js($leafletVar)})";
        }
    }

an example asset bundle

.. code-block:: php

    use Yiisoft\Assets\AssetBundle;

    final class LeafletAsset extends AssetBundle
    {
        public array $css = ['Control.FullScreen.css'];
        public array $js = ['Control.FullScreen.umd.jss'];
        public ?string $sourcePath = '@npm/leaflet/plugins/fullscreen/dist';
    }

.. seealso::

    `Leaflet Plugins <https://leafletjs.com/plugins.html>`__
