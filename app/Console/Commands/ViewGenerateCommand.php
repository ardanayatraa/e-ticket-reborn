<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ViewGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Blade view stubs with x-app-layout wrapper';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Define folders for Blade views
        $folders = [
            'admins',
            'paket_wisatas',
            'pelanggans',
            'sopirs',
            'pemesanan',
            'ketersediaans',
            'include_models',
            'excludes',
            'transaksi',
            'detailtransaksis',
        ];

        foreach ($folders as $folder) {
            $viewPath = resource_path("views/{$folder}");
            // Create directory if not exists
            if (!File::exists($viewPath)) {
                File::makeDirectory($viewPath, 0755, true);
                $this->info("Created directory: {$viewPath}");
            }

            // Generate index, create, edit, show
            foreach (['index', 'create', 'edit', 'show'] as $view) {
                $file = "{$viewPath}/{$view}.blade.php";
                if (!File::exists($file)) {
                    $stub = <<<HTML
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- TODO: Header for {$folder}.{$view} -->
        </h2>
    </x-slot>

    <div class="py-8">
        <!-- TODO: Content for {$folder}.{$view} -->
    </div>
</x-app-layout>
HTML;
                    File::put($file, $stub);
                    $this->info("Created view stub: {$file}");
                }
            }
        }

        $this->info('Blade view stubs generated.');
        return 0;
    }
}
