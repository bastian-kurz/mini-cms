<?php

declare(strict_types=1);

namespace App;

enum Defaults: string
{
    case timeZone = 'Europe/Berlin';
    case storageDateTimeFormat = "Y-m-d H:i:s";
}
