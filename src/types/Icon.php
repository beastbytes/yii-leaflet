<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\types;

use BeastBytes\Widgets\Leaflet\Base;
use BeastBytes\Widgets\Leaflet\LeafletInterface;
use InvalidArgumentException;
use JsonException;

/**
 * Represents an icon to provide when creating a marker
 *
 * @link https://leafletjs.com/reference.html#icon
 */
final class Icon extends Base implements LeafletInterface
{
    public const URL_NOT_SET_MESSAGE = 'The `iconUrl` option must be set in options';

    /**
     * @param array $options Options for the icon
     */
    public function __construct(array $options)
    {
        if (!isset($options['iconUrl'])) {
            throw new InvalidArgumentException(self::URL_NOT_SET_MESSAGE);
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
        return "$leafletVar.icon({$this->options2Js($leafletVar)})";
    }
}
