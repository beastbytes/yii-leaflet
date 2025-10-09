<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet;

use Yiisoft\Assets\AssetBundle;
use Yiisoft\View\WebView;

/**
 * Leaflet asset bundle
 */
class LeafletAsset extends AssetBundle
{
    public array $css = ['leaflet.css'];
    public array $js = ['leaflet.js'];
    public ?string $sourcePath = '@npm/leaflet/dist';
}
