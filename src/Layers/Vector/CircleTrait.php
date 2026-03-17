<?php

namespace BeastBytes\Yii\Leaflet\Layers\Vector;

use JsonException;

trait CircleTrait
{
    /**
     * @param string $leafletVar
     * @return string
     * @throws JsonException
     * @internal
     */
    public function toJs(string $leafletVar): string
    {
        $name = lcfirst(substr(static::class, strrpos(static::class, '\\') + 1));
        $location = $this->location->toJs($leafletVar);
        $options = $this->options2Js($leafletVar);

        return "$leafletVar.$name($location" . (!empty($options) ? ",$options" : '') . ')'
            . $this->bind($leafletVar);
    }
}