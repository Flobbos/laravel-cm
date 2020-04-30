<?php

namespace Flobbos\LaravelCM\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;  
HeadingRowFormatter::default('none');

class SubscriberImport implements WithHeadingRow {    
    
    use Importable;
    
}