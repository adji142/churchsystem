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

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Modal Setor Tunai</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="item form-group">
          <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Tgl. Setor <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 ">
            <input type="date" name="TglSetor" id="TglSetor" class="form-control">
            <input type="hidden" name="CabangIDData" id="CabangIDData">
            <input type="hidden" name="NoTransaksi" id="NoTransaksi">
          </div>
        </div>

        <div class="item form-group">
          <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Akun Kas <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 ">
            <select class="form-control" id="KodeAkunKas" name="KodeAkunKas" >
              <option value="">Pilih Akun Kas</option>
            </select>
          </div>
        </div>

        <div class="item form-group">
          <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Daftar Bank <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 ">
            <select class="form-control" id="KodeBank" name="KodeBank" >
              <option value="">Pilih Bank</option>
            </select>
          </div>
        </div>

        <div class="item form-group">
          <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Total Setor <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 ">
            <input type="text" name="0" id="Total" class="form-control">
          </div>
        </div>

        <div class="item form-group">
          <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">No. Reff <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 ">
            <input type="text" name="NoReff" id="NoReff" class="form-control">
          </div>
        </div>

        <div class="item" form-group>
          <button class="btn btn-primary" id="btn_Save">Save</button>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> -->
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

      $('#KodeAkunKas').select2({
        width: '100%'
      });

      $('#KodeBank').select2({
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
      $('#TglSetor').val(lastDayofYear);

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

    $('#btn_Save').click(function () {
      var TotalSetor = $('#Total').attr('name');
      $.ajax({
        type: "post",
        url: "<?=base_url()?>TransaksiKasController/SetorTunai",
        data: {
          'NoTransaksi' : '',
          'TglTransaksi' : $('#TglSetor').val(),
          'KodeAkunKas' : $('#KodeAkunKas').val(),
          'KodeBank'  : $('#KodeBank').val(),
          'Total' : TotalSetor,
          'Keterangan' : 'NoReff Bank ' + $('#NoReff').val() ,
          'BaseType' : 'KOL',
          'CabangID' : $('#CabangIDData').val(),
          'NoReff' : $('#NoTransaksi').val(),
          'formtype' : 'add'
        },
        dataType: "json",
        success: function (response) {
          if (response.success == true) {
            Swal.fire({
              type: 'error',
              title: 'Woops...',
              text: 'Data Berhasil disimpan',
              // footer: '<a href>Why do I have this issue?</a>'
            })
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
    });

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
                  // console.log(cellInfo.data)
                  var Sisa = parseFloat(cellInfo.data.Debit) - parseFloat(cellInfo.data.Kredit);

                  // LinkAccess = "<a href = '<?=base_url()?>finance/persembahan/input/"+cellInfo.data.NoTransaksi+"/"+cellInfo.data.CabangID+"' class='btn btn-warning' id = 'btn-penerimaan'>Isi Persembahan</a>";

                  LinkAccess = "<a href = '<?=base_url()?>finance/persembahan/penerimaan/"+cellInfo.data.NoTransaksi+"/"+cellInfo.data.CabangID+"' class='btn btn-warning' id = 'btn-penerimaan'>Penerimaan</a>";
                  LinkAccess += "<a href = '<?=base_url()?>finance/persembahan/pengeluaran/"+cellInfo.data.NoTransaksi+"/"+cellInfo.data.CabangID+"' class='btn btn-danger' id = 'btn-pengeluaran'>Pengeluaran</a>";

                  if (Sisa > 0) {
                    var oParam = "showSetorBank('"+cellInfo.data.NoTransaksi+"','"+cellInfo.data.CabangID+"','"+Sisa+"')";

                    LinkAccess += "<button class='btn btn-default' id = 'btn-setor' onClick="+oParam+">Setor Bank</button>";
                  }
                  else{
                    LinkAccess += "<button class='btn btn-default' id = 'btn-setor' disabled>Setor Bank</button>";
                  }
                  cellElement.append(LinkAccess);
                }
            },
        ],
      }).dxDataGrid('instance');
    }

  });

  function showSetorBank(NoTransaksi, CabangID, Sisa) {
    console.log(NoTransaksi);
    console.log(CabangID);
    console.log(Sisa);

    // get Kas
    $.ajax({
      async:false,
      type: "post",
      url: "<?=base_url()?>AkunKasController/Read",
      data: {'KodeAkun':'', 'CabangID': CabangID },
      dataType: "json",
      success: function (response) {
        // bindGrid(response.data);
        // console.log(response);
        $('#KodeAkunKas').empty();
        var newOption = $('<option>', {
          value: "",
          text: "Pilih Akun"
        });

        $('#KodeAkunKas').append(newOption); 
        $.each(response.data,function (k,v) {
          var newOption = $('<option>', {
            value: v.KodeAkun,
            text: v.NamaAkun
          });

          $('#KodeAkunKas').append(newOption);
        });
      }
    });

    // get Bank

    $.ajax({
      async:false,
      type: "post",
      url: "<?=base_url()?>BankController/Read",
      data: {'KodeBank':'', 'CabangID': CabangID },
      dataType: "json",
      success: function (response) {
        // bindGrid(response.data);
        // console.log(response);
        $('#KodeBank').empty();
        var newOption = $('<option>', {
          value: "",
          text: "Pilih Bank Tujuan"
        });

        $('#KodeBank').append(newOption); 
        $.each(response.data,function (k,v) {
          var newOption = $('<option>', {
            value: v.KodeBank,
            text: v.NamaBank + ' - ' + v.NoRekening
          });

          $('#KodeBank').append(newOption);
        });
      }
    });

    // 
    var SisaTextbox = document.getElementById('Total');
    SisaTextbox.name = parseFloat(Sisa);
    SisaTextbox.value = parseFloat(Sisa).toLocaleString('en-US');

    $('#CabangIDData').val(CabangID);
    $('#NoTransaksi').val(NoTransaksi);
    $('#modal_').modal('show');
  }
</script>