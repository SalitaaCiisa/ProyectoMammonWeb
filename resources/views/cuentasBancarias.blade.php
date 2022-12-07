@extends('templates.master')
@section('title')
    Cuentas bancarias
@endsection
@section('container')
<div class="container mt-4">
    @if (count($errors) > 0)
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            @php
                $mensaje = null;
                foreach ($errors->all() as $msg) {
                    echo $msg."<br>";
                }
            @endphp
            </div>
    @endif
    <div class="card">
        <div class="card-header" style="background-color: #E5E5E5; text-align: center;">
            <h1>Cuentas</h1>
            <div class="d-flex justify-content-between">
                <!-- Create user Modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createUserModal">Agregar Cuenta</button>
                <!-- Modal -->
                <div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createUserModal">Nueva Cuenta</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="form-group" method="POST" action="{{ route('cuentas.store') }}">
                                    <label>Nombre de cuenta</label>
                                    <input type="text" id="nombreCuenta" name="nombreCuenta" class="form-control" placeholder="Banco estado">
                                    <label>link_token</label>
                                    <input type="text" id="link_token" name="link_token" class="form-control" placeholder="link_token">
                                    <label>api_key</label>
                                    <input type="text" id="api_key" name="api_key" class="form-control" placeholder="api_key">
                                    {{ csrf_field() }}
                                    {{ method_field('POST') }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                                </form>
                        </div>
                    </div>
                </div>
                <!-- Boton Archivados -->
                <form class="form-group" method="post" action="{{ route('cuentas.show_trashed')}}">
                    <button type="submit" class="btn btn-primary">Archivados</button>
                    {{ csrf_field() }}
                    {{ method_field('GET')}}
                </form>
            </div>
        </div>
        <div class="card-body">
            @if (!$cuentas == null)
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nombre Cuenta</th>
                            <th scope="col">Dinero en cuenta</th>
                            <th scope="col">Fecha Ultimo movimiento</th>
                            <th scope="col">Prueba link_token</th>
                            <th scope="col">Prueba API key</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cuentas as $cuenta)
                            <tr>
                                <td>{{ $cuenta->Cuenta->nombreCuenta}}</td>
                                <td>{{ $cuenta->Array[0]['balance']['available']}}</td>
                                <td>{{ $cuenta->Array[0]['refreshed_at']}}</td>
                                <td>{{ $cuenta->Cuenta->link_token}}</td>
                                <td>{{ $cuenta->Cuenta->api_key}}</td>
                                <td>
                                    <form class="form-group" method="post" action="{{ route('cuentas.destroy',['cuenta'=>$cuenta->Cuenta])}}">
                                        <input type="text" name="id" id="id" value="{{ $cuenta->Cuenta->id}}" hidden>
                                        <button type="submit" class="btn btn-danger">Archivar</button>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE')}}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3 style="text-align: center;">No tienes cuentas registradas</h3>
            @endif
        </div>
    </div>
</div>
@endsection