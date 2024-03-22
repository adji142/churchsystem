<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<style type="text/css">
  #btn-penerimaan{
    color: black !important;
  }
  #btn-pengeluaran{
    color: white !important;
  }
  #btn-setor{
    color: black !important;
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
            <div class="col-md-3 col-sm-3 ">
              <br>
              <button class="btn btn-danger" id="btn_Add">Tambah Data</button>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <h2>Jadwal Pelayanan</h2>
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

<?php
  require_once(APPPATH."views/parts/Footer.php");
?>

<script type="text/javascript">
  var SelectedNoJadwal = '';
  var SelectedCabang = 0;
  $(function () {
    var CabangID = "<?php echo $CabangID; ?>";

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
    })

    function getHeader() {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>PersembahanController/ReadIbadah",
        data: {'TglAwal':$('#TglAwal').val(),'TglAkhir' : $('#TglAkhir').val(),CabangID:CabangID},
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
            enabled: false
        },
        editing: {
            mode: "row",
            // allowUpdating: canEdit,
            // allowDeleting: canDelete,
            texts: {
                confirmDeleteMessage: ''  
            }
        },
        searchPanel: {
            visible: true,
            width: 240,
            placeholder: "Search..."
        },
        export: {
            enabled: true,
            fileName: "Daftar Pelayanan"
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
                dataField: "JumlahKonfirmasiHadir",
                caption: "Jumlah Petugas",
                allowEditing:false,
            },
            {
                dataField: "JumlahAbsen",
                caption: "Jumlah Petugas Hadir",
                allowEditing:false,
            },
            {
                dataField: "Debit",
                caption: "Penerimaan",
                allowEditing:false,
                allowEditing:false,
                dataType: 'number',
                format: { type: 'fixedPoint', precision: 2 }
            },
            {
                dataField: "Kredit",
                caption: "Pengeluaran",
                allowEditing:false,
                allowEditing:false,
                dataType: 'number',
                format: { type: 'fixedPoint', precision: 2 }
            },
            {
                dataField: "Sisa",
                caption: "Sisa",
                allowEditing:false,
                allowEditing:false,
                dataType: 'number',
                format: { type: 'fixedPoint', precision: 2 },
                calculateCellValue: function(rowData) {
                  return rowData.Debit - rowData.Kredit;
              }
            },
            {
                dataField: "#",
                caption: "Action",
                allowEditing:false,
                fixed: true,
                cellTemplate: function(cellElement, cellInfo) {
                  SelectedNoJadwal = cellInfo.data.NoTransaksi;
                  SelectedCabang = cellInfo.data.CabangID;
                  // console.log(cellInfo.data.NoTransaksi)

                  LinkAccess = "<a href = '<?=base_url()?>finance/persembahan/penerimaan/"+cellInfo.data.NoTransaksi+"/"+cellInfo.data.CabangID+"' class='btn btn-warning' id = 'btn-penerimaan'>Penerimaan</a>";
                  LinkAccess += "<a href = '<?=base_url()?>finance/persembahan/pengeluaran/"+cellInfo.data.NoTransaksi+"/"+cellInfo.data.CabangID+"' class='btn btn-danger' id = 'btn-pengeluaran'>Pengeluaran</a>";
                  LinkAccess += "<a href = '<?=base_url()?>finance/persembahan/penerimaan/"+cellInfo.data.NoTransaksi+"/"+cellInfo.data.CabangID+"' class='btn btn-default' id = 'btn-setor'>Setor Bank</a>";
                  // LinkAccess += "<button class='btn btn-danger' onClick=''>Pengeluaran</button>";
                  // LinkAccess += "<button class='btn btn-default' onClick=''>Setor Bank</button>";
                  // console.log();
                  cellElement.append(LinkAccess);
                }
            },
        ],
      }).dxDataGrid('instance');
    }

  });

  function inputpenerimaan() {
    window.location.href = '<?php echo base_url(); ?>finance/persembahan/penerimaan/'+SelectedNoJadwal+'/'+SelectedCabang;
  }
</script>