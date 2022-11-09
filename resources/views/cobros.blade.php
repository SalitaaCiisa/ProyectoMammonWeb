@extends('templates.master')
@section('title')
    Cobros
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
            <h1>Cobros</h1>
            <!-- Modal Store Button-->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCobroModal">Agregar</button>
            <!-- Modal Store-->
            <div class="modal fade" id="createCobroModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createCobroModal">Nuevo Cobro</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form-group" method="POST" action="{{ route('cobros.store') }}">
                                <label>Nombre de Cobro</label>
                                <input type="text" id="nombreCobro" name="nombreCobro" class="form-control" placeholder="Netflix familiar" required>
                                <label>Quien cobrará</label>
                                <input type="text" id="cobrador" name="cobrador" class="form-control" placeholder="Netflix" required>
                                <label>Monto</label>
                                <input type="number" id="monto" name="monto" class="form-control" placeholder="6700" required>
                                <label>fecha del Cobro</label>
                                <input type="date" id="fechaCobro" name="fechaCobro" class="form-control" required>
                                <label>Frecuencia</label>
                                <br>
                                <div class="d-flex justify-content-around">
                                    <div><input type="radio" id="frecuencia" name="frecuencia" value="unico"> Unico</div>
                                    <div><input type="radio" id="frecuencia" name="frecuencia" value="mensual"> Mensual</div>
                                    <div><input type="radio" id="frecuencia" name="frecuencia" value="semanal"> Semanal</div>
                                </div>
                                <br>
                                <label>Descripción</label>
                                <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control" maxlength="255"></textarea>
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
            
        </div>
        <div class="card-body">
            @if (!$cobros->isEmpty())
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nombre Cobro</th>
                            <th scope="col">Quien cobrará</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Fecha del Cobro</th>
                            <th scope="col">Frecuencia</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cobros as $cobro)
                            <tr>
                                <td>{{ $cobro->nombreCobro}}</td>
                                <td>{{ $cobro->cobrador}}</td>
                                <td>{{ $cobro->monto}}</td>
                                <td>{{ $cobro->fechaCobro}}</td>
                                <td>{{ $cobro->frecuencia}}</td>
                                <td><!-- Modal Descripcion Button -->
                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#descripcionModal{{$cobro->id}}">
                                      Mostrar
                                    </button>
                                    
                                    <!-- Modal Descripcion -->
                                    <div class="modal fade" id="descripcionModal{{$cobro->id}}" tabindex="-1" aria-labelledby="descripcionModal{{$cobro->id}}Label" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="descripcionModal{{$cobro->id}}Label">Descripción</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <textarea cols="30" rows="5" class="form-control" readonly>{{ $cobro->descripcion}}</textarea>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </td>
                                <td>
                                    <!-- Modal Delete Button -->
                                    <form class="form-group" method="post" action="{{ route('cobros.destroy',['cobro'=>$cobro->id])}}">
                                        <input type="text" name="id" id="id" value="{{ $cobro->id}}" hidden>
                                        <button type="submit" class="btn btn-danger">Borrar</button>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE')}}
                                    </form>
                                    <!-- Modal Update Button -->
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateCobroModal{{$cobro->id}}">Editar</button>

                                    <!-- Modal Update-->
                                    <div class="modal fade" id="updateCobroModal{{$cobro->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateCobroModal">Actualizar cobro</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-group" method="post" action="{{ route('cobros.update',['cobro'=>$cobro->id])}}">
                                                        <label>Nombre de Cobro</label>
                                                        <input type="text" id="nombreCobro" name="nombreCobro" class="form-control" placeholder="Netflix familiar" value="{{ $cobro->nombreCobro}}" required>
                                                        <label>Quien cobrará</label>
                                                        <input type="text" id="cobrador" name="cobrador" class="form-control" placeholder="Netflix" value="{{ $cobro->cobrador}}" required>
                                                        <label>Monto</label>
                                                        <input type="number" id="monto" name="monto" class="form-control" placeholder="6700" value="{{ $cobro->monto}}" required>
                                                        <label>fecha del Cobro</label>
                                                        <input type="date" id="fechaCobro" name="fechaCobro" class="form-control" value="{{ $cobro->fechaCobro}}" required>
                                                        <label>Frecuencia</label>
                                                        <br>
                                                        <div class="d-flex justify-content-around">
                                                            <div><input type="radio" id="frecuencia" name="frecuencia" value="unico" @checked($cobro->frecuencia == "unico")> Unico</div>
                                                            <div><input type="radio" id="frecuencia" name="frecuencia" value="mensual" @checked($cobro->frecuencia == "mensual")> Mensual</div>
                                                            <div><input type="radio" id="frecuencia" name="frecuencia" value="semanal" @checked($cobro->frecuencia == "semanal")> Semanal</div>
                                                        </div>
                                                        <br>
                                                        <label>Descripción</label>
                                                        <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control" maxlength="255">{{ $cobro->descripcion}}</textarea>
                                                        {{ csrf_field() }}
                                                        {{ method_field('PUT')}}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-warning">Actualizar</button>
                                                </div>
                                                    </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3 style="text-align: center;">No tienes Cobros registrados</h3>
            @endif
        </div>
    </div>
</div>
@endsection