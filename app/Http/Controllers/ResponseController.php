<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\DTO\ResponseData;
use App\Http\Requests\ResponseRequest;
use App\Actions\Response\CreateResponse;
use Illuminate\Validation\ValidationException;

class ResponseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function __invoke(ResponseRequest $request, Benefit $benefit, CreateResponse $action)
    {
        $responseData = ResponseData::fromArray($request->validated());

        try {
            $action->handle($benefit, $responseData);

            if ($responseData->status == 'tolak') {
                return to_route('benefit.index')->with('reject', 'Penolakan Permintaan Berhasil');
            }

            return to_route('benefit.index')->with('success', 'Berhasil Mengirim Tanggapan');
        } catch (ValidationException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
