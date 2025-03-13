<?php

namespace Wilgucki\Csv\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Wilgucki\Csv\Traits\CsvCustomCollection;

class Export extends Command
{
    protected $name = 'csv:export';

    protected $description = 'Export database table into CSV file';

    public function handle(): int
    {
        $modelClass = $this->argument('model');
        $csvPath = $this->argument('csv-file');

        $traits = class_uses($modelClass);
        if (! isset($traits[CsvCustomCollection::class])) {
            $this->error('Your model class does not use CsvCustomCollection trait.');

            return 1;
        }

        file_put_contents(base_path($csvPath), $modelClass::all()->toCsv());

        $this->info('Done!');

        return 0;
    }

    protected function getArguments(): array
    {
        return [
            ['model', InputArgument::REQUIRED, 'Model\'s class name with its namespace'],
            ['csv-file', InputArgument::REQUIRED, 'File name with path relative to project\'s root directory'],
        ];
    }
}
