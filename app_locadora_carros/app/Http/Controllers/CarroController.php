<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarroController extends Controller
{

    public function __construct(Carro $carro)
    {
        $this->carro = $carro;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$carros = Carro::all();
        $carros = $this->carro->with('modelo')->get();
        return $carros;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$carro = Carro::create($request->all());

        $request->validate($this->carro->rules());

        $carro = $this->carro->create([
            'modelo_id' => $request->modelo_id,
            'placa' => $request->placa,
            'disponivel' => $request->disponivel,
            'km' => $request->km,
        ]);
        return $carro;
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carro = $this->carro->with('modelo')->find($id);

        if($carro === null) return response()->json(['erro' => 'Recurso pesquisado nao existe'], 404);

        return $carro;
    }

    /**
     * Display the specified resource.
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function findByPlaca($placa)
    {
        $carro = $this->carro->where('placa', 'like', '%'.$placa.'%')->get();
        return $carro;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carro = $this->carro->find($id);

        if($carro === null) return response()->json(['erro' => 'Recurso pesquisado nao existe'], 404);


        if($request->method() === 'PATCH'){

            $regrasDinamicas = array();
            foreach($carro->rules() as $input => $regra){
                if(array_key_exists($input,$request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas);

        }else{
            $request->validate($carro->rules());
        }

        $carro->update([
            'modelo_id' => $request->modelo_id,
            'placa' => $request->placa,
            'disponivel' => $request->disponivel,
            'km' => $request->km,
        ]);
        return $carro;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carro = $this->carro->find($id);

        if($carro === null) return response()->json(['erro' => 'Recurso pesquisado nao existe'], 404);

        $carro->delete();
        return ['msg' => 'O carro foi removido com sucesso!'];
    }
}
