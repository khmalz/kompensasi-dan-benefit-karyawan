<?php

namespace App\Http\Controllers;

use App\Enums\BenefitStatus;
use Carbon\Carbon;
use App\Models\Benefit;
use Illuminate\Http\Request;

class HistoryBenefitController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $status = $request->status ?? BenefitStatus::MENUNGGU->value;
        $employeeUserID  = (int) $request->user()->employee->id;

        $benefits = Benefit::with("employee.user:id,name")
            ->whereEmployeeID($employeeUserID)
            ->status($status)
            ->when($request->has('tanggal') && !empty($request->tanggal), function ($query) use ($request) {
                $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
                return $query->whereDate('created_at', $tanggal);
            })
            ->when($request->has('jenis') && !empty($request->jenis), function ($query) use ($request) {
                return $query->whereType($request->jenis);
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.employee.history-benefit', compact('benefits'));
    }
}
