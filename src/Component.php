<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet;

use BeastBytes\Widgets\Leaflet\controls\Control;
use BeastBytes\Widgets\Leaflet\layers\Layer;

/**
 * Base class for Leaflet components
 */
abstract class Component extends Base
{
    use EventsTrait;

    /**
     * @var bool Whether the component is added to the map using the addTo() method
     * Set FALSE when the addTo() method is not to be generated, e.g. layers defined in the map constructor
     */
    private bool $addToMap = true;

    /**
     * @var string Component JavaScript variable name
     */
    private string $jsVar = '';

    /**
     * @var array Counters to ensure all components on a page are unique
     */
    private static array $counters = [
        'control' => 0,
        'layer' => 0,
        'plugin' => 0
    ];

    /**
     * @var bool $addToMap Whether to add the component to the map
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
     * @var string $jsVar The component's JavaScript variable name
     */
    public function jsVar(string $jsVar): self
    {
        $new = clone $this;
        $new->jsVar = $jsVar;

        return $new;
    }

    /**
     * @return string The component's JavaScript variable name
     * @internal
     */
    public function getJsVar(): string
    {
        if (empty($this->jsVar)) {
            if ($this instanceof Control) {
                $key = 'control';
            } elseif ($this instanceof Layer) {
                $key = 'layer';
            } else {
                $key = 'plugin';
            }

            $this->jsVar = $key . self::$counters[$key]++;
        }

        return $this->jsVar;
    }

    abstract public function toJs(string $leafletVar): string;
}
