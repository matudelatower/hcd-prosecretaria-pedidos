<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearSessions extends Command
{
    protected $signature = 'sessions:clear';
    protected $description = 'Clear all user sessions';

    public function handle()
    {
        // Limpiar tabla de sesiones
        DB::table('sessions')->truncate();
        
        $this->info('All sessions have been cleared.');
        
        return Command::SUCCESS;
    }
}
