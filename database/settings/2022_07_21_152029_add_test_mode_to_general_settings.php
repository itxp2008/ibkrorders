<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddTestModeToGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.test', true);
    }

    public function down(){
        $this->migrator->delete('general.test');
    }
}
