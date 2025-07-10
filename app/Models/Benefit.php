<?php

namespace App\Models;

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

    const MENUNGGU = 'pending';
    const PROSES = 'progress';
    const SELESAI = 'done';
    const TOLAK = 'reject';

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
    public function status(Builder $query, string $status): Builder
    {
        $statuses = [
            'menunggu' => self::MENUNGGU,
            'proses' => self::PROSES,
            'selesai' => self::SELESAI,
            'ditolak' => self::TOLAK,
        ];

        if (array_key_exists($status, $statuses)) {
            return $query->where('status', $statuses[$status]);
        }

        return $query;
    }

    #[Scope]
    public function whereStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    #[Scope]
    public function whereEmployeeID(Builder $query, int $employeeID): Builder
    {
        return $query->where('employee_id', $employeeID);
    }

    #[Scope]
    public function whereUserName(Builder $query, string $nama): Builder
    {
        return $query->whereHas('employee.user', function ($q) use ($nama) {
            $q->where('name', 'like', $nama);
        });
    }

    #[Scope]
    public function whereType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    #[Scope]
    public function whereBetweenDate(Builder $query, array $dates): Builder
    {
        return $query->whereBetween('created_at', [
            Carbon::createFromFormat('d-m-Y', $dates[0])->startOfDay(),
            Carbon::createFromFormat('d-m-Y', $dates[1])->endOfDay()
        ]);
    }
}
