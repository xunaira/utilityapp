<?php

namespace App\Exports;

use App\agents_migration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AgentDetailExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function collection()
    {
    	
       return $this->details;
    }

    public function headings(): array
    {
        return [
            'Agent Name',
            'Agent Email',
            'Agent Address Line 1',
            'Agent Address Line 2',
            'Agent City',
            'Agent State',
            'Agent Country',
            'Agent Phone Number',
            'Agent Operational Area',
            'Agent Salary',
            'Agent Supervisor'
        ];
    }
}
