<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class abonosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($mensaje = null)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['idUsuario'])) {
            header("Location:/login");
            exit();
        }
        try {
        $abonos = DB::table('abonos')->where('idUsuario',$_SESSION['idUsuario'])->get();
        header("Location:/abonos");
        return view('abonos', compact('abonos','mensaje'));
        }
        catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            $abonos = null;
            $mensaje = "Error al buscar registros [Error Code: ".$e->errorInfo[1]."]";
            //dd($e->errorInfo);
            return view('abonos', compact('abonos','mensaje'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['idUsuario'])) {
            header("Location:/login");
            exit();
        }

        #REGLAS DEL FORMULARIO
        $rules =
            [
                'nombreAbono' => 'required|string|min:1|max:50',
                'abonador' => 'required|string|min:1|max:50',
                'monto' => 'required|integer',
                'fechaAbono' => 'required|date|after_or_equal:today',
                'frecuencia'=>['required', Rule::in(['unico','mensual','semanal'])],
                'descripcion'=>'string|max:255'
            ];

        #MENSAJES PERSONALIZADOS 
        $customMessages =
            [
                'required' => 'El campo :attribute es requerido',
                'string' => 'El campo :attribute debe ser string',
                'integer' => 'El campo :attribute debe ser integer',
                'min' => 'El campo :attribute debe ser al menos :min',
                'max' => 'El campo :attribute debe ser como máximo :max',
                'after_or_equal' => 'La fecha :attribute debe ser desde :after_or_equal'
            ];

        #VALIDAMOS EL FORMULARIO ANTES DE INTENTAR HACER LA INSERCION
        $this->validate($request, $rules, $customMessages);

        #INTENTAMOS INSERTAR TOMANDO LOS DATOS DEL REQUEST
        try {
            DB::table('abonos')->insert([
                'idUsuario' => $_SESSION['idUsuario'],
                'nombreAbono' => $request->nombreAbono,
                'abonador' => $request->abonador,
                'monto' => $request->monto,
                'fechaAbono' => $request->fechaAbono,
                'descripcion' => $request->descripcion,
                'frecuencia' => $request->frecuencia
            ]);
            $mensaje = "Abono registrado con éxito";
            return $this->index($mensaje);
        }

        #ATRAPAMOS UN QUERY EXCEPTION EN CASO QUE OCURRA Y DEVOLVEMOS EL ERROR A LA VISTA
        catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                $mensaje = "Error al crear nuevo registro, entrada duplicada [Error Code: 1062]";
                return $this->index($mensaje);
            } else {
                $mensaje = "Ha ocurrido un error al insertar [Error Code: " . $e->errorInfo[1] . "]";
                //dd($e->errorInfo);
                return $this->index($mensaje);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['idUsuario'])) {
            header("Location:/login");
            exit();
        }

        #REGLAS DEL FORMULARIO
        $rules =
            [
                'nombreAbono' => 'required|string|min:1|max:50',
                'abonador' => 'required|string|min:1|max:50',
                'monto' => 'required|integer',
                'fechaAbono' => 'required|date|after_or_equal:today',
                'frecuencia'=>['required', Rule::in(['unico','mensual','semanal'])],
                'descripcion'=>'string|max:255'
            ];

        #MENSAJES PERSONALIZADOS 
        $customMessages =
            [
                'required' => 'El campo :attribute es requerido',
                'string' => 'El campo :attribute debe ser string',
                'integer' => 'El campo :attribute debe ser integer',
                'min' => 'El campo :attribute debe ser al menos :min',
                'max' => 'El campo :attribute debe ser como máximo :max',
                'after_or_equal' => 'La fecha :attribute debe ser desde :after_or_equal'
            ];

        #VALIDAMOS EL FORMULARIO ANTES DE INTENTAR HACER LA INSERCION
        $this->validate($request, $rules, $customMessages);

        try{
            DB::table('abonos')->where('id', $id)->where('idUsuario' , $_SESSION['idUsuario'])->update($request->except(['_token', '_method']));
            $mensaje = "El registro '$request->nombreAbono' ha sido actualizado con éxito";
            return $this->index($mensaje);            
        }
        #EN CASO DE ERROR EN LA QUERY ATRAPAMOS EL ERROR Y LO DEVOLVEMOS A LA VISTA
        catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                $mensaje = "Error al actualizar el registro, entrada duplicada [Error Code: 1062]";
                return $this->index($mensaje);
            } else {
                $mensaje = "Ha ocurrido un error al actualizar [Error Code: " . $e->errorInfo[1] . "]";
                //dd($e->errorInfo);
                return $this->index($mensaje);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['idUsuario'])) {
            header("Location:/login");
            exit();
        }

        try{
            $respuesta = DB::table('abonos')->where('id','=', $id)->where('idUsuario' ,'=', $_SESSION['idUsuario'])->delete();

            if ($respuesta == 1) {
                $mensaje = "El registro ha sido eliminado con éxito";
                return $this->index($mensaje);
            } elseif ($respuesta > 1) {
                $mensaje = "WARNING Se han eliminado $respuesta registros";
                return $this->index($mensaje);
            }else {
                $mensaje = "No se ha podido eliminar ese registro";
                return $this->index($mensaje);
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            $mensaje = "Error al eliminar el registro de id =".$id." [Error Code: ".$e->errorInfo[1]."]";
            //dd($e->errorInfo);
            return $this->index($mensaje);
        }
    }
}
