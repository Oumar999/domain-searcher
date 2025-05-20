<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['domains', 'subtotal', 'vat', 'total'];

    protected $casts = [
        'domains' => 'array', // Dit zorgt ervoor dat de JSON automatisch wordt omgezet naar een array
    ];
}