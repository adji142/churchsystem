<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <!-- <h2>Jadwal Pelayanan</h2> -->
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
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <h2>Laporan Jadwal Pelayanan</h2>
                <hr>
                <div class="dx-viewport demo-container">
                  <div id="data-grid-demo">
                    <div id="gridContainerHeader">
                    </div>
                  </div>
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
  $(function () {
    var CabangID = "<?php echo $CabangID; ?>"
    $(document).ready(function () {
      $('#CabangID').select2({
        width: '200px'
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

      getHeader();
    });

    $('#btn_Search').click(function () {
      getHeader()
    })

    function getHeader() {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>JadwalPelayananController/ReadHeader",
        data: {'TglAwal':$('#TglAwal').val(),'TglAkhir' : $('#TglAkhir').val(),CabangID:$('#CabangIDFilter').val()},
        dataType: "json",
        success: function (response) {
          if (response.success == true) {
            bindGridHeader(response.data);
            if (response.message != '') {
              Swal.fire({
                type: 'error',
                title: 'Woops...',
                text: response.message,
                // footer: '<a href>Why do I have this issue?</a>'
              })
            }
          }
          else{
            Swal.fire({
              type: 'error',
              title: 'Woops...',
              text: response.message,
              // footer: '<a href>Why do I have this issue?</a>'
            })
          }
        }
      });
    }

    function bindGridHeader(data) {
      var canAdd = "<?php echo $canAdd; ?>";
      var canEdit = "<?php echo $canEdit; ?>";
      var canDelete = "<?php echo $canDelete; ?>";

      var dataGridInstance = $("#gridContainerHeader").dxDataGrid({
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
            fileName: "Laporan Jadwal Pelayanan"
        },
        selection:{
            mode: "single"
        },
        columns: [
            {
                dataField: "NoTransaksi",
                caption: "No. Reg Jadwal",
                allowEditing:false
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
                dataField: "JumlahPelayan",
                caption: "Jumlah Pelayan",
                allowEditing:false,
            },
            {
                dataField: "JumlahKonfirmasiHadir",
                caption: "Bisa Hadir",
                allowEditing:false,
            },
            {
                dataField: "JumlahKonfirmasiTidakHadir",
                caption: "Tidak Bisa Hadir",
                allowEditing:false,
            },
            {
                dataField: "BelumKonfirmasi",
                caption: "Belum Konfirmasi",
                allowEditing:false,
            },
        ],
      }).dxDataGrid('instance');
    }
  });
</script>