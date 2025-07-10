<?php

namespace App\Models;

use App\Enums\BenefitStatus;
use Carbon\Carbon;
use App\Helpers\MixCaseULID;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Benefit extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'employee_id',
        'type',
        'amount',
        'status',
        'message',
        'file',
    ];

    /**
     *  FIll ulid field when creating
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->code = MixCaseULID::generate();
        });
    }

    protected $casts = [
        'status' => BenefitStatus::class,
    ];

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function response(): HasOne
    {
        return $this->hasOne(Response::class, 'benefit_id');
    }

    #[Scope]
    protected function status(Builder $query, string $status): Builder
    {
        $statusEnum = BenefitStatus::tryFrom($status);

        return $query->when($statusEnum, function ($q, $enum) {
            $q->whereStatus($enum);
        });
    }

    #[Scope]
    protected function whereStatus(Builder $query, BenefitStatus $status): Builder
    {
        return $query->where('status', $status);
    }

    #[Scope]
    protected function whereEmployeeID(Builder $query, int $employeeID): Builder
    {
        return $query->where('employee_id', $employeeID);
    }

    #[Scope]
    protected function whereUserName(Builder $query, string $nama): Builder
    {
        return $query->whereHas('employee.user', function ($q) use ($nama) {
            $q->where('name', 'like', $nama);
        });
    }

    #[Scope]
    protected function whereType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    #[Scope]
    protected function whereBetweenDate(Builder $query, array $dates): Builder
    {
        return $query->whereBetween('created_at', [
            Carbon::createFromFormat('d-m-Y', $dates[0])->startOfDay(),
            Carbon::createFromFormat('d-m-Y', $dates[1])->endOfDay()
        ]);
    }
}
