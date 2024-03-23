<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<style type="text/css">
  .xContainer{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    vertical-align: middle;
  }
  .image_result{
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid black;
    /*flex-grow: 1;*/
    vertical-align: middle;
    align-content: center;
    flex-basis: 200;
    width: 150px;
    height: 200px;
  }
  .image_result img {
    max-width: 100%; /* Fit the image to the container width */
    height: 100%; /* Maintain the aspect ratio */
  }
</style>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <!-- <h2>Absensi Personel</h2> -->
              <div class="col-md-3 col-sm-3  ">
                Tanggal Awal
                <input type="date" name="TglAwal" id="TglAwal" class="form-control ">
              </div>
              <div class="col-md-3 col-sm-3  ">
                Tanggal Awal
                <input type="date" name="TglAkhir" id="TglAkhir" class="form-control ">
              </div>
              <div class="col-md-3 col-sm-3 ">
                Cabang
                <select class="form-control col-md-6" id="CabangIDFilter" name="CabangIDFilter" >
                  <option value="0">Pilih Cabang</option>
                  <?php

                    foreach ($Cabang as $key) {
                      echo "<option value = '".$key->id."'>".$key->CabangName."</option>";
                    }
                  ?>
                </select>
              </div>
              <div class="col-md-3 col-sm-3 ">
                <br>
                <button class="btn btn-primary" id="btn_Search">Cari Data</button>
              </div>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <div class="dx-viewport demo-container">
                <div id="data-grid-demo">
                  <div id="gridContainer">
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->
<?php
  require_once(APPPATH."views/parts/Footer.php");
?>
<script type="text/javascript">
  var SelectedNoJadwal = "";
  var SelectedCabangID = "";
  $(function () {
    var CabangID = "<?php echo $CabangID; ?>"

    $(document).ready(function () {
      $('#CabangID').select2({
        width: '100%'
      });

      $('#CabangIDFilter').select2({
        width: '100%'
      });

      if (CabangID != 0) {
        $('#CabangID').prop('disabled', true);
        $('#CabangID').val(CabangID).trigger('change');

        $('#CabangIDFilter').prop('disabled', true);
        $('#CabangIDFilter').val(CabangID).trigger('change');
      }

      var now = new Date();
      var day = ("0" + now.getDate()).slice(-2);
      var month = ("0" + (now.getMonth() + 1)).slice(-2);
      var today = now.getFullYear()+"-"+month+"-01";
      var lastDayofYear = now.getFullYear()+"-"+month+"-"+day;

      $('#TglAwal').val(today);
      $('#TglAkhir').val(lastDayofYear);

      readData();
    });

    $('#btn_Search').click(function () {
      readData()
    })

    function readData() {
      var NikPersonel = "<?php echo $NIKPersonel; ?>";
      $.ajax({
        type: "post",
        url: "<?=base_url()?>AbsensiController/Read",
        data: {
          'TglAwal':$('#TglAwal').val(),
          'TglAkhir':$('#TglAkhir').val(),
          'NoTransaksi' : '',
          'CabangID' : $('#CabangIDFilter').val(),
          'NikPersonel' : '',
          'NoReff' : ''
        },
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });
    }
    function bindGrid(data) {
      var canAdd = "<?php echo $canAdd; ?>";
      var canEdit = "<?php echo $canEdit; ?>";
      var canDelete = "<?php echo $canDelete; ?>";

      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "NoTransaksi",
            showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: true
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Search..."
            },
            export: {
                enabled: true,
                fileName: "Laporan Absensi"
            },
            columns: [
                {
                    dataField: "NoTransaksi",
                    caption: "No. Reg Jadwal",
                    allowEditing:false,
                    groupIndex :0
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Tanggal",
                    allowEditing:false,
                },
                {
                    dataField: "JenisJadwal",
                    caption: "Jenis Jadwal",
                    allowEditing:false
                },
                {
                    dataField: "CabangID",
                    caption: "CabangID",
                    allowEditing:false,
                    visible: false
                },
                {
                    dataField: "PIC",
                    caption: "NIK",
                    allowEditing:false,
                },
                {
                    dataField: "NamaLengkap",
                    caption: "Nama",
                    allowEditing:false,
                },
                {
                    dataField: "CabangName",
                    caption: "Cabang",
                    allowEditing:false,
                },
                {
                    dataField: "NamaJadwal",
                    caption: "Nama Jadwal",
                    allowEditing:false,
                },
                {
                    dataField: "JamMulai",
                    caption: "Mulai",
                    allowEditing:false,
                },
                {
                    dataField: "JamSelesai",
                    caption: "Selesai",
                    allowEditing:false,
                },
                {
                    dataField: "TglAbsen",
                    caption: "Jam Absen",
                    allowEditing:false,
                },
                {
                    dataField: "NoAbsen",
                    caption: "#",
                    allowEditing:false,
                    visible: false
                },
            ],
            grouping: {
                autoExpandAll: true // Expand all groups by default
            }
        });
        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }
  });
</script>