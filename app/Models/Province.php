<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    protected $primaryKey = 'code';

    public function regencies(): HasMany
    {
        return $this->hasMany(Regency::class, 'province_code', 'code');
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', 'like', '%'.$name.'%');
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }
}
