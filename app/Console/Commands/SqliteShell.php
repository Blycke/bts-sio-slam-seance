<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SqliteShell extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:sqlite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open an interactive sqlite3 shell on the project database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = database_path('database.sqlite');

        if (!file_exists($path)) {
            $this->error("Database file not found at $path");
            return 1;
        }

        // Use passthru so the user can type interactively in the sqlite prompt.
        passthru('sqlite3 ' . escapeshellarg($path));

        return 0;
    }
}
