<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;

class BackupController extends Controller
{

    public static function getMaxAttempts(): int
    {
        return 3;
    }

    // Run a backup (both DB and files)
    public function run()
    {
        $pathToZip = null;
        Event::listen(\Spatie\Backup\Events\BackupZipWasCreated::class, function ($event) use (&$pathToZip) {
            $pathToZip = $event->pathToZip;
        });

        $exception = null;
        Event::listen(\Spatie\Backup\Events\BackupHasFailed::class, function ($event) use (&$exception) {
            $exception = $event->exception->getMessage();
        });


        // $key = 'backup-run';

        // if (RateLimiter::tooManyAttempts($key, $this->maxAttempts)) {
        //     $availableIn = RateLimiter::availableIn($key); // Time remaining until reset
        //     $readableTime = gmdate('H:i:s', $availableIn); // Convert to readable time format

        //     return response()->json([
        //         'output' => "Daily limit reached ({$this->maxAttempts}) Try again in {$readableTime}.",
        //     ], 429);
        // }

        try {

            $fileName = env('DB_CONNECTION') . '-' . env('DB_DATABASE') . '.sql';
            $path = storage_path("app/backups/db-dumps/{$fileName}");
            File::ensureDirectoryExists(dirname($path));

            $shell_exec = shell_exec('mysqldump -u root --host=127.0.0.1 bidflow 2>&1');
            file_put_contents($path, $shell_exec);

            Event::listen(\Spatie\Backup\Events\BackupManifestWasCreated::class, function ($event) use (&$path) {
                $event->manifest->addFiles([$path]);
            });

            Artisan::call('backup:run', [
                '--only-files' => true,
                '-vvv' => true,
            ]);

            $trimmed = explode("\r\n", Artisan::output());
            if ($exception) {
                return response()->json([
                    'output' => $exception
                ], 500);
            } elseif ($pathToZip) {
                // $rem = "Backup remaining attempts: " . RateLimiter::remaining($key, $this->maxAttempts);
                // array_unshift($trimmed, $rem);
                $output = implode("\r\n", $trimmed);
                //RateLimiter::hit($key, now()->diffInSeconds(now()->endOfDay()));
            }

            return response()->json([
                'output' => $output ?? "No files and database secured to backup.\r\nBackup unsuccessful!",
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e,
            ], $e->getCode() ?: 500);
        }
    }

    public function clean()
    {

        $backupDestination = null;
        Event::listen(\Spatie\Backup\Events\CleanupWasSuccessful::class, function ($event) use (&$backupDestination) {
            $backupDestination = $event->backupDestination;
        });

        $exception = null;
        Event::listen(\Spatie\Backup\Events\CleanupHasFailed::class, function ($event) use (&$exception) {
            $exception = $event->exception->getMessage();
        });

        RateLimiter::clear('backup-run');

        try {
            Artisan::call('backup:clean', [
                '-vvv' => true,
            ]);

            $output = trim(Artisan::output());

            if ($exception)
                return response()->json([
                    'output' => $exception
                ], 500);

            return response()->json([
                'output' => $output
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'output' => $e->getMessage()
            ], $e->getCode());
        }
    }

    // List available backup files
    public function list()
    {
        $files = Storage::disk('backups')->allFiles(env('APP_NAME'));
        $backup = collect($files)
            ->filter(fn($file) => str_ends_with($file, '.zip'))
            ->map(fn($file) => [
                'name' => basename($file),
                'size' => $this->formatSize(Storage::disk('backups')->size($file)),
                'created_at' => Carbon::createFromTimestamp(
                    Storage::disk('backups')->lastModified($file)
                )->format('m-d-Y h:i A'),
                'url' => route('backup.download', ['file' => basename($file)]),
            ])
            ->sortByDesc('created_at')
            ->values();

        $backupDestinationStatus = null;
        Event::listen(\Spatie\Backup\Events\HealthyBackupWasFound::class, function ($event) use (&$backupDestinationStatus) {
            $backupDestinationStatus = $event->backupDestinationStatus;
        });

        Event::listen(\Spatie\Backup\Events\UnhealthyBackupWasFound::class, function ($event) use (&$backupDestinationStatus) {
            $backupDestinationStatus = $event->backupDestinationStatus;
        });

        Artisan::call('backup:monitor', [
            '-vvv' => true,
        ]);

        $output = trim(Artisan::output());

        return Inertia::render('settings/Backup', [
            'backup' => Inertia::defer(fn() => $backup),
            'output' => Inertia::defer(fn() => $output),
        ]);
    }

    // Download a backup file
    public function download($file): StreamedResponse
    {
        $path = env('APP_NAME', 'laravel-backup') . "/{$file}";
        if (!Storage::disk('backups')->exists($path)) {
            abort(404, 'Backup file not found.');
        }
        return Storage::disk('backups')->download($path, basename($path));
    }

    private function formatSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' bytes';
    }
}
