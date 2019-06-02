<?php

namespace App\Exports;

use App\agents_migration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadings;


class WalletExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $wallet;

    public function __construct($wallet)
    {
        $this->wallet = $wallet;
       
    }
    public function collection()
    {
    	
        return $this->wallet;
    }

    public function headings(): array
    {
        return [
            'Agent Name',
            'Cash in Hand',
            'Cash in Bank',
            'Total Funds',
            'Date'

        ];
    }
}
