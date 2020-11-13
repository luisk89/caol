
function groupBy(data, fields, sumBy) {
    let r=[], cmp= (x,y) => fields.reduce((a,b)=> a && x[b]==y[b], true);
    data.forEach(x=> {
      let y=r.find(z=>cmp(x,z));
      let w= [...fields,sumBy].reduce((a,b) => (a[b]=x[b],a), {})
      y ? y[sumBy]=+y[sumBy]+(+x[sumBy]) : r.push(w);
    });
    return r;
  }


      var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];



    function ajaxgraf(){
      var html;
      var categorias;

      var arrayu=new Array();
      var categorias=new Array();


      for(var j=0;j<$('#callback_dst')[0].options.length;j++)
          arrayu[j]=$('#callback_dst')[0].options[j].value

  axios.post('/comercial/ajaxgraf', {
  data: {
    usuarios: arrayu,
    mesFrom: $('#mesFrom').val(),
    mesTo: $('#mesTo').val(),
    anioFrom: $('#anioFrom').val(),
    anioTo: $('#anioTo').val()


  }
  })
  .then(function (response) {
  $('#containerpie').hide();
  $('#containercolumn').show();
  $('#tablaConsultor').hide()

  var series1  = [];

  var usuarios_encontrados = new Array();
  var meses_encontrados= new Array();
  var costos_encontrados = new Array();
  var nuevo_ArrayObject = new Array();
  var datalinea=new Array();
      arrayJSON=response.data;
      arrayJSON.map(function(valor, indice){
          if(usuarios_encontrados.indexOf(valor.usuario) === -1){

              usuarios_encontrados.push(valor.usuario);
              nuevo_ArrayObject.push(valor);

          }
          else{

              var recuperado = usuarios_encontrados.indexOf(valor.usuario);
              var objetoRecuperado = nuevo_ArrayObject[recuperado];


          }
      });

      arrayJSON.map(function(valor, indice){
          if(meses_encontrados.indexOf(valor.mes) === -1){

              meses_encontrados.push(valor.mes);

          }
          else{
              var mesrecuperado = meses_encontrados.indexOf(valor.mes);
          }
      });

      nuevo_ArrayObject.map(function(valor, indice){
      var recetaliquida=new Array();
      for (var i=0;i<groupBy(response.data,['nombre', 'mes','anio'],'recetaliquida').length;i++) {

  if(groupBy(response.data,['nombre', 'mes','anio'],'recetaliquida')[i].nombre==valor.nombre){
    recetaliquida.push(groupBy(response.data,['nombre', 'mes','anio'],'recetaliquida')[i].recetaliquida);
  }

  }

          series1.push({
           type    : 'column',
           name    : valor.nombre,
           data    : recetaliquida

    });

    });

     var resultCategorias=new Array();
    meses_encontrados.forEach(element => {

      if(! isNaN(element) && element >= 1
              && element <= 12 )
              {
                  resultCategorias.push(meses[element - 1]);
                  datalinea.push(response.data[0].costopromedio);
              }


    });



    series1.push({
      type: 'spline',
      name: 'Costo Medio',
      data: datalinea,

  });


  Highcharts.chart('containercolumn', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Performance Comercial'
        },
        xAxis: {
            categories: resultCategorias
        },
        yAxis: {
            title: {
                text: 'Valores'
            }
        },
        series: series1
    });


  })
  .catch(function (error) {
      // handle error
      console.log(error);
  });


  }


  function ajax(){
          var html;

          var arrayu=[];
          for(var j=0;j<$('#callback_dst')[0].options.length;j++)
              arrayu[j]=$('#callback_dst')[0].options[j].value
    axios.post('/comercial/ajax', {
      data: {
        usuarios: arrayu,
        mesFrom: $('#mesFrom').val(),
        mesTo: $('#mesTo').val(),
        anioFrom: $('#anioFrom').val(),
        anioTo: $('#anioTo').val()

      }
    })
   .then(function (response) {

  $('#containerpie').hide();
  $('#containercolumn').hide();
  $('#tablaConsultor').show()
     var usuarios_encontrados = new Array();
      var nuevo_ArrayObject = new Array();
      arrayJSON=response.data;

      arrayJSON.map(function(valor, indice){
          if(usuarios_encontrados.indexOf(valor.nombre) === -1){

              usuarios_encontrados.push(valor.nombre);
              nuevo_ArrayObject.push(valor);
          }
          else{

              var recuperado = usuarios_encontrados.indexOf(valor.nombre);
              var objetoRecuperado = nuevo_ArrayObject[recuperado];
              objetoRecuperado.mesmio = valor.mes;

          }
      });


      var table = '<table><thead><tr><th>Período</th><th>Receita Líquida</th><th>Custo Fixo</th><th>Comissão</th><th>Lucro</th></tr></thead>';
      nuevo_ArrayObject.map(function(valor, indice){
          table += '<tr> <td colspan='+'5'+'><h2>'+valor.nombre+'</h2></td> </tr>';

          for (var i=0;i<groupBy(response.data,['nombre', 'mes','anio'],'recetaliquida').length;i++) {

           if(groupBy(response.data,['nombre', 'mes','anio'],'recetaliquida')[i].nombre==valor.nombre){
              if(! isNaN(groupBy(response.data,['nombre', 'mes','anio'],'recetaliquida')[i].mes) && groupBy(response.data,['nombre', 'mes','anio'],'recetaliquida')[i].mes >= 1
              && groupBy(response.data,['nombre', 'mes','anio'],'recetaliquida')[i].mes <= 12 )
              {
                      var mesL=meses[groupBy(response.data,['nombre', 'mes','anio'],'recetaliquida')[i].mes - 1];
              }

           table+='<tr><td>'+mesL+'  del  '+groupBy(response.data,['nombre', 'mes','anio'],'recetaliquida')[i].anio+'</td><td>'
           +'R$ '+Math.round10(groupBy(response.data,['nombre', 'mes','anio'],'recetaliquida')[i].recetaliquida,-2)+'</td><td>'
           +'R$ '+valor.costofijo+'</td><td>'+'R$ '+Math.round10(groupBy(response.data,['nombre', 'mes','anio'],'comision')[i].comision,-2)+'</td><td>'+'R$ '+Math.round10(groupBy(response.data,['nombre', 'mes','anio'],'lucro')[i].lucro,-2)+'</td></tr>';

          }
          }


      });
      table += '</table>';

      document.getElementById("tablaConsultor").innerHTML = table;



      })
      .catch(function (error) {
          // handle error
          console.log(error);
      });


  }


  function ajaxpie(){

    $('#tablaConsultor').hide()

    var arrayu=[];
    var series1=[];
          for(var j=0;j<$('#callback_dst')[0].options.length;j++)
              arrayu[j]=$('#callback_dst')[0].options[j].value

              if(arrayu.length>0){
      axios.post('/comercial/ajaxpie', {
      data: {
        usuarios: arrayu,
        mesFrom: $('#mesFrom').val(),
        mesTo: $('#mesTo').val(),
        anioFrom: $('#anioFrom').val(),
        anioTo: $('#anioTo').val()

      }
    })
  .then(function (response) {

   $('#containerpie').show();
  $('#containercolumn').hide();
  $('#tablaConsultor').hide();

  totalporciento=0;
  for (var i=0;i<groupBy(response.data,['nombre'],'recetaliquida').length;i++) {
      totalporciento+=groupBy(response.data,['nombre'],'recetaliquida')[i].recetaliquida;
  }


  for (var i=0;i<groupBy(response.data,['nombre'],'recetaliquida').length;i++) {

      var porciento=groupBy(response.data,['nombre'],'recetaliquida')[i].recetaliquida*100/totalporciento;
      series1.push({
          name: groupBy(response.data,['nombre'],'recetaliquida')[i].nombre,
            y: porciento,
            sliced: true,
            selected: true

    });

  }


  Highcharts.chart('containerpie', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Performance Comercial'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: series1
    }]
  });

  })
  .catch(function (error) {
    // handle error
    console.log(error);
  });

  }

  }

  function format(input)
  {
  var n = input.toString();
  var num = n.replace(/\./g,'');
  if(!isNaN(num)){
  num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
  num = num.split('').reverse().join('').replace(/^[\.]/,'');
  input = 'R$ '+num;
  }
  return input;

  }

  (function() {
    /**
     * Ajuste decimal de un número.
     *
     * @param {String}  tipo  El tipo de ajuste.
     * @param {Number}  valor El numero.
     * @param {Integer} exp   El exponente (el logaritmo 10 del ajuste base).
     * @returns {Number} El valor ajustado.
     */
    function decimalAdjust(type, value, exp) {
      // Si el exp no está definido o es cero...
      if (typeof exp === 'undefined' || +exp === 0) {
        return Math[type](value);
      }
      value = +value;
      exp = +exp;
      // Si el valor no es un número o el exp no es un entero...
      if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
        return NaN;
      }
      // Shift
      value = value.toString().split('e');
      value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
      // Shift back
      value = value.toString().split('e');
      return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
    }

    // Decimal round
    if (!Math.round10) {
      Math.round10 = function(value, exp) {
        return decimalAdjust('round', value, exp);
      };
    }
    // Decimal floor
    if (!Math.floor10) {
      Math.floor10 = function(value, exp) {
        return decimalAdjust('floor', value, exp);
      };
    }
    // Decimal ceil
    if (!Math.ceil10) {
      Math.ceil10 = function(value, exp) {
        return decimalAdjust('ceil', value, exp);
      };
    }
  })();
