@extends('templates.master')
@section('title')
    Cuentas bancarias
@endsection
@section('container')
<div class="container mt-4">
    <div class="card">
        <div class="card-header" style="background-color: #E5E5E5; text-align: center;">
            <!-- Message -->
            @if(isset($mensaje))
                <div class="alert alert-success alert-dismissible fade show" role="alert">{{ $mensaje }}</div>
            @endif
            <h1>Cuentas</h1>
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
                            <form class="form-group" method="POST" action="/crearCuenta">
                                <label>Nombre de cuenta</label>
                                <input type="text" id="nombreCuenta" name="nombreCuenta" class="form-control" placeholder="Banco estado">
                                <label>link_token</label>
                                <input type="text" id="link_token" name="link_token" class="form-control" placeholder="link_token">
                                <label>api_key</label>
                                <input type="text" id="api_key" name="api_key" class="form-control" placeholder="api_key">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                                {{ csrf_field() }}
                                {{ method_field('POST') }}
                            </form>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="card-body">
            @if (!$cuentas->isEmpty())
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nombre Cuenta</th>
                            <th scope="col">Dinero en cuenta</th>
                            <th scope="col">Fecha Ultimo Cargo</th>
                            <th scope="col">Monto Ultimo Cargo</th>
                            <th scope="col">Fecha Ultimo Abono</th>
                            <th scope="col">Monto Ultimo Abono</th>
                            <th scope="col">Prueba link_token</th>
                            <th scope="col">Prueba API key</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cuentas as $cuenta)
                            <tr>
                                <td>Nombre prueba</td>
                                <td>Prueba</td>
                                <td>Prueba</td>
                                <td>Prueba</td>
                                <td>Prueba</td>
                                <td>Prueba</td>
                                <td>{{ $cuenta->link_token}}</td>
                                <td>{{ $cuenta->api_key}}</td>
                                <td>
                                    <form class="form-group" method="post" action="/borrarCuenta">
                                        <input type="text" name="id" id="id" value="{{ $cuenta->id}}" hidden>
                                        <button type="submit" class="btn btn-secondary">Borrar</button>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE')}}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3 style="text-align: center;">No tienes cuentas registradas</h1>
            @endif
        </div>
    </div>
</div>
@endsection