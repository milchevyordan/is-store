<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('generate-ts:enums', function () {
    collect(File::allFiles(base_path('app/enums')))
        ->filter(function (SplFileInfo $file) {
            return 'php' == $file->getExtension();
        })->map(function (SplFileInfo $file) {
            $class = 'App\\Enums\\' . $file->getBasename('.php');
            $name = class_basename($class);
            $ts = $class::toTS();
            $filePath = "js/Enums/{$name}.ts";
            ! File::put(resource_path($filePath), $ts) ? $this->line("<error>[ERROR]</error> Could not generate {$filePath}") : $this->line("<info>[OK]</info> {$filePath}");
        });
})->purpose('Generate TypeScript Enums.');
