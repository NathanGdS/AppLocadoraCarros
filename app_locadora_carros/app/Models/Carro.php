<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;

    protected $fillable = ['modelo_id', 'placa', 'disponivel', 'km'];

    public function rules() {
        return [
            'modelo_id' => 'exists:modelos,id',
            'placa' => 'required|unique:carros,placa,'.$this->id.'|min:6|max:8',
            'disponivel' =>'required|boolean',
            'km' => 'required|integer|digits_between:1,9',
        ];
    }

    public function modelo(){
        return $this->belongsTo('App\Models\Modelo');
    }
}
