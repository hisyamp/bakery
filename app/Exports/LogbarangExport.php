<?php

namespace App\Exports;

use App\Models\Logitem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LogitemExport implements FromCollection,WithHeadings,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function styles(Worksheet $sheet)
    {
        return [
        // Style the first row as bold text.
        1    => ['font' => ['bold' => true]],
        ];
    }
    public function collection()
    {
        return Logitem::select(
        'so',
        'valuation_type',
        'tanggal',
        'lokasi_asal',
        'customer_name',
        'merk',
        'type',
        'sn',
        'is_continue',
        'dead_on_arrival',
        'dead_on_operational',
        'ber',
        'software_error',
        'tributary_error',
        'channel_error',
        'port_error',
        'tx_laser_faulty',
        'rx_laser_faulty',
        'physical_damage',
        'miscelaneous',
        'intermittent',
        'rectifier',
        'charging',
        'battery_faulty',
        'number_of_tribu',
        'number_of_channel',
        'number_of_port')->get();
    }
    public function headings(): array
    {
        return [
        'NO.IO/SP2K/SO',
        'Valuation Type',
        'Tanggal',
        'Lokasi Asal',
        'Customer Name',
        'Merk',
        'Type',
        'SN',
        'Is Continue',
        'Dead On Arrival',
        'Dead On Operational',
        'Ber',
        'Software Error',
        'Tributary Error',
        'Channel Error',
        'Port Error',
        'Tx Laser Faulty',
        'Rx Laser Faulty',
        'Physical Damage',
        'Miscelaneous',
        'Intermittent',
        'Rectifier',
        'Charging',
        'Battery Faulty',
        'Number Of Tribu',
        'Number Of Channel',
        'Number Of Port'
        ];
    }
    
}
