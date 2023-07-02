<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\other;

use BeastBytes\Widgets\Leaflet\layers\Layer;
use BeastBytes\Widgets\Leaflet\LeafletInterface;
use JsonException;

/**
 * Represents a GeoJSON object or an array of GeoJSON objects
 *
 * @link https://leafletjs.com/reference.html#geojson
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 */
final class GeoJson extends Layer implements LeafletInterface
{
    /**
     * @throws JsonException
     */
    public function __construct(private array|string $data = [], array $options = [])
    {
        if (!empty($this->data) && is_array($this->data)) {
            $this->data = json_encode($this->data, JSON_THROW_ON_ERROR);
        }

        parent::__construct($options);
    }

    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        $options = $this->options2Js($leafletVar);

        if (!empty($this->data)) {
            return "$leafletVar.geoJson($this->data" . (!empty($options) ? ",$options" : '') . ')'
                . $this->bind($leafletVar);
        }

        return "$leafletVar.geoJson(" . (!empty($options) ? ",$options" : '') . ')'
            . $this->bind($leafletVar);
    }
}
