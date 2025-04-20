<?php

namespace App\Models;

use App\Builders\FaqBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model {
    use HasFactory;

    //public $table = 'nissan_faq';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question', 'status', 'answer'
    ];

    public function newEloquentBuilder($query): FaqBuilder {
        return new FaqBuilder($query);
    }
}
