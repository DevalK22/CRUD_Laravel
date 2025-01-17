<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasFactory,HasApiTokens;
    protected $table = 'employees';
    public $incrementing = false;
    protected $keyType = 'int';
    protected $fillable = [
        'email',
        'password',
        'name',
        'age',
        'gender',
        'salary',
        'designation',
        'department',
        'start_leave',
        'end_leave',
        'leave_type',
        'reason',
        'status',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            if (empty($employee->id)) {
                $employee->id = rand(1000, 9999);
            }
        });
    }
}
