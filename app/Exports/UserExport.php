<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::with('role', 'department')->latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Role',
            'Department',
            'Status',
            'Last Login',
            'Joined Date'
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->role->display_name ?? '-',
            $user->department->name ?? 'All',
            $user->is_active ? 'Active' : 'Inactive',
            $user->last_login_at ? $user->last_login_at->timezone('Asia/Kolkata')->format('d M Y, h:i A') : 'Never',
            $user->created_at->timezone('Asia/Kolkata')->format('d M Y, h:i A'),
        ];
    }
}
