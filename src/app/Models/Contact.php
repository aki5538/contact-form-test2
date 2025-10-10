<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'message'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getFullNameAttribute()
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    public function getGenderLabelAttribute()
    {
        $labels = ['0' => '男性', '1' => '女性', '2' => 'その他'];
        return $labels[$this->gender] ?? '未設定';
    }

}
