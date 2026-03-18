<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Maatwebsite\Excel\Concerns\FromCollection;

class AuditLogController extends Controller
{
    //
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = AuditLog::query();

        if ($this->request->start_date && $this->request->end_date) {
            $query->whereBetween('created_at', [
                $this->request->start_date,
                $this->request->end_date
            ]);
        }

        return $query->select(
            'created_at',
            'action',
            'resource',
            'status',
            'ip_address'
        )->get();
    }
}
