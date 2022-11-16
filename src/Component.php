<?php
/**
 * @copyright Copyright (c) 2022 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet;

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
     * @var bool $value The component's JavaScript variable name
     * @return self
     */
    public function addToMap(bool $value): self
    {
        $new = clone $this;
        $new->addToMap = $value;
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
     * @var string $value The component's JavaScript variable name
     * @internal
     */
    public function setJsVar(string $value): void
    {
        $this->jsVar = $value;
    }

    /**
     * @return string The component's JavaScript variable name
     * @internal
     */
    public function getJsVar(): string
    {
        return $this->jsVar;
    }
}
