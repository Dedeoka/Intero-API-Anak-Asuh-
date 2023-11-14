<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnakAsuh extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function kesehatanAnaks()
    {
        return $this->hasMany(KesehatanAnakAsuh::class);
    }

    public function pendidikanAnaks()
    {
        return $this->hasMany(PendidikanAnakAsuh::class);
    }

    public function prestasiAnaks()
    {
        return $this->hasMany(PrestasiAnakAsuh::class);
    }
}
