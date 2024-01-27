<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisingSection extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'user_id', 'stadium_id', 'name', 'description', 'file', 'file_type', 'status'];

    public function stadium()
    {
        return $this->belongsTo(Stadium::class, 'stadium_id');
    }

    public function getFilePathAttribute($value)
    {
        return asset('sections') . '/' . $value;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
