<?php

namespace App\Exports;

use App\Models\AuditLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AuditLogExport implements FromCollection, WithHeadings, WithMapping
{
    protected $logs;

    public function __construct($logs)
    {
        $this->logs = $logs;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->logs;
    }

    public function headings(): array
    {
        return [
            'Created At',
            'User',
            'Action',
            'Resource',
            'Status',
        ];
    }

    public function map($log): array
    {
        return [
            \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Kolkata')->format('d M Y, h:i A'),
            $log->user ? $log->user->name : 'System',
            $log->action,
            $log->resource,
            $log->status,
        ];
    }
}
