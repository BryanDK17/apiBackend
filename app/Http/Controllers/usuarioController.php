<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class usuarioController extends Controller
{
    public function index(){

        $usuario = Usuario::all();    
            $data = [
                'usuario' => $usuario,
                'status' => 200
            ];
                return response()->json($data, 200);
    }


    public function show($id){
        
        $usuario = Usuario::find($id);

        if(!$usuario){
            $data =[
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'usuario' => $usuario,
            'status' => 200
        ];
        return response()->json($data, 200);
    }


    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'nombre' => 'required',
            'apellido' => 'required',
            'edad' => 'required',
            'email' => 'required|email|unique:usuario',
            'password' => 'required'
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'error' => $validator->errors(),
                'status'=> 400
            ];
                return response()->json($data, 400);
        }

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'edad' => $request->edad,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        if(!$usuario){
            $data = [
                'message' => 'Error al crear al usuario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'usuario' => $usuario,
            'status' => 201
        ];
            return response()->json($data, 201);
    }


    public function destroy($id){

        $usuario = Usuario::find($id);

        if(!$usuario){

            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $usuario->delete();
        $data = [
            'message' => 'Usuario eliminado',
            'status' => '200'
        ];
        return response()->json($data, 200);
    }


    public function update(Request $request, $id){

        $usuario = Usuario::find($id);

        if(!$usuario){
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'edad' => 'required',
            'email' => 'required|email|unique:usuario',
            'password' => 'required'
        ]);
        
        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->edad = $request->edad;
        $usuario->email = $request->email;
        $usuario->password = $request->password;

        $usuario->save();

        $data = [
            'message' => 'Usuario actualizado',
            'usuario' => $usuario,
            'status' => 200
        ];
            return response()->json($data, 200);
    }


    public function updatePartial(Request $request, $id)
    {
        $usuario = Usuario::find($id);
    
        if (!$usuario) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }
    
        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required',
            'apellido' => 'sometimes|required',
            'edad' => 'sometimes|required|integer',
            'email' => 'sometimes|required|email|unique:usuario,email,' . $id,
            'password' => 'sometimes|required|max:20',
        ]);
    
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400,
            ];
            return response()->json($data, 400);
        }
    
        if ($request->has('nombre')) {
            $usuario->nombre = $request->nombre;
        }
    
        if ($request->has('apellido')) {
            $usuario->apellido = $request->apellido;
        }
    
        if ($request->has('edad')) {
            $usuario->edad = $request->edad;
        }
    
        if ($request->has('email')) {
            $usuario->email = $request->email;
        }
    
        if ($request->has('password')) {
            $usuario->password = bcrypt($request->password);
        }
    
        $usuario->save();
    
        $data = [
            'message' => 'Usuario actualizado',
            'usuario' => $usuario,
            'status' => 200,
        ];
    
        return response()->json($data, 200);
    }
    

    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }
    
        // Buscar al usuario por su email
        $usuario = Usuario::where('email', $request->email)->first();
    
        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado',
                'status' => 404
            ], 404);
        }
    
        // Verificar si la contraseña es correcta
        if (!Hash::check($request->password, $usuario->password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas',
                'status' => 401
            ], 401);
        }
        
    
        // Si las credenciales son válidas, devolver éxito
        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'usuario' => $usuario,
            'status' => 200
        ], 200);
    }
    



public function obtenerIdUsuario() {
    $usuario = Auth::user(); // Obtén el usuario autenticado

    if (!$usuario) {
        return response()->json([
            'message' => 'Usuario no autenticado',
            'status' => 401
        ], 401);
    }

    return response()->json([
        'id' => $usuario->id,
        'status' => 200
    ]);
}



}
