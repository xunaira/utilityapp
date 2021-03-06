<?php

namespace App\Exports;

use App\agents_migration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadings;


class AgentExport implements FromCollection, WithHeadings
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
            'Product Name',
            'Sale Value',
            'Total Funds',
            'Closing Balance',
            'Transaction Date'
        ];
    }
}
