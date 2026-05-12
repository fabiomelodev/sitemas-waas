<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('general.whatsapp', 'https://wa.me/5511998043538');
        $this->migrator->add('general.instagram', 'https://instagram.com/singletemas');
        $this->migrator->add('general.facebook', 'https://facebook.com/singletemas');
    }
};
