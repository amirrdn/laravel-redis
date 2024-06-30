<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyRecord extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'male_count', 'female_count', 'male_avg_age', 'female_avg_age'];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($record) {
            $record->updateAverages();
        });
    }

    public function updateAverages()
    {
        $this->male_count = User::where('gender', 'male')->count();
        $this->female_count = User::where('gender', 'female')->count();

        if ($this->male_count > 0) {
            $this->male_avg_age = User::where('gender', 'male')->avg('age');
        } else {
            $this->male_avg_age = 0; // or any default value
        }

        if ($this->female_count > 0) {
            $this->female_avg_age = User::where('gender', 'female')->avg('age');
        } else {
            $this->female_avg_age = 0; // or any default value
        }

        $this->save();
    }
    
}
