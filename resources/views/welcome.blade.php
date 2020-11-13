@extends('layout')
@section('title','WELCOME')

@section('contenido')
        <div class="jquery-script-center">
            <div id="carbon-block"></div>
            </div>
            <div class="jquery-script-clear"></div>
            </div>
            </div>
              <div class="container">
              <h1>Easy Dual Multiselect Plugin Example</h1>

                <div id="callback">
                  <div>
                    <select id="callback_src" multiple style="width: 7em; height: 10em;" class="form-control">
                      <option value="option1">jQuery</option>
                      <option value="option2">Script</option>
                      <option value="option3">Net</option>
                      <option value="option4">JavaScript</option>
                      <option value="option5">HTML5</option>
                      <option value="option6">CSS/CSS3</option>
                      <option value="option7">ReactJS</option>
                    </select>
                  </div>
                  <div>
                    <div><button type="button" id="callback_adder" class="btn btn-primary mb-1">&gt;</button></div>
                    <div><button type="button" id="callback_remover" class="btn btn-primary mb-1">&lt;</button></div>
                  </div>
                  <div>
                    <select id="callback_dst" multiple style="width: 7em; height: 10em;" class="form-control"></select>
                  </div>
                </div>
                <div id="callback_message" class="alert alert-danger mt-3"></div>

              <script>
              $('#callback').simpleMultiSelect({
                source: '#callback_src',
                destination: '#callback_dst',
                adder: '#callback_adder',
                maxOptions: 3,
                remover: '#callback_remover'
              }).on('option:added', function(e, $option) {
                $('#callback_message').append('added: ' + $option.val() + '<br>');
              }).on('option:removed', function(e, $option) {
                $('#callback_message').append('removed: ' + $option.val() + '<br>');
              });
              </script>


              @endsection
