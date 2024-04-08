<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'color'];

    public function words()
    {
        return $this->belongsToMany(Word::class);
    }

    public function getFormattedDate($column, $format = 'd/m/y h:i:s')
    {
        return Carbon::create($this->$column)->format($format);
    }
}
