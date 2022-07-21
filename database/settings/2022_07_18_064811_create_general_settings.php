<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.account', false);
        $this->migrator->add('general.status', false);
        $this->migrator->add('general.paused', false);
    }

    public function down(){
        $this->migrator->delete('general.account');
        $this->migrator->delete('general.status');
        $this->migrator->delete('general.paused');

    }
}
