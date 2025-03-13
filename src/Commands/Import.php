<?php

namespace Wilgucki\Csv\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Wilgucki\Csv\Traits\CsvImportable;

class Import extends Command
{
    protected $name = 'csv:import';

    protected $description = 'Import CSV file into database table';

    public function handle(): int
    {
        $modelClass = $this->argument('model');
        $csvPath = $this->argument('csv-file');

        $traits = class_uses($modelClass);
        if (! isset($traits[CsvImportable::class])) {
            $this->error('Your model class does not use CsvImportable trait.');

            return 1;
        }

        if (! file_exists(base_path($csvPath))) {
            $this->error('Cannot find csv file.');

            return 1;
        }

        $modelClass::fromCsv($csvPath);

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
