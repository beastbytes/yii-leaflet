<?php
/**
 * @copyright Copyright © 2022 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet;

/**
 * LeafletInterface should be implemented by all Leaflet objects
 */
interface LeafletInterface
{
    /**
     * @param string $leafletVar
     * @return string Object JavaScript
     */
    public function toJs(string $leafletVar): string;
}