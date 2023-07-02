<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\vector;

use BeastBytes\Widgets\Leaflet\BoundsTrait;
use BeastBytes\Widgets\Leaflet\layers\Layer;
use BeastBytes\Widgets\Leaflet\LeafletInterface;
use BeastBytes\Widgets\Leaflet\types\LatLngBounds;
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
 */
final class SvgOverlay extends Layer implements LeafletInterface
{
    use BoundsTrait;

    /**
     * @var string JavaScript variable name for the SVG element
     */
    protected string $jsVar = 'svgElement';
    /**
     * @var string SVG namespace
     */
    private string $namespace = 'http://www.w3.org/2000/svg';

    /**
     */
    public function __construct(
        private string $innerHtml,
        private array|string $viewBox,
        array|LatLngBounds $bounds,
        array $options = []
    )
    {
        if (is_array($viewBox)) {
            $this->viewBox = implode(' ', $viewBox);
        }

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
        return "const $svgElement=document.createElementNS(\"$this->namespace\",\"svg\");"
            . "$svgElement.setAttribute(\"xmlns\",\"$this->namespace\");"
            . "$svgElement.setAttribute(\"viewBox\",\"$this->viewBox\");"
            . "$svgElement.innerHTML='$this->innerHtml';"
            . "$leafletVar.svgOverlay($svgElement,$bounds" . (!empty($options) ? ",$options" : '') . ')'
            . $this->bind($leafletVar);
    }
}
