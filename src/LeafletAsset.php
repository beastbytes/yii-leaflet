<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet;

use Yiisoft\Assets\AssetBundle;
use Yiisoft\View\WebView;

/**
 * Leaflet asset bundle
 */
final class LeafletAsset extends AssetBundle
{
    public array $css = ['leaflet.css'];
    public array $js = ['leaflet.js'];
    public ?string $sourcePath = '@npm/leaflet/dist';
}