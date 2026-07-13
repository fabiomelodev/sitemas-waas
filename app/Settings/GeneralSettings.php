<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $whatsapp;

    public string $instagram;

    public string $facebook;

    public string $cnpj;

    public static function group(): string
    {
        return 'general';
    }
}