<?php

namespace Wilgucki\Csv;

use Illuminate\Support\ServiceProvider;
use Wilgucki\Csv\Commands\Export;
use Wilgucki\Csv\Commands\Import;
use Wilgucki\PhpCsv\Reader;
use Wilgucki\PhpCsv\Writer;

class CsvServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/csv.php' => config_path('csv.php'),
        ], 'config');
    }

    public function register(): void
    {
        app()->bind('csv-reader', function (): Reader {
            return new Reader(
                config('csv.delimiter'),
                config('csv.enclosure'),
                config('csv.escape'),
                config('csv.encoding.reader.enabled') ? config('csv.encoding.reader.from', null) : null,
                config('csv.encoding.reader.enabled') ? config('csv.encoding.reader.to', null) : null
            );
        });

        app()->bind('csv-writer', function (): Writer {
            return new Writer(
                config('csv.delimiter'),
                config('csv.enclosure'),
                config('csv.escape'),
                config('csv.encoding.writer.enabled') ? config('csv.encoding.writer.from', null) : null,
                config('csv.encoding.writer.enabled') ? config('csv.encoding.writer.to', null) : null
            );
        });

        $this->commands([
            Import::class,
            Export::class,
        ]);
    }
}
