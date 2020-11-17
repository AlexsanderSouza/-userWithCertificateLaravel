<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phones extends Model
{
    use HasFactory;

    /**
     * Os atributos que não podem ser atribuídos
     *
     * @var array
     */
    protected $guarded = [];
}
