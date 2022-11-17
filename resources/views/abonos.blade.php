@extends('templates.master')
@section('title')
    Abonos
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
            <h1>Abonos</h1>
            <div class="d-flex justify-content-between">
                <!-- Barra de busqueda -->
                <form action="{{route('abonos.show')}}" class="row g-1" method="POST">
                    <div class="col-auto">
                        <input type="text" class="form-control" id="buscar" name="buscar" placeholder="Buscar">
                    </div>
                    <div class="col-auto">
                        <select class="form-control" name="columna" id="columna">
                            <option value="nombreAbono">Nombre</option>
                            <option value="abonador">Abonador</option>
                            <option value="monto">Monto</option>
                            <option value="fechaAbono">Fecha</option>
                            <option value="frecuencia">Frecuencia</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3">Buscar</button>
                    </div>
                    {{ method_field('GET') }}
                </form>
                <!-- Modal Store Button-->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAbonoModal">Agregar</button>
            </div>
            <!-- Modal Store-->
            <div class="modal fade" id="createAbonoModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createAbonoModal">Nuevo abono</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form-group" method="POST" action="{{ route('abonos.store') }}">
                                <label>Nombre de abono</label>
                                <input type="text" id="nombreAbono" name="nombreAbono" class="form-control" placeholder="Sueldo" required>
                                <label>Quien abonará</label>
                                <input type="text" id="abonador" name="abonador" class="form-control" placeholder="Jefe" required>
                                <label>Monto</label>
                                <input type="number" id="monto" name="monto" class="form-control" placeholder="1000000" required>
                                <label>fecha del abono</label>
                                <input type="date" id="fechaAbono" name="fechaAbono" class="form-control" required>
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
            @if (!$abonos->isEmpty())
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nombre Abono</th>
                            <th scope="col">Quien abonará</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Fecha del abono</th>
                            <th scope="col">Frecuencia</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($abonos as $abono)
                            <tr>
                                <td>{{ $abono->nombreAbono}}</td>
                                <td>{{ $abono->abonador}}</td>
                                <td>{{ $abono->monto}}</td>
                                <td>{{ $abono->fechaAbono}}</td>
                                <td>{{ $abono->frecuencia}}</td>
                                <td><!-- Modal Descripcion Button -->
                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#descripcionModal{{$abono->id}}">
                                      Mostrar
                                    </button>
                                    
                                    <!-- Modal Descripcion -->
                                    <div class="modal fade" id="descripcionModal{{$abono->id}}" tabindex="-1" aria-labelledby="descripcionModal{{$abono->id}}Label" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="descripcionModal{{$abono->id}}Label">Descripción</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <textarea cols="30" rows="5" class="form-control" readonly>{{ $abono->descripcion}}</textarea>
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
                                    <form class="form-group" method="post" action="{{ route('abonos.destroy',['abono'=>$abono->id])}}">
                                        <input type="text" name="id" id="id" value="{{ $abono->id}}" hidden>
                                        <button type="submit" class="btn btn-danger">Borrar</button>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE')}}
                                    </form>
                                    <!-- Modal Update Button -->
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateAbonoModal{{$abono->id}}">Editar</button>

                                    <!-- Modal Update-->
                                    <div class="modal fade" id="updateAbonoModal{{$abono->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateAbonoModal">Actualizar abono</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-group" method="post" action="{{ route('abonos.update',['abono'=>$abono->id])}}">
                                                        <label>Nombre de abono</label>
                                                        <input type="text" id="nombreAbono" name="nombreAbono" class="form-control" placeholder="Sueldo" value="{{ $abono->nombreAbono}}" required>
                                                        <label>Quien abonará</label>
                                                        <input type="text" id="abonador" name="abonador" class="form-control" placeholder="Jefe" value="{{ $abono->abonador}}" required>
                                                        <label>Monto</label>
                                                        <input type="number" id="monto" name="monto" class="form-control" placeholder="1000000" value="{{ $abono->monto}}" required>
                                                        <label>fecha del abono</label>
                                                        <input type="date" id="fechaAbono" name="fechaAbono" class="form-control" value="{{ $abono->fechaAbono}}" required>
                                                        <label>Frecuencia</label>
                                                        <br>
                                                        <div class="d-flex justify-content-around">
                                                            <div><input type="radio" id="frecuencia" name="frecuencia" value="unico" @checked($abono->frecuencia == "unico")> Unico</div>
                                                            <div><input type="radio" id="frecuencia" name="frecuencia" value="mensual" @checked($abono->frecuencia == "mensual")> Mensual</div>
                                                            <div><input type="radio" id="frecuencia" name="frecuencia" value="semanal" @checked($abono->frecuencia == "semanal")> Semanal</div>
                                                        </div>
                                                        <br>
                                                        <label>Descripción</label>
                                                        <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control" maxlength="255">{{ $abono->descripcion}}</textarea>
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
                <h3 style="text-align: center;">No tienes abonos registrados</h3>
            @endif
        </div>
    </div>
</div>
@endsection