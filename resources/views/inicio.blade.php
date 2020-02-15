@extends("theme.$theme.layout")
@section('titulo')
Inicio
@endsection
@section("scripts")
<!-- ChartJS -->
<script src="{{asset("assets/$theme/plugins/chart.js/Chart.min.js")}}"></script>
<script>
$(function() {
    var sics = @json($sics);
    datos = [];
    articulos = [];
    fechasSIC = [];
    sics.forEach(sic => {
        var SicVneto = 0
        var countArticulos = 0;
        sic.lineasSIC.forEach(linea => {
            SicVneto += linea.SicArtCan*linea.Sicartval;
            countArticulos+= 1;
        });
        articulos.push(countArticulos);
        datos.push(Math.round(SicVneto));
        date = new Date(sic.SicFecemi);
        if ((date.getMonth() + 1) < 10){
            if (date.getDate() < 10){
                fechasSIC.push('0'+date.getDate()+'/0'+(date.getMonth() + 1)+'/'+date.getFullYear());
            }else{
                fechasSIC.push(date.getDate()+'/0'+(date.getMonth() + 1)+'/'+date.getFullYear());
            }
        }else{
            if (date.getDate() < 10){
                fechasSIC.push('0'+date.getDate()+'/'+(date.getMonth() + 1)+'/'+date.getFullYear());
            }else{
                fechasSIC.push(date.getDate()+'/'+(date.getMonth() + 1)+'/'+date.getFullYear());
            }
        }
    });

    var mesCompleto = [];
    var dia = new Date();
    var primerDia = new Date(dia.getFullYear(), dia.getMonth(), 1);
    var ultimoDia = new Date(dia.getFullYear(), dia.getMonth() + 1, 0);
    
    for (var fecha = primerDia ; fecha <= ultimoDia ; fecha.setDate(fecha.getDate() + 1)){
        if ((fecha.getMonth() + 1) < 10){
            if (fecha.getDate() < 10){
                mesCompleto.push('0'+fecha.getDate()+'/0'+(fecha.getMonth() + 1)+'/'+fecha.getFullYear());
            }else{
                mesCompleto.push(fecha.getDate()+'/0'+(fecha.getMonth() + 1)+'/'+fecha.getFullYear());
            }
        }else{
            if (fecha.getDate() < 10){
                mesCompleto.push('0'+fecha.getDate()+'/'+(fecha.getMonth() + 1)+'/'+fecha.getFullYear());
            }else{
                mesCompleto.push(fecha.getDate()+'/'+(fecha.getMonth() + 1)+'/'+fecha.getFullYear());
            }
        }
    }
    var fechas = [];


    for(var i = 0 ; i < mesCompleto.length ;  i++){        
        if(mesCompleto[i] != fechasSIC[i]){            
            var fechaTemporal = fechasSIC[i];
            fechasSIC[i] = mesCompleto[i];
            fechasSIC[i+1] = fechaTemporal;
            var datoTemporal = datos[i];
            datos[i] = 0;
            datos[i+1] = datoTemporal;
            var articuloTemporal = articulos[i];
            articulos[i] = 0;
            articulos[i+1] = articuloTemporal;
        }
    }
    var ctx = document.getElementById('myChart').getContext('2d');

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
             ticks: {
                 beginAtZero: true,
                 userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }

                 },
             }
         }],
      }
    };

    

    var areaChartData = {
        labels: mesCompleto,
        datasets: [{
            label: 'Venta',
            data: datos,
            backgroundColor     : 'rgba(255,107,138,0.2)',
            borderColor         : 'rgba(255,107,138,1)',
            borderWidth: 1
        },{
            label: 'Articulos',
            data: articulos,
            backgroundColor     : 'rgba(23, 162, 184, 0.2)',
            borderColor         : 'rgba(23, 162, 184, 1)',
            borderWidth: 1
        }]
    };
    
var myChart = new Chart(ctx, {
    type: 'line',
    data: areaChartData,
    options: areaChartOptions
});
});
</script>
@endsection

@section('contenido')
<!-- Info boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box">
        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file-prescription"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">RECETAS</span>
          <span class="info-box-number">
            10
            {{-- <small>%</small> --}}
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dollar-sign"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">FACTURACIÓN</span>
          <span class="info-box-number">41.410</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-4">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-sort-amount-up"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">UNIDADES</span>
          <span class="info-box-number">760</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->


<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Line Chart</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="chart">
            <canvas id="myChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
@endsection