<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $this->clearCache();
        $this->migrateAndSeed();

        return $app;
    }

    /**
     * Clears Laravel Cache.
     *
     * @return void
     */
    private function clearCache()
    {
        $commands = ['clear-compiled', 'cache:clear', 'view:clear', 'config:clear', 'route:clear'];
        foreach ($commands as $command) {
            Artisan::call($command);
        }
    }

    /**
     * Process all migrations and seeding.
     *
     * @return void
     */
    private function migrateAndSeed()
    {
        Artisan::call('migrate:fresh --seed');
    }
}
