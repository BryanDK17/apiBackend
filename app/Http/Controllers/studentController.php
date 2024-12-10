<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{
    
    public function index(){

        $students = Student::all();    
            $data = [
                'students' => $students,
                'status' => 200
            ];
                return response()->json($data, 200);
    }


    public function show($id){
        
        $students = Student::find($id);

        if(!$students){
            $data =[
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'students' => $students,
            'status' => 200
        ];
        return response()->json($data, 200);
    }


    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French'
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'error' => $validator->errors(),
                'status'=> 400
            ];
                return response()->json($data, 400);
        }

        $students = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language
        ]);

        if(!$students){
            $data = [
                'message' => 'Error al crear al estudiante',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'students' => $students,
            'status' => 201
        ];
            return response()->json($data, 201);
    }


    public function destroy($id){

        $students = Student::find($id);

        if(!$students){

            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $students->delete();
        $data = [
            'message' => 'Estudiante eliminado',
            'status' => '200'
        ];
        return response()->json($data, 200);
    }


    public function update(Request $request, $id){

        $students = Student::find($id);

        if(!$students){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French'
        ]);
        
        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $students->name = $request->name;
        $students->email = $request->email;
        $students->phone = $request->phone;
        $students->language = $request->language;

        $students->save();

        $data = [
            'message' => 'Estudiante actualizado',
            'student' => $students,
            'status' => 200
        ];
            return response()->json($data, 200);
    }


    public function updatePartial(Request $request, $id){
        
        $students = Student::find($id);

        if(!$students){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email|unique:student',
            'phone' => 'digits:10',
            'language' => 'in:English,Spanish,French'
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if($request->has('name')){
            $students->name = $request->name;
        }

        if($request->has('email')){
            $students->email = $request->email;
        }

        if($request->has('phone')){
            $students->phone = $request->phone;
        }

        if($request->has('language')){
            $students->language = $request->language;
        }

        $students->save();

        $data = [
            'message' => 'Estudiante actualizado',
            'student' => $students,
            'status' => 200
        ];

        return response()->json($data, 200);

    }

}

