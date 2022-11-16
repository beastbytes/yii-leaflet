<?php
/**
 * @copyright Copyright (c) 2022 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet\layers\raster;

/**
 * Defines tile providers that can be used to load and display map tiles.
 *
 * Port of @link(https://github.com/leaflet-extras/leaflet-providers Leaflet Providers)
 *
 * @property bool $addToMap
 * @property bool $draggable
 * @property array $events
 * @property array $options
 * @property array|string $popup
 * @property array|string $tooltip
 */
final class TileProvider
{
    private const ATTRIBUTION_PATTERN = '/\{attribution.(\w*)}/';
    private const TILE_PROVIDERS = 'tileProviders.php';

    /**
     * @param array|string $tileProviders Either an array of tile providers or a path to a file that contains an
     * array of tile providers. Default is the local tile providers file
     */
    public function __construct(private array|string $tileProviders = '')
    {
        if (empty($this->tileProviders)) {
            $this->tileProviders = __DIR__ . DIRECTORY_SEPARATOR . self::TILE_PROVIDERS;
        }

        if (is_string($this->tileProviders)) {
            $this->tileProviders = require $this->tileProviders;
        }
    }

    /**
     * @param string $name Name of the tile provider. Variants are specified using 'dot' format, e.g. OpenStreetMap.HOT
     * @param array $options Additional options for the tile provider
     * @param bool $forceHttp Whether to force HTTP only if URL is protocol-relative. By default, HTTPS is tried first.
     * @return \BeastBytes\Leaflet\layers\raster\TileLayer
     */
    public function use(string $name, array $options = [], bool $forceHttp = false): TileLayer
    {
        $tileProvider = explode('.', $name);

        $url = $this->tileProviders[$tileProvider[0]]['url'];
        $tileProviderOptions = $this->tileProviders[$tileProvider[0]]['options'];

        if (isset($tileProvider[1])) {
            $variant = $this->tileProviders[$tileProvider[0]]['variants'][$tileProvider[1]];

            if (is_string($variant)) {
                $tileProviderOptions['variant'] = $variant;
            } else {
                if (isset($variant['url'])) {
                    $url = $variant['url'];
                }

                if (isset($variant['options'])) {
                    $tileProviderOptions = array_merge($tileProviderOptions, $variant['options']);
                }
            }
        }

        $options = array_merge_recursive($tileProviderOptions, $options);

        // Force http if required
        if ($forceHttp && str_starts_with($url, '//')) {
            $url = 'http:' . $url;
        }

        // Replace attribution placeholders
        $options['attribution'] = $this->replaceAttribution($options['attribution']);

        return new TileLayer($url, $options);
    }

    /**
     * Recursively replaces placeholders in the attribution with values from the top level provider attribution
     *
     * @param string $attribution The attribution containing placeholders to replace
     * @return string The attribution with placeholders replaced
     */
    private function replaceAttribution(string $attribution): string
    {
        if (str_contains($attribution, '{attribution.')) {
            $matches = [];
            preg_match(self::ATTRIBUTION_PATTERN, $attribution, $matches);

            $attribution = preg_replace(
                self::ATTRIBUTION_PATTERN,
                $this->replaceAttribution($this->tileProviders[$matches[1]]['options']['attribution']),
                $attribution
            );
        }

        return $attribution;
    }
}
