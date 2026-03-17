<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Layers\UI;

use BeastBytes\Yii\Leaflet\Layers\Layer;
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
final class Tooltip extends Layer
{
    /**
     * @param string $content Tooltip content
     * @param array<string, mixed> $options Tooltip options
     */
    public function __construct(private readonly string $content, array $options = [])
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
        return "$leafletVar.tooltip({$this->options2Js($leafletVar)})"
            . ".setContent('$this->content')"
            . $this->bind($leafletVar);
    }
}