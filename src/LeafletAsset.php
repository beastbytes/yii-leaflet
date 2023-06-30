<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet;

use Yiisoft\Assets\AssetBundle;
use Yiisoft\View\WebView;

/**
 * Leaflet asset bundle
 */
class LeafletAsset extends AssetBundle
{
    public array $css = ['leaflet.css'];
    public ?int $cssPosition = WebView::POSITION_HEAD;
    public array $js = ['leaflet.js'];
    public ?int $jsPosition = WebView::POSITION_END;
    public ?string $sourcePath = '@vendor/npm-asset/leaflet/dist';
}
