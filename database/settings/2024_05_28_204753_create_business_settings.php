<?php

use Illuminate\Support\Facades\Storage;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('business.company_name', 'Rénovation et Construction VN Inc');
        $this->migrator->add('business.logo', Storage::disk('public')->putFile(public_path(config('seeding.logo_placeholder_path'))));
        $this->migrator->add('business.address', "15565 rue de l'écume");
        $this->migrator->add('business.city', 'Mirabel');
        $this->migrator->add('business.state', 'Québec');
        $this->migrator->add('business.postal_code', 'J7J 0E8');
        $this->migrator->add('business.country', 'Canada');
        $this->migrator->add('business.rbq', '5767-9086-01');
        $this->migrator->add('business.business_number', '1174378068');
        $this->migrator->add('business.gst_hst', '792293334RT0001');
        $this->migrator->add('business.pst', '1226389187TQ0001');
        $this->migrator->add('business.remarks', 'Travaux garantie 5 ans');
    }
};
