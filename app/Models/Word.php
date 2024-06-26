<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use Carbon\Carbon;

class Word extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = ['word_name', 'description'];

    public function getFormattedDate($column, $format = 'd/m/y h:i:s')
    {
        return Carbon::create($this->$column)->format($format);
    }

    public function getAbstract()
    {
        return substr($this->description, 0, 450);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function tags() 
    {
        return $this->belongsToMany(Tag::class);
    }
}
