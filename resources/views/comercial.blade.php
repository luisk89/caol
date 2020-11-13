@extends('layout')
@section('title','CAOL - Controle de Atividades Online - Agence Interativa')

@section('contenido')

<br>
<br>
<div class="container" style="min-height: 1592.4px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">

      </div><!-- /.container-fluid -->
    </section>
    <script type="application/javascript"> window.onload=function() {
        $('#tablaConsultor').hide(),
        $('#containercolumn').hide()
        }
    </script>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Por Consultor</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Por Cliente</a>
                </li>
              </ul>
        </div>
        <div class="card-body">

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="form-group row">
                        <label for="inputPeriodo" class="col-sm-2 col-form-label">Período</label>
                        <div class="col-sm-10">
                            <select class="custom-select col-md-2" name="select1" id="mesFrom">
                                <option value="1">Jan
                                <option value="2">Fev
                                <option value="3">Mar
                                <option value="4">Abr
                                <option value="5">Mai
                                <option value="6">Jun
                                <option value="7">Jul
                                <option value="8">Ago
                                <option value="9" selected>Set
                                <option value="10">Out
                                <option value="11">Nov
                                <option value="12">Dez
                              </select>
                              <select class="custom-select col-md-2" name="select" id="anioFrom">
                                <option>2003
                                <option>2004
                                <option>2005</option>
                                            <option>2006</option>
                                            <option selected>2007</option>
                              </select>
                              a
                              <select class="custom-select col-md-2" name="select3" id="mesTo">
                                <option value="1">Jan
                                <option value="2">Fev
                                <option value="3">Mar
                                <option value="4">Abr
                                <option value="5">Mai
                                <option value="6">Jun
                                <option value="7">Jul
                                <option value="8">Ago
                                <option value="9" selected>Set
                                <option value="10">Out
                                <option value="11">Nov
                                <option value="12">Dez
                              </select>
                              <select class="custom-select col-md-2" name="select4" id="anioTo">
                                <option>2003
                                <option>2004
                                <option>2005</option>
                        <option>2006</option>
                        <option selected>2007</option>
                              </select>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputConsultor" class="col-sm-2 col-form-label">Consultor</label>
                        <div class="col-sm-10">
                             <div id="callback">
                                <div>
                                  <select id="callback_src" multiple style="width: 100%;" class="form-control">
                                    @forelse ($resultado as $usuarioItem)
                                    <option value={{ $usuarioItem->co_usuario }} >{{ $usuarioItem->no_usuario }}</option>

                                    @empty
                                    <li>No hay proyectos para mostrar</li>

                                @endforelse
                                  </select>
                                </div>
                                <div>
                                  <div><button type="button" id="callback_adder" class="btn btn-primary mb-1">&gt;</button></div>
                                  <div><button type="button" id="callback_remover" class="btn btn-primary mb-1">&lt;</button></div>
                                </div>
                                <div>
                                  <select id="callback_dst" multiple style="width: 100%;" class="form-control"></select>
                                </div>
                                <div class="btn-group-vertical col-sm-3">
                                    <input type="button" name="" id="btnajaxR" class="btn btn-primary" role="button" onclick="ajax()" value="Relatório">
                             <input type="button" name="" id="btnajaxG" class="btn btn-primary" role="button" onclick="ajaxgraf()" value="Gráfico">
                             <input type="button" name="" id="btnajaxP" class="btn btn-primary" role="button" onclick="ajaxpie()" value="Pizza">
                                  </div>
                              </div>


                        </div>
                      </div>


                </div>


                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    Not implemented yet.
                </div>

                  </div>
        </div>
        <!-- /.card-body -->


      </div>
      <!-- /.card -->


<br>
<br>
<div class="card">
    <table id='tablaConsultor' class="table table-bordered table-hover dataTable dtr-inline"></table>

</div>

<div id="containercolumn" style="width:100%; height:400px;"></div>

<div id="containerpie" style="width:100%; height:400px;"></div>
    </section>
    <!-- /.content -->
  </div>
  <script src="{{ asset('js/highcharts.js') }}" type="application/javascript"></script>
  <script src="{{ asset('js/main.js') }}" type="application/javascript"></script>
  <script src="{{ asset('js/jquery-simple-multi-select.js') }}" ></script>

    <script type="application/javascript">
        $('#callback').simpleMultiSelect({
          source: '#callback_src',
          destination: '#callback_dst',
          adder: '#callback_adder',
          maxOptions: 5,
          remover: '#callback_remover'
        }).on('option:added', function(e, $option) {
          $('#callback_message').append('added: ' + $option.val() + '<br>');
        }).on('option:removed', function(e, $option) {
          $('#callback_message').append('removed: ' + $option.val() + '<br>');
        });
        </script>

@endsection
