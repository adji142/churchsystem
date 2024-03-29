<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="row" id="HeaderSection">
    <div class="col-md-12">
      <center>
        <h2>SISTEM ADMINISTRASI GEREJA TIBERIAS INDONESIA</h2>
        <p><?php echo ($CabangName == '') ? 'SUPERADMIN' : 'CABANG : '. $CabangName ?></p>
        <p>Selamat datang <strong><?php echo $NamaUser ?></strong> </p>
      </center>
    </div>
  </div>
  <div class="row" id="DashboardSection">
    <div class="col-md-9 col-sm-9">
      <select class="form-control" id="CabangIDFilter" name="CabangIDFilter" >
        <option value="0">Pilih Cabang</option>
        <?php

          foreach ($Cabang as $key) {
            echo "<option value = '".$key->id."'>".$key->CabangName."</option>";
          }
        ?>
      </select>
      <hr>
    </div>
    <div class="col-md-3 col-sm-3">
      <button class="btn btn-primary" id="btSearch">Cari Data</button>
    </div>
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Grafik Kas Tahunan</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="financechart" id="grafikaruskasTahunan" style="width: 100%; height: 250px;"></div>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-sm-4">
      <div class="x_panel">
        <div class="x_title">
          <h2>Total Pemasukan</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content text-center">
          <span class="count_top">Total Pemasukan</span>
          <div class="count">
            <h1><div id="xTotalPemasukan">0</div></h1>
          </div>
          <span class="count_bottom">Pemasukan Bulan ini : <i class="green" id="xPemasukanBulanIni"></i></span>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-sm-4">
      <div class="x_panel">
        <div class="x_title">
          <h2>Total Pengeluaran</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content text-center">
          <span class="count_top">Total Pengeluaran</span>
          <div class="count">
            <h1><div id="xTotalPengeluaran">0</div></h1>
          </div>
          <span class="count_bottom">Pengeluaran Bulan ini : <i class="green" id="xPengeluaranBulanIni"> </i></span>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-sm-4">
      <div class="x_panel">
        <div class="x_title">
          <h2>Saldo</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content text-center">
          <span class="count_top"> Saldo</span>
          <div class="count">
            <h1><div id="xTotalSaldo">0</div></h1>
          </div>
          <span class="count_bottom">Saldo Bulan ini : <i class="green" id="xSaldoBulanIni">4% </i></span>
        </div>
      </div>
    </div>
  </div>

  <!-- <div class="row" style="display: inline-block;" >
    <div class="tile_count">
      <div class="col-md-4 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
        <div class="count">2500</div>
        <span class="count_bottom"><i class="green">4% </i> From last Week</span>
      </div>

      <div class="col-md-4 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
        <div class="count">2500</div>
        <span class="count_bottom"><i class="green">4% </i> From last Week</span>
      </div>

      <div class="col-md-4 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
        <div class="count">2500</div>
        <span class="count_bottom"><i class="green">4% </i> From last Week</span>
      </div>

    </div>
  </div> -->
</div>
<!-- /page content -->
<?php
  require_once(APPPATH."views/parts/Footer.php");
?>
<!-- ECharts -->
<!-- <script src="<?php echo base_url();?>Assets/vendors/echarts/dist/echarts.min.js"></script>
<script src="<?php echo base_url();?>Assets/vendors/echarts/map/js/world.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.3/echarts.min.js" integrity="sha512-EmNxF3E6bM0Xg1zvmkeYD3HDBeGxtsG92IxFt1myNZhXdCav9MzvuH/zNMBU1DmIPN6njrhX1VTbqdJxQ2wHDg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<style type="text/css">
  .HideObject{
    display: all;
  }
</style>
<script type="text/javascript">
  $(function () {
    var CabangID = "<?php echo $CabangID; ?>";
    var AllowFinanceDashboard = "<?php echo $AllowFinanceDashboard; ?>";
    $(document).ready(function () {
      var HideObject = document.getElementById('DashboardSection');
      console.log(AllowFinanceDashboard)
      if (AllowFinanceDashboard == 1) {
        HideObject.style.display = 'none';
      }
      else if (AllowFinanceDashboard =='') {
        HideObject.style.display = 'none'; 
      }
      else{
        HideObject.style.display = 'All';
      }

      $('#CabangIDFilter').select2({
        width: '100%'
      });

      if (CabangID != 0) {

        $('#CabangIDFilter').prop('disabled', true);
        $('#CabangIDFilter').val(CabangID).trigger('change');
      }

      var button = document.getElementById("btSearch");
      button.click();
      loadKasTahunan();
    });

    $('#btSearch').click(function () {
      loadKasTahunan();
    })

    function loadKasTahunan() {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>ReportController/GrafikKasTahunan",
        data: {
          'CabangID'    :$('#CabangIDFilter').val(),
        },
        dataType: "json",
        success: function (response) {
          // Breakdown Transaksi

          var totPemasukan = 0;
          var totPengeluaran = 0;
          var Saldo = 0;

          var PemasukanBulanini = 0;
          var PengeluaranBulanini = 0;
          var SaldoBulanIni = 0;

          var now = new Date();
          var month = now.getMonth() +1;

          for (var i = 0; i < response.data.Pengeluaran.length; i++) {
            // Things[i]
            totPengeluaran += response.data.Pengeluaran[i]

            if (i+1 == month) {
              PengeluaranBulanini += response.data.Pengeluaran[i];
            }
          }

          for (var i = 0; i < response.data.Pemasukan.length; i++) {
            // Things[i]
            // console.log(response.data.Pemasukan[i])
            totPemasukan += response.data.Pemasukan[i]

            if (i+1 == month) {
              PemasukanBulanini += response.data.Pemasukan[i];
            }
          }

          Saldo = totPemasukan - totPengeluaran;
          SaldoBulanIni = PemasukanBulanini - PengeluaranBulanini;
          console.log(AllowFinanceDashboard)

          if (AllowFinanceDashboard == 1) {
            kasTahunan(response.data.Pengeluaran,response.data.Pemasukan);

            $('#xTotalPemasukan').text(totPemasukan.toLocaleString('en-US'));
            $('#xPemasukanBulanIni').text(PemasukanBulanini.toLocaleString('en-US'));

            $('#xTotalPengeluaran').text(totPemasukan.toLocaleString('en-US'));
            $('#xPengeluaranBulanIni').text(PemasukanBulanini.toLocaleString('en-US'));

            $('#xTotalSaldo').text(Saldo.toLocaleString('en-US'));
            $('#xSaldoBulanIni').text(SaldoBulanIni.toLocaleString('en-US'));

          }else{
            var keluar = [0,0,0,0,0,0,0,0,0,0,0,0]
            var masuk = [0,0,0,0,0,0,0,0,0,0,0,0]

            kasTahunan(keluar,masuk);

            $('#xTotalPemasukan').text('**********');
            $('#xPemasukanBulanIni').text('**********');

            $('#xTotalPengeluaran').text('**********');
            $('#xPengeluaranBulanIni').text('**********');

            $('#xTotalSaldo').text('**********');
            $('#xSaldoBulanIni').text('**********');
          }
        }
      });
    }
    function kasTahunan(Keluar, Masuk) {
      var myChart = echarts.init(document.getElementById('grafikaruskasTahunan'));
      option = {
        title: {
          text: ''
        },
        tooltip: {
          trigger: 'axis'
        },
        legend: {
          data: ['Pemasukan', 'Pengeluaran']
        },
        grid: {
          left: '3%',
          right: '4%',
          bottom: '3%',
          containLabel: true
        },
        toolbox: {
          feature: {
            saveAsImage: {}
          }
        },
        xAxis: {
          type: 'category',
          boundaryGap: false,
          data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
          type: 'value'
        },
        series: [
          {
            name: 'Pemasukan',
            type: 'line',
            stack: 'Total',
            // data: [0, 101, 134, 90, 230, 210, 0, 101, 134, 90, 230, 210]
            data : Masuk
          },
          {
            name: 'Pengeluaran',
            type: 'line',
            stack: 'Total',
            data: Keluar
          }
        ]
      };

      myChart.setOption(option);
      window.addEventListener('resize', function() {
        myChart.resize();
      }); 
    }
  });
</script>