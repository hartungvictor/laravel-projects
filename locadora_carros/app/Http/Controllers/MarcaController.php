<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

//-mcr para criar migrations, controller/resource tudo de uma vez

class MarcaController extends Controller
{
   
    public function __construct(Marca $marca) {
        $this->marca = $marca;
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas = $this->marca->all();
        return response()->json($marcas, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($this->marca->rules(), $this->marca->feedback());

        $marca = $this->marca->create($request->all());
        return response()->json($marca, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);
        
        if($marca === null){
            
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
       
        }
        
        return response()->json($marca, 200);
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
        $marca = $this->marca->find($id);
        
        if($marca === null){
            
            return reponse()->json(['erro' => 'Impossível realizar atualização'], 404);
       
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

           // $teste = '';
            
            foreach($marca->rules() as $input => $regra) {
                
               // $teste .= 'Input'.$input. '| Regra:'.$regra.'<br>';
                
                if(array_key_exists($input, $request->all())) {
                    
                    $regrasDinamicas[$input] = $regra;
                
                }
                
            }
            
            $request->validate($regrasDinamicas, $marca->feedback());

        }else {
           
            $request->validate($marca->rules, $marca->feedback());
       
        }

        
        $marca->update($request->all());
        response()->json($marca, 200);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = $this->marca->fid($id);
        
        if($marca === null){
            
            return response()->json(['erro' => 'Impossível realizar o delete'], 404);
        
        }

        $marca->delete();
        return response()->json(['msg' => 'Deletado'], 200);
    }
}