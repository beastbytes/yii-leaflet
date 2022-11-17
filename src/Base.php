<?php
/**
 * @copyright Copyright (c) 2022 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet;

/**
 * Base class for Leaflet objects that accept options
 */
abstract class Base
{
    use OptionsTrait;

    /**
     * @param array $options Component options
     */
    public function __construct(array $options = []) {
        $this->options = $options;
    }
}
