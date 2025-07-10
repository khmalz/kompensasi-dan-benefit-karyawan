<?php

namespace App\Actions\Employee;

use App\DTO\EmployeeData;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateEmployee
{
    public function handle(EmployeeData $dataEmployee)
    {
        DB::transaction(function () use ($dataEmployee) {
            $user = User::create($dataEmployee->toArray());
            $user->employee()->create($dataEmployee->toArray());
            $user->assignRole('employee');
        });
    }
}
