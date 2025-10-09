<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\types;

use BeastBytes\Yii\Leaflet\Base;
use BeastBytes\Yii\Leaflet\LeafletInterface;
use JsonException;

/**
 * Represents a lightweight icon for markers that uses a simple div element instead of an image
 *
 * @link https://leafletjs.com/reference.html#divicon
 */
final class DivIcon extends Base implements LeafletInterface
{
    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        return "$leafletVar.divIcon({$this->options2Js($leafletVar)})";
    }
}
