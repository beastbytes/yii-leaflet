<?php
/**
 * @copyright Copyright (c) 2022 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet;

use Yiisoft\Assets\AssetBundle;

/**
 * Leaflet asset bundle
 */
class LeafletAsset extends AssetBundle
{
    /**
     * @var string[] CSS to be published
     */
    public array $css = ['leaflet.css'];
    /**
     * @var string[] JavaScript to be published
     */
    public array $js = ['leaflet.js'];
    /**
     * @var ?string The directory that contains the Leaflet asset files
     */
    public ?string $sourcePath = '@vendor/npm-asset/leaflet/dist';
}
