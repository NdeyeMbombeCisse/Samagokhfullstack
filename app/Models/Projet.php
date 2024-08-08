<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function user(){
        return $this->belongsto(User::class);
    }

    public function votes(){
        return $this->hasmany(Vote::class);
    }

    public function commentaires(){
        return $this->hasmany(Commentaire::class);
    }
}
