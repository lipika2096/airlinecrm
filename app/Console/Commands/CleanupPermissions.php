<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class CleanupPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:cleanup {--force : Skip confirmation prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove edit, view, delete, create based permissions from database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('This will delete all permissions with view, create, edit, delete suffixes. Are you sure?')) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        $this->info('Starting permission cleanup...');

        // Get all permissions
        $permissions = Permission::all();

        // Patterns to remove
        $patterns = [
            '/\.view$/', '/\.create$/', '/\.edit$/', '/\.delete$/',
            '/-view$/', '/-create$/', '/-edit$/', '/-delete$/',
            '/\.allocate$/', '/\.generate$/', '/\.assign$/', '/\.add-comment$/', '/\.update-status$/'
        ];

        $count = 0;
        $deletedPermissions = [];

        foreach ($permissions as $permission) {
            $name = $permission->name;
            $shouldDelete = false;

            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $name)) {
                    $shouldDelete = true;
                    break;
                }
            }

            if ($shouldDelete) {
                $permission->delete();
                $count++;
                $deletedPermissions[] = $name;
                
                if ($this->option('verbose')) {
                    $this->line("Deleted: {$name}");
                }
            }
        }

        $this->info("Cleanup completed successfully!");
        $this->info("Total permissions deleted: {$count}");

        if (!$this->option('verbose') && $count > 0) {
            if ($this->confirm('Show list of deleted permissions?')) {
                $this->table(['Deleted Permissions'], array_map(fn($name) => [$name], $deletedPermissions));
            }
        }

        return 0;
    }
}
