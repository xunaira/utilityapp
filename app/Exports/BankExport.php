<?php

namespace App\Exports;

use App\agents_migration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BankExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $balance;

    public function __construct($balance)
    {
        $this->balance = $balance;
    }

    public function collection()
    {
    	
       return $this->balance;
    }

    public function headings(): array
    {
        return [
            'Cash in Bank',
            'Cash in Hand',
            'Total Funds',
            'Closing Balance',
            'Date'
        ];
    }
}
