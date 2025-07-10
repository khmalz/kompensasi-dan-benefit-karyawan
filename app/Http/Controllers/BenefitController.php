<?php

namespace App\Http\Controllers;

use App\Actions\Benefit\UpdateBenefit;
use Carbon\Carbon;
use App\Models\Benefit;
use App\DTO\BenefitData;
use Illuminate\Http\Request;
use App\Http\Requests\BenefitRequest;
use App\Actions\Benefit\CreateBenefit;
use App\Actions\Benefit\DeleteBenefit;
use App\Enums\BenefitStatus;
use Illuminate\Validation\ValidationException;

class BenefitController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ?? BenefitStatus::MENUNGGU->value;

        $benefits = Benefit::with("employee.user:id,name")
            ->whereNot('status', BenefitStatus::SELESAI)
            ->when($request->has('nama') && !empty($request->nama), function ($query) use ($request) {
                return $query->whereUserName($request->nama);
            })
            ->when($request->has('tanggal') && !empty($request->tanggal), function ($query) use ($request) {
                $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
                return $query->whereDate('created_at', $tanggal);
            })
            ->when($request->has('jenis') && !empty($request->jenis), function ($query) use ($request) {
                return $query->whereType($request->jenis);
            })
            ->latest()
            ->paginate(10);

        return view("dashboard.benefit.list", compact('benefits'));
    }

    public function done(Request $request)
    {
        $benefits = Benefit::with("employee.user:id,name")
            ->whereStatus(BenefitStatus::SELESAI)
            ->when($request->has('nama') && !empty($request->nama), function ($query) use ($request) {
                return $query->whereUserName($request->nama);
            })
            ->when($request->has('tanggal') && !empty($request->tanggal), function ($query) use ($request) {
                $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
                return $query->whereDate('created_at', $tanggal);
            })
            ->when($request->has('jenis') && !empty($request->jenis), function ($query) use ($request) {
                return $query->whereType($request->jenis);
            })
            ->latest()
            ->paginate(10);

        return view("dashboard.benefit.done", compact('benefits'));
    }

    public function store(BenefitRequest $request, CreateBenefit $action)
    {
        $data = $request->validated();
        $benefitData = BenefitData::fromArray($data);

        try {
            $action->handle($benefitData);

            return to_route('request')->with('success', 'Berhasil mengirim permintaan tunjangan');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(Benefit $benefit)
    {
        $benefit->load(['employee.user', 'response']);
        $isBenefitExceededLimit = $benefit->amount > $benefit->employee->{$benefit->type};

        return view('dashboard.benefit.detail', compact('benefit', 'isBenefitExceededLimit'));
    }

    public function update(BenefitRequest $request, Benefit $benefit, UpdateBenefit $action)
    {
        $data = $request->validated();
        $benefitData = BenefitData::fromArray($data);

        try {
            $action->handle($benefit, $benefitData);

            return to_route('request')->with('success', 'Berhasil mengedit permintaan tunjangan');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy(Benefit $benefit, DeleteBenefit $action)
    {
        $action->handle($benefit);

        return to_route("request")->with("success", "Berhasil menghapus permintaan tunjangan");
    }
}
