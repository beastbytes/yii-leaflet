<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Layers\Vector;

use BeastBytes\Yii\Leaflet\BoundsTrait;
use BeastBytes\Yii\Leaflet\Layers\Layer;
use BeastBytes\Yii\Leaflet\LeafletInterface;
use BeastBytes\Yii\Leaflet\Types\LatLng;
use BeastBytes\Yii\Leaflet\Types\LatLngBounds;
use JsonException;

/**
 * Represents a SvgOverlay on the map
 *
 * Used to load, display, and provide DOM access to an SVG file over specific bounds of the map
 *
 * @link https://leafletjs.com/reference.html#svgoverlay
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
final class SvgOverlay extends Layer
{
    use BoundsTrait;

    private const SVG_OVERLAY = <<<'CONST'
const %s=document.createElementNS("%s","svg");
%1$s.setAttribute("xmlns","%2$s");
%1$s.setAttribute("viewBox","%s");
%1$s.innerHTML='%s';
%s.svgOverlay(%1$s,%s%s)
%s
CONST;

    /**
     * @var string JavaScript variable name for the SVG element
     */
    protected string $jsVar = 'svgElement';
    /**
     * @var string SVG namespace
     */
    private string $namespace = 'http://www.w3.org/2000/svg';
    private string $viewBox;

    /**
     * @param string $innerHtml
     * @param array{int, int, int, int}|string $viewBox
     * @param array{T, T}|LatLngBounds $bounds
     * @param array<string, mixed> $options
     */
    public function __construct(
        private readonly string $innerHtml,
        array|string $viewBox,
        array|LatLngBounds $bounds,
        array $options = []
    )
    {
        $this->viewBox = is_array($viewBox) ? implode(' ', $viewBox) : $viewBox;

        $this->setBounds($bounds);
        parent::__construct($options);
    }

    /**
     * Returns a new instance with the specified namespace
     *
     * @param string $value The namespace
     * @return self
     */
    public function namespace(string $value): self
    {
        $new = clone $this;
        $new->namespace = $value;
        return $new;
    }

    /**
     * @var int Counter to ensure all Leaflet SVG elements are unique
     */
    private static int $counter = 0;

    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        $bounds = $this->bounds->toJs($leafletVar);
        $options = $this->options2Js($leafletVar);

        $svgElement = $this->jsVar . self::$counter++;
        return sprintf(
            self::SVG_OVERLAY,
            $svgElement,
            $this->namespace,
            $this->viewBox,
            $this->innerHtml,
            $leafletVar,
            $bounds,
            $options ? ",$options" : '',
            $this->bind($leafletVar)
        );
    }
}