<?php
/**
 * @copyright Copyright (c) 2022 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet;

use BeastBytes\Widgets\Leaflet\controls\Control;
use BeastBytes\Widgets\Leaflet\layers\Layer;
use BeastBytes\Widgets\Leaflet\types\LatLng;
use BeastBytes\Widgets\Leaflet\types\LatLngBounds;
use JsonException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

/**
 * A leaflet map
 */
final class Map extends Widget
{
    use EventsTrait;
    use OptionsTrait;

    public const LEAFLET_VAR = 'L';
    private const COMPONENT_TYPE_CONTROLS = 'controls';
    private const COMPONENT_TYPE_LAYERS = 'layers';
    private const COMPONENT_TYPE_PLUGINS = 'plugins';
    private const COMPONENT_TYPES = [
        self::COMPONENT_TYPE_LAYERS, // self::COMPONENT_TYPE_LAYERS must be first
        self::COMPONENT_TYPE_CONTROLS,
        self::COMPONENT_TYPE_PLUGINS
    ];

    /**
     * @property array $options
     * @see $layers for how to specify the layers option
     * @link https://leafletjs.com/reference.html#map-factory
     */

    /**
     * @var array HTML attributes for the container tag
     * The `style` attribute must be set and specify a height
     */
    private array $attributes = [];
    /**
     * @var array Array of map controls
     */
    private array $controls = [];
    /**
     * @var array Array of map layers
     *
     * If a LayersControl is being added to the map use ["Layer Label" => Layer object] (the same applies to
     * $options['layers']) then provide the layer labels to LayersControl::baseLayers and LayersControl::overlays
     */
    private array $layers = [];
    /**
     * @var string The variable used by Leaflet
     *
     * If this is not the default `L` the noConflict() method is called and the new variable used for Leaflet.
     *
     * **WARNING:** _Some plugins require the default variable name for Leaflet_
     */
    private string $leafletVar = self::LEAFLET_VAR;

    /**
     * @var array Plugins
     */
    private array $plugins = [];
    /**
     * @psalm-param non-empty-string $tag
     */
    private string $tag = 'div';
    /**
     * @var array Map JavaScript
     */
    private array $js = [];
    /**
     * @var array Layers initially added to the map
     */
    private array $mapLayers = [];
    /**
     * @var int Counter to ensure all generated map ids are unique
     */
    private static int $counter = 0;

    public function addControls(Control ...$controls): self
    {
        $new = clone $this;

        foreach ($controls as $control) {
            $name = strtolower(substr($control::class, strrpos($control::class, '\\') + 1));
            $new->controls[$name] = $control;
        }

        return $new;
    }

    /**
     * @param array $layers ['label' => Layer]
     * @return $this
     */
    public function addLayers(array $layers): self
    {
        $new = clone $this;
        $new->layers = array_merge($new->layers, $layers);
        return $new;
    }

    public function addPlugins(Component ...$plugins): self
    {
        $new = clone $this;

        foreach ($plugins as $plugin) {
            $name = strtolower(substr($plugin::class, strrpos($plugin::class, '\\') + 1));
            $new->plugins[$name] = $plugin;
        }

        return $new;
    }

    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = array_merge($this->attributes, $attributes);
        return $new;
    }

    public function leafletVar(string $leafletVar): self
    {
        $new = clone $this;
        $new->leafletVar = $leafletVar;
        return $new;
    }

    public function options(array $options): self
    {
        $new = clone $this;
        $new->options = array_merge($this->options, $options);
        return $new;
    }

    public function tag(string $tag): self
    {
        $new = clone $this;
        $new->tag = $tag;
        return $new;
    }

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function beforeRun(): bool
    {
        if (parent::beforeRun()) {
            if (!isset($this->options['center'])) {
                throw new InvalidConfigException("`options['center']` must be set");
            }

            if (!isset($this->options['zoom'])) {
                throw new InvalidConfigException("`options['zoom']` must be set");
            }

            if (
                !isset($this->attributes['style'])
                || preg_match('/height:.*;/', $this->attributes['style']) === 0
            ) {
                throw new InvalidConfigException("`attributes['style']` must be set and define the height of the map");
            }

            if (is_array($this->options['center'])) {
                $this->options['center'] = new LatLng($this->options['center']);
            }

            if (isset($this->options['maxBounds']) && is_array($this->options['maxBounds'])) {
                $this->options['maxBounds'] = new LatLngBounds(
                    $this->options['maxBounds'][0],
                    $this->options['maxBounds'][1]
                );
            }

            if (!isset($this->attributes['id'])) {
                $this->attributes['id'] = 'map' . self::$counter++;
            }

            return true;
        }

        return false;
    }

    /**
     * Runs the widget
     *
     * @return string HTML for the widget
     */
    public function run(): string
    {
        return Html::tag($this->tag, '', $this->attributes)
            ->render()
        ;
    }

    /**
     * Returns the map JavaScript
     *
     * @return string
     * @throws InvalidConfigException
     * @throws JsonException
     */
    public function getJs(): string
    {
        $id = $this->attributes['id'];

        if ($this->leafletVar !== self::LEAFLET_VAR) {
            array_unshift(
                $this->js,
                "const $this->leafletVar=" . self::LEAFLET_VAR . '.noConflict();'
            );
        }

        // Generate code for layers defined in the map
        if (isset($this->options['layers'])) {
            foreach ($this->options['layers'] as $key => $layer) {
                /** @var \BeastBytes\Widgets\Leaflet\layers\Layer $layer */
                $layer = $layer->addToMap(false);
                $jsVar = $layer->getJsVar();
                $this->mapLayers[$key] = '!!'. $jsVar . '!!'; // !! <> !! mark it as a JS variable
                $this->js[] = "const $jsVar={$layer->toJs($this->leafletVar)};";
            }

            $this->options['layers'] = array_values($this->mapLayers);
        }

        $this->js[] = "const $id=$this->leafletVar.map(\"$id\",{$this->options2Js($this->leafletVar)})"
            . $this->events2Js() . ';'
        ;

        $this->components2Js();

        //return "function f$id(){" . implode('', $this->js) . ob_get_clean() . "}f$id();";
        return "function f$id(){" . implode('', $this->js) . "}f$id();";
    }

    /**
     * Generates JavaScript for map components - layers, controls, and plugins
     *
     * @return void
     * @throws JsonException
     */
    private function components2Js(): void
    {
        foreach (self::COMPONENT_TYPES as $componentType) {
            /**
             * @var \BeastBytes\Widgets\Leaflet\Component $component
             * @var string $key
             */
            foreach ($this->$componentType as $key => $component) {
                if ($componentType === self::COMPONENT_TYPE_LAYERS) {
                    $this->layers[$key] = $component->getJsVar();
                }

                if ($component instanceof LayersInterface) {
                    $this->setComponentLayers($component);
                }

                $js = "const {$component->getJsVar()}={$component->toJs($this->leafletVar)}";
                $js .= $component->events2Js();
                $js .= ($component->getAddToMap() ? '.addTo(' . $this->attributes['id'] . ')' : '');
                $this->js[] = $js . ';';
            }
        }
    }

    /**
     * Registers a plugin's assets
     *
     * Given a plugin whose class is Plugin, if Plugin::$assets exists and is set it is used as the FQCN of the
     * plugin's asset bundle, otherwise PluginAsset in the same directory as Plugin is registered as the asset bundle
     *
     * @param Component $plugin Plugin component
     */
    private function registerPluginAssets(Component $plugin): void
    {
        /** @var \Yiisoft\Assets\AssetBundle $assetClass
        $assetClass = $plugin->assets ?? get_class($plugin) . 'Asset';
        $assetClass::register($this->view); */
    }

    private function setComponentLayers(LayersInterface $component): void
    {
        $baseLayers = $overlays = [];

        foreach ($component->getBaseLayers() as $label) {
            if (isset($this->layers[$label])) {
                $baseLayers[$label] = $this->layers[$label];
            } elseif (isset($this->mapLayers[$label])) {
                $baseLayers[$label] = $this->mapLayers[$label];
            }
        }
        foreach ($component->getOverlays() as $label) {
            if (isset($this->layers[$label])) {
                $overlays[$label] = $this->layers[$label];
            } elseif (isset($this->mapLayers[$label])) {
                $overlays[$label] = $this->mapLayers[$label];
            }
        }

        // set the layers in the component; each layer is "label"=>layerJsVar
        $component->setBaseLayers($baseLayers);
        $component->setOverlays($overlays);
    }
}
