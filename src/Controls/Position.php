<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Leaflet\Controls;

enum Position: string
{
    case bottomLeft = 'bottomleft';
    case bottomRight = 'bottomright';
    case topLeft = 'topleft';
    case topRight = 'topright';
}