<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'phone',
        'address',
        'is_active',
        'gender'
    ];

    protected $appends = ['gender_label', 'is_active_class', 'is_active_label'];

    public function getGenderTextAttribute()
    {
        switch ($this->gender) {
            case '1':
                $label = "Man";
                break;

            default:
                $label = "Women";
                break;
        }

        return $label;
    }

    public function getIsActiveTextAttribute()
    {
        switch ($this->is_active) {
            case '1':
                $label = "Active";
                break;

            default:
                $label = "Inactive";
                break;
        }

        return $label;
    }



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
