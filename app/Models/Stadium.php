<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    use HasFactory;

    protected $table = 'stadiums';

    protected $fillable = ['id', 'user_id', 'name', 'description', 'status', 'file'];

    public function advertisingSections()
    {
        return $this->hasMany(AdvertisingSection::class);
    }

    public function getFilePathAttribute($value)
    {
        return asset('uploads') . '/' . $value;
    }
}
