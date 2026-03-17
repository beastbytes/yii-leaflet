<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Layers;

use JsonException;
use BeastBytes\Yii\Leaflet\Component;
use BeastBytes\Yii\Leaflet\Layers\UI\Popup;
use BeastBytes\Yii\Leaflet\Layers\UI\Tooltip;

/**
 * Base class for layers
 *
 * @link https://leafletjs.com/reference.html#layer
 */
abstract class Layer extends Component
{
    private ?Popup $popup = null;
    private ?Tooltip $tooltip = null;

    /**
     * Add a popup that is bound to the layer
     *
     * {@link https://leafletjs.com/reference.html#popup}
     *
     * @param string $content Popup content
     * @param array<string, mixed> $options Popup options
     * @return self
     */
    public function popup(string $content, array $options = []): self
    {
        $new = clone $this;
        $new->popup = new Popup($content, ['lat' => 0.0, 'lng' => 0.0], $options);
        return $new;
    }

    /**
     * Add a tooltip that is bound to the layer
     *
     * {@link https://leafletjs.com/reference.html#tooltip}
     *
     * @param string $content Tooltip content
     * @param array<string, mixed> $options Tooltip options
     * @return self
     */
    public function tooltip(string $content, array $options = []): self
    {
        $new = clone $this;
        $new->tooltip = new Tooltip(content: $content, options: $options);
        return $new;
    }

    /**
     * Generates JavaScript to bind a popup and/or tooltip
     *
     * @param string $leafletVar Leaflet variable name
     * @return string JavaScript to bind the popup and/or tooltip
     * @throws JsonException
     */
    protected function bind(string $leafletVar): string
    {
        $js = '';

        if (!empty($this->popup)) {
            $popupOptions = $this
                ->popup
                ->options2Js($leafletVar)
            ;
            $js .= '.bindPopup("'
                . addslashes($this->popup->getContent()) . '"'
                . (!empty($popupOptions) ? ",$popupOptions" : '')
                . ')'
            ;
        }

        if (!empty($this->tooltip)) {
            $tooltipOptions = $this
                ->tooltip
                ->options2Js($leafletVar)
            ;
            $js .= '.bindTooltip("'
                . addslashes($this->tooltip->getContent()) . '"'
                . (!empty($tooltipOptions) ? ",$tooltipOptions" : '')
                . ')'
            ;
        }

        return $js;
    }
}