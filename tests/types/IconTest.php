<?php
/**
 * @copyright Copyright © 2022 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace Tests\types;

use BeastBytes\Widgets\Leaflet\types\Icon;
use BeastBytes\Widgets\Leaflet\types\Point;
use PHPUnit\Framework\TestCase;

class IconTest extends TestCase
{
    const LEAFLET_VAR = 'L';

    public function test_icon()
    {
        $options = [
            'iconUrl' => 'my-icon.png',
            'iconSize' => [38, 95],
            'iconAnchor' => [22, 94],
            'popupAnchor' => [-3, -76],
            'shadowUrl' => 'my-icon-shadow.png',
            'shadowSize' => [68, 95],
            'shadowAnchor' => [22, 94]
        ];

        $icon = new Icon($options);

        $this->assertSame(
            self::LEAFLET_VAR .
                '.icon({'
                    . 'iconUrl:"my-icon.png",'
                    . 'iconSize:[38,95],'
                    . 'iconAnchor:[22,94],'
                    . 'popupAnchor:[-3,-76],'
                    . 'shadowUrl:"my-icon-shadow.png",'
                    . 'shadowSize:[68,95],'
                    . 'shadowAnchor:[22,94]'
                . '})',
            $icon->toJs(self::LEAFLET_VAR));
    }
}
