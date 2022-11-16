<?php
/**
 * @copyright Copyright (c) 2022 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\ui;

use BeastBytes\Widgets\Leaflet\layers\Layer;
use BeastBytes\Widgets\Leaflet\LeafletInterface;
use JsonException;

/**
 * Represents a Tooltip on the map
 *
 * @link https://leafletjs.com/reference.html#tooltip
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 */
final class Tooltip extends Layer implements LeafletInterface
{
    public function __construct(private string $content, array $options = [])
    {
        parent::__construct($options);
    }

    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        return "$leafletVar.tooltip({$this->options2Js($leafletVar)}).setContent('$this->content')"
            . $this->bind($leafletVar);
    }
}
