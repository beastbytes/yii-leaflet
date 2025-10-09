<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Tests\support;

use Yiisoft\Aliases\Aliases;
use Yiisoft\Assets\AssetLoader;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Cache\Cache;
use Yiisoft\Cache\CacheInterface;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Test\Support\EventDispatcher\SimpleEventDispatcher;
use Yiisoft\Test\Support\SimpleCache\MemorySimpleCache;
use Yiisoft\View\WebView;
use Yiisoft\Widget\WidgetFactory;

trait TestTrait
{
    private CacheInterface $cache;
    private WebView $view;

    protected function setUp(): void
    {
        parent::setUp();

        $aliases = new Aliases(['@npm' => __DIR__]);
        $loader = new AssetLoader(
            aliases: $aliases,
            basePath: __DIR__ . DIRECTORY_SEPARATOR . 'assets',
            baseUrl: '/'
        );

        $container = new SimpleContainer(
            [
                AssetManager::class => new AssetManager($aliases, $loader),
                CacheInterface::class => new Cache(new MemorySimpleCache()),
                WebView::class => new WebView(
                    __DIR__ . DIRECTORY_SEPARATOR . 'views',
                    new SimpleEventDispatcher()
                ),
            ]
        );

        WidgetFactory::initialize($container, []);

        $this->cache = $container->get(CacheInterface::class);
        $this->view = $container
            ->get(WebView::class)
            ->setParameters(['assetManager' => $container->get(AssetManager::class)])
        ;
    }
}