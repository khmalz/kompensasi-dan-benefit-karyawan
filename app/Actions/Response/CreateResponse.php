<?php

namespace App\Actions\Response;

use App\Models\Benefit;
use App\Models\Response;
use App\DTO\ResponseData;
use App\Enums\BenefitStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreateResponse
{
    public function handle(Benefit $benefit, ResponseData $responseData)
    {
        DB::beginTransaction();

        try {
            Response::updateOrCreate(
                ['benefit_id' => $benefit->id],
                ['message' => $responseData->message]
            );

            $benefit->update([
                'status' => $responseData->status,
            ]);

            if ($responseData->status == BenefitStatus::SELESAI) {
                $benefitType = $benefit->type;
                $benefitAmount = $benefit->amount;
                $currentAmount = $benefit->employee()->value($benefitType);

                if ($benefitAmount > $currentAmount) {
                    throw ValidationException::withMessages([
                        'amount' => 'Jumlah tunjangan melebihi batas yang diizinkan.',
                    ]);
                }

                $benefit->employee()->update([
                    $benefitType => $currentAmount - $benefitAmount,
                ]);
            }

            DB::commit();
        } catch (ValidationException $e) {
            DB::rollBack();

            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Terjadi kesalahan saat membuat benefit.');
        }
    }
}
