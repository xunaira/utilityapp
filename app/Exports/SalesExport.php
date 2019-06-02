<?php

namespace App\Exports;

use App\agents_migration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadings;


class SalesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
       
    }
    public function collection()
    {
    	
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'Agent Name',
            'Product Name',
            'Wallet',
            'Sale Value',
            'Remaining Balance',
            'Date'

        ];
    }
}
