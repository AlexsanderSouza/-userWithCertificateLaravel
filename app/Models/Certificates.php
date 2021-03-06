<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificates extends Model
{
    use HasFactory;

    /**
     * Os atributos que não podem ser atribuídos
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * informa que não existe atributos created_at e updated_at
     *
     * @var boolean
     */
    public $timestamps = false;
}
