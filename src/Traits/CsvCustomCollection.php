<?php

namespace Wilgucki\Csv\Traits;

use Wilgucki\Csv\CsvCollection;

trait CsvCustomCollection
{
    public function newCollection(array $models = []): CsvCollection
    {
        return new CsvCollection($models);
    }
}
