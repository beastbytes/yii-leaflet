<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All Rights Reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet;

use JsonException;
use Yiisoft\Json\Json;

/**
 * Trait for Leaflet objects that accept options
 */
trait OptionsTrait
{
    private array $options = [];

    /**
     * @param string $leafletVar
     * @return string JSON encoded options
     * @throws JsonException
     */
    protected function options2Js(string $leafletVar): string
    {
        $options = [];

        foreach ($this->options as $key => $value) {
            if ($value instanceof LeafletInterface) {
                $value = '!!' . $value->toJs($leafletVar) . '!!';
            } elseif (is_array($value) && current($value) instanceof LeafletInterface) {
                foreach ($value as $i => $v) {
                    $value[$i] = '!!' . $value->toJs($leafletVar) . '!!';
                }
            }

            $options[$key] = $value;
        }

        if (empty($options)) {
            return '';
        }

        $options = preg_replace('|"(\w+)":|', '$1:', Json::encode(
            $options,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        ));

        if (str_contains($options, '!!')) {
            $options = str_replace(['\"', '"!!', '!!"'], ['"', '', ''], $options);
        }

        return $options;
    }
}
