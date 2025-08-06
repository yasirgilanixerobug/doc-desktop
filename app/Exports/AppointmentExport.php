<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AppointmentExport implements FromCollection, WithHeadings
{
    protected $report;

    public function __construct($appointment)
    {
        $this->report = $appointment;
    }

    /**
    * @return Collection
    */
    public function collection()
    {
        foreach ($this->report as $key => $report)
        {
            $appointmentReport[] = [
                $report->id,
                date('M d Y', strtotime($report->date)),
                $report->start_time,
                $report->userable->name ?? 'N\A',
                $report->userable->phone ?? 'N\A',
                $report->userable->email ?? 'N\A',
                $report->provider->name ?? 'Provider Deleted',
                $report->location->name ?? 'Location Deleted',
                $report->status->name ?? 'N\A',
            ];
        }

        return collect($appointmentReport);
    }

    public function headings(): array
    {
        return [
            '#',
            'Appointment Date',
            'Time',
            'Patient Name',
            'Phone',
            'Email',
            'Provider Name',
            'Location',
            'Appointment Status',
        ];
    }
}
