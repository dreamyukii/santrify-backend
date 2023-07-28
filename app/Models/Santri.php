<?php

namespace App\Models;
use App\Models\Kamar;
use App\Models\Divisi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'gender',
        'status',
        'room',
        'bill',
        'kelas',
        'image'
    ];

    protected $with = [ 'kamar','divisi'];
    
    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'room','id');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'kelas','id');
    }

}





