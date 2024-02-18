<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    const EARNINGS = 1;	// INGRESOS
    const EXPENSES = 2;	// GASTOS
    const SYSTEM = 3;	// SISTEMA
    const LOSSES = 4;	// PERDIDA
    const PAYMENTS = 5;	// PAGOS
}
