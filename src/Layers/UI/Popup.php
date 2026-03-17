<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Layers\UI;

use BeastBytes\Yii\Leaflet\Layers\Layer;
use BeastBytes\Yii\Leaflet\LocationTrait;
use BeastBytes\Yii\Leaflet\Types\LatLng;
use JsonException;

/**
 * Represents a Popup on the map
 *
 * @link https://leafletjs.com/reference.html#popup
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 *
 * @template T of array{float, float}|array{float, float, float}|array{lat: float, lng: float}|array{lat: float, lng: float, alt: float}|LatLng
 */
final class Popup extends Layer
{
    use LocationTrait;

    /**
     * @param string $content Popup content
     * @param T $location Popup geographical location
     * @param array<string, mixed> $options Popup options
     */
    public function __construct(private readonly string $content, array|LatLng $location, array $options = [])
    {
        $this->setLocation($location);
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
        return "$leafletVar.popup({$this->options2Js($leafletVar)})"
            . ".setContent('$this->content')"
            . ".setLatLng({$this->location->toJs($leafletVar)})"
            . $this->bind($leafletVar);
    }
}