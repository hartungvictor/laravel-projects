<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
   
    public function __construct(Modelo $modelo) {
        $this->modelo = $modelo;
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->modelo->with('marca')->get(), 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->modelo->rules());
        $image = $request->file('imagem');
        $image_urn = $image->store('imagens/modelos', 'public');

        $modelo = $this->modelo->create([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $image_urn,
            'numero_portas' => $reuest->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);

        return response()->json($modelo, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $modelo = $this->modelo->with('marca')->find($id);
        
        if($modelo === null){
            
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
       
        }
        
        return response()->json($modelo, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modelo $modelo)
    {
       
        
        if($modelo === null){
            
            return reponse()->json(['erro' => 'Impossível realizar atualização'], 404);
       
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

           // $teste = '';
            
            foreach($modelo->rules() as $input => $regra) {
                
               // $teste .= 'Input'.$input. '| Regra:'.$regra.'<br>';
                
                if(array_key_exists($input, $request->all())) {
                    
                    $regrasDinamicas[$input] = $regra;
                
                }
                
            }
            
            $request->validate($regrasDinamicas);

        }else {
           
            $request->validate($modelo->rules);
       
        }

        $image = $request->file('imagem');
        $image_urn = $image->store('imagens', 'public');

        $modelo->update([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $image_urn,
            'numero_portas' => $reuest->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);
        
        return response()->json($modelo, 200);    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modelo $modelo)
    {
        $modelo = $this->modelo->find($id);
        
        if($modelo === null){
            
            return response()->json(['erro' => 'Impossível realizar o delete'], 404);
        
        }

        Storage::disk('public')->delete($modelo->imagem);

        $modelo->delete();
        return response()->json(['msg' => 'Deletado'], 200);
    }
}
