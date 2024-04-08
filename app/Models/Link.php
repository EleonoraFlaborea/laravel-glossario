<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Link extends Model
{
    use HasFactory;

    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    public function getFormattedDate($column, $format = 'd/m/y h:i:s')
    {
        return Carbon::create($this->$column)->format($format);
    }
}
