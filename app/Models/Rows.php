<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Rows extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'date_row',
    ];
}
