<?php

namespace App\Http\Controllers;

use App\Enums\BenefitStatus;
use App\Models\Benefit;
use Illuminate\Http\Request;

class RequestBenefitController extends Controller
{
    public function create()
    {
        return view('dashboard.employee.request-benefit');
    }

    public function edit(Request $request, Benefit $benefit)
    {
        abort_unless(
            auth()->user()->id === $benefit->employee->user_id &&
                in_array($benefit->status, [BenefitStatus::TOLAK, BenefitStatus::MENUNGGU]),
            403
        );

        return view('dashboard.employee.edit-request-benefit', compact('benefit'));
    }
}
