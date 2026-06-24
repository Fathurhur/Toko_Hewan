<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'image_path',
        'name',
        'species',
        'gender',
        'weight',
        'estimated_age',
        'price',
        'description',
        'is_public', // Tambahan baru
    ];

    /**
     * Type casting untuk price (integer rupiah) dan weight
     */
    protected $casts = [
        'price' => 'integer',
        'weight' => 'decimal:2',
    ];

    /**
     * Relasi kembali ke model User (Setiap hewan dimiliki oleh satu user)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
