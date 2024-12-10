<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class registroController extends Controller
{
    
    public function index(){
        $registro = Registro::all();
            $data = [
                'registro' => $registro,
                'status' => 200
            ];
        return response()->json($data, 200);
    }


    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'humedad' => 'required',
            'temperatura' => 'required',
            'hora' => 'required',
            'fecha' => 'required'
                ]);

            if($validator->fails()){
                    $data = [
                        'message' => 'Error en la validacion de los datos',
                        'error' => $validator->errors(),
                        'status'=> 400
                     ];
                return response()->json($data, 400);
            }

        $registro = Registro::create([
            'humedad' => $request->humedad,
            'temperatura' => $request->temperatura,
            'hora' => $request->hora,
            'fecha' => $request->fecha
        ]);

            if(!$registro){
                $data = [
                    'message' => 'Error al crear al estudiante',
                    'status' => 500
                ];
                return response()->json($data, 500);
            }

        $data = [
            'registro' => $registro,
            'status' => 201
        ];
            return response()->json($data, 201);

    }

}
