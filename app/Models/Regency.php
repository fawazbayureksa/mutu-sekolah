<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Regency extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'province_code',
        'name',
    ];

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    public function scopeByProvinceCode($query, $provinceCode)
    {
        return $query->where('province_code', $provinceCode);
    }
}
