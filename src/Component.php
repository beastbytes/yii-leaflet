<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet;

use BeastBytes\Yii\Leaflet\Controls\Control;
use BeastBytes\Yii\Leaflet\Layers\Layer;

/**
 * Base class for Leaflet components
 */
abstract class Component extends Base implements LeafletInterface
{
    use EventsTrait;

    /**
     * @var bool Whether the component is added to the map using the addTo() method
     * Set FALSE when the addTo() method is not to be generated, e.g. layers defined in the map constructor
     */
    private bool $addToMap = true;

    /**
     * @var ?string Component JavaScript variable name. Auto generated if NULL
     */
    private ?string $jsVar = null;

    /**
     * @var array Counters to ensure all components on a page are unique
     */
    private static array $counters = [
        'control' => 0,
        'layer' => 0,
        'plugin' => 0
    ];

    /**
     * @param bool $addToMap Whether to add the component to the map
     * @return self
     */
    public function addToMap(bool $addToMap): self
    {
        $new = clone $this;
        $new->addToMap = $addToMap;
        return $new;
    }

    /**
     * @return bool
     * @internal
     */
    public function getAddToMap(): bool
    {
        return $this->addToMap;
    }

    /**
     * @param string $jsVar The component's JavaScript variable name
     */
    public function jsVar(string $jsVar): self
    {
        $new = clone $this;
        $new->jsVar = $jsVar;
        return $new;
    }

    /**
     * @return string The component's JavaScript variable name
     */
    public function getJsVar(): string
    {
        if ($this->jsVar === null) {
            if ($this instanceof Control) {
                $type = 'control';
            } elseif ($this instanceof Layer) {
                $type = 'layer';
            } else {
                $type = 'plugin';
            }

            $this->jsVar = $type . self::$counters[$type]++;
        }

        return $this->jsVar;
    }

    abstract public function toJs(string $leafletVar): string;
}