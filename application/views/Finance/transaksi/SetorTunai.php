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
            <!-- <h2>Akun Kas</h2> -->
            <div class="row">
              <h2>Transaksi Setor Tunai</h2>
            </div>
            <div class="row">
              <div class="col-md-3 col-sm-3  ">
                Tanggal Awal
                <input type="date" name="TglAwal" id="TglAwal" class="form-control ">
              </div>
              <div class="col-md-3 col-sm-3  ">
                Tanggal Awal
                <input type="date" name="TglAkhir" id="TglAkhir" class="form-control ">
              </div>
              <div class="col-md-3 col-sm-3  ">
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

              <div class="col-md-6 col-sm-6  ">
                <br>
                <button class="btn btn-primary" id="btn_Search">Cari Data</button>
              </div>

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
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Modal Transaksi</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Cabang <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select class="form-control col-md-6" id="CabangID" name="CabangID" >
                <option value="0">Pilih Cabang</option>
                <?php
                  foreach ($Cabang as $key) {
                    echo "<option value = '".$key->id."'>".$key->CabangName."</option>";
                  }
                ?>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">No. Transaksi <span class="required">*</span>
            </label>
            <div class="col-md-3 col-sm-3 ">
              <input type="text" name="NoTransaksi" id="NoTransaksi" placeholder="<AUTO>" class="form-control " readonly>
              <input type="hidden" name="formtype" id="formtype" value="add">
              <input type="hidden" name="BaseType" id="BaseType" value="ST">
            </div>

            <label class="col-form-label col-md-2 col-sm-2" for="first-name">Tgl. Transaksi <span class="required">*</span>
            </label>
            <div class="col-md-3 col-sm-3 ">
              <input type="date" name="TglTransaksi" id="TglTransaksi" placeholder="<AUTO>" class="form-control " >
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Akun Kas <span class="required">*</span>
            </label>
            <div class="col-md-3 col-sm-3 ">
              <select class="form-control" id="KodeAkunKas" name="KodeAkunKas" >
              </select>
            </div>

            <label class="col-form-label col-md-2 col-sm-2" for="first-name">Bank Tujuan <span class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 ">
              <select class="form-control" id="KodeBank" name="KodeBank" >
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Total <span class="required">*</span>
            </label>
            <div class="col-md-3 col-sm-3 ">
              <input type="number" name="Total" id="Total" required="" placeholder="Total" class="form-control ">
            </div>

            <label class="col-form-label col-md-2 col-sm-2" for="first-name">No Reff <span class="required">*</span>
            </label>
            <div class="col-md-3 col-sm-3 ">
              <input type="text" name="NoReff" id="NoReff" required="" placeholder="No. Refrensi" class="form-control ">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Keterangan <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" name="Keterangan" id="Keterangan" required="" placeholder="Keterangan" class="form-control ">
            </div>
          </div>

          <div class="item" form-group>
            <button class="btn btn-primary" id="btn_Save">Save</button>
          </div>
        </form>
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
  $(function () {
    var CabangID = "<?php echo $CabangID; ?>"
    $(document).ready(function () {
      $('#CabangID').select2({
        width: '100%'
      });

      $('#CabangIDFilter').select2({
        width: '100%'
      });

      $('#TipeTransaksi').select2({
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
      $('#TglTransaksi').val(lastDayofYear);

      readData();
    });

    $('#post_').submit(function (e) {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);
      $(this).find(':input:disabled').prop('disabled', false);
      e.preventDefault();
      var me = $(this);
      $.ajax({
        type    :'post',
        url     : '<?=base_url()?>TransaksiKasController/SetorTunai',
        data    : me.serialize(),
        dataType: 'json',
        success : function (response) {
          if(response.success == true){
            $('#modal_').modal('toggle');
            Swal.fire({
              type: 'success',
              title: 'Horay..',
              text: 'Data Berhasil disimpan!',
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
              location.reload();
            });
          }
          else{
            $('#modal_').modal('toggle');
            Swal.fire({
              type: 'error',
              title: 'Woops...',
              text: response.message,
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
              $('#modal_').modal('show');
              $('#btn_Save').text('Save');
              $('#btn_Save').attr('disabled',false);
            });
          }
        }
      });
    });
    $('.close').click(function() {
      location.reload();
    });
    $('#btn_Search').click(function () {
      readData();
    });
    $('#btn_Add').click(function () {
      var NoTransaksi = "-";
      window.location.href = '<?Php echo base_url(); ?>finance/setortunai/add/'+NoTransaksi;
    })
    function GetData(id,CabangID) {
      var where_field = 'id';
      var where_value = id;
      var table = 'users';
      $.ajax({
        type: "post",
        url: "<?=base_url()?>TransaksiKasController/Read",
        data: {'KodeBank':id, CabangID:CabangID},
        dataType: "json",
        success: function (response) {
          $.each(response.data,function (k,v) {
            $('#formtype').val("edit");
            $('#CabangID').val(v.CabangID).trigger('change');
            $('#KodeBank').val(v.KodeBank);
            $('#NamaBank').val(v.NamaBank);
            $('#NoRekening').val(v.NoRekening);
            $('#NamaPemilikRekening').val(v.NamaPemilikRekening);
            $('#AlamatCabangBank').val(v.AlamatCabangBank);

            $('#KodeBank').prop('readonly', true);
            $('#modal_').modal('show');
          });
        }
      });
    }
    function readData() {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>TransaksiKasController/Read",
        data: {
          'TglAwal':$('#TglAwal').val(),
          'TglAkhir':$('#TglAkhir').val(),
          'Transaksi':'',
          'CabangID':$('#CabangIDFilter').val(),
          'BaseType' : 'ST'
        },
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });
    }
    $('#CabangID').change(function () {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>AkunKasController/Read",
        data: {'KodeAkun':'', 'CabangID': $('#CabangID').val() },
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

      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>BankController/Read",
        data: {'KodeBank':'', 'CabangID': $('#CabangID').val() },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response);
          $('#KodeBank').empty();
          var newOption = $('<option>', {
            value: "",
            text: "Pilih Bank"
          });

          $('#KodeBank').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.KodeBank,
              text: v.NamaBank
            });

            $('#KodeBank').append(newOption);
          });
        }
      });

    })
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
                enabled: false
            },
            editing: {
                mode: "row",
                allowAdding:canAdd,
                // allowUpdating: canEdit,
                allowDeleting: canDelete,
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
                fileName: "Transaksi Kas"
            },
            columns: [
                {
                    dataField: "NoTransaksi",
                    caption: "No. Transaksi",
                    allowEditing:false
                },
                {
                    dataField: "NoReff",
                    caption: "Reff",
                    allowEditing:false
                },
                {
                    dataField: "Tanggal",
                    caption: "Tgl. ransaksi",
                    allowEditing:false
                },
                {
                    dataField: "DeskripsiTransaksi",
                    caption: "Transaksi",
                    allowEditing:false
                },
                {
                    dataField: "KodeAkunKas",
                    caption: "Kode Akun",
                    allowEditing:false
                },
                {
                    dataField: "NamaAkun",
                    caption: "Nama Akun",
                    allowEditing:false
                },
                {
                    dataField: "Debit",
                    caption: "Debit",
                    allowEditing:false,
                    dataType: 'number',
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "Credit",
                    caption: "Credit",
                    allowEditing:false,
                    dataType: 'number',
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "StatusTransaksi",
                    caption: "Status",
                    allowEditing:false
                },
                {
                    dataField: "Keterangan",
                    caption: "Keterangan",
                    allowEditing:false
                },
                {
                    dataField: "CabangID",
                    caption: "CabangID",
                    allowEditing:false,
                    visible:false
                },
            ],
            onEditingStart: function(e) {
                GetData(e.data.KodeBank, e.data.CabangID);
            },
            onInitNewRow: function(e) {
                // logEvent("InitNewRow");
                $('#modal_').modal('show');
            },
            onRowInserting: function(e) {
                // logEvent("RowInserting");
            },
            onRowInserted: function(e) {
                // logEvent("RowInserted");
                // alert('');
                // console.log(e.data.onhand);
                // var index = e.row.rowIndex;
            },
            onRowUpdating: function(e) {
                // logEvent("RowUpdating");
            },
            onRowUpdated: function(e) {
                // logEvent(e);
            },
            onRowRemoving: function(e) {
              id = e.data.id;
              Swal.fire({
                title: 'Apakah anda yakin?',
                text: "anda akan menghapus data di baris ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                  var table = 'app_setting';
                  var field = 'id';
                  var value = id;
                  $.ajax({
                      type    :'post',
                      url     : '<?=base_url()?>TransaksiKasController/CRUD',
                      data    : {'NoTransaksi':e.data.NoTransaksi, CabangID:e.data.CabangID,'formtype':'delete'},
                      dataType: 'json',
                      success : function (response) {
                        if(response.success == true){
                          Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      ).then((result)=>{
                            location.reload();
                          });
                        }
                        else{
                          Swal.fire({
                            type: 'error',
                            title: 'Woops...',
                            text: response.message,
                            // footer: '<a href>Why do I have this issue?</a>'
                          }).then((result)=>{
                            location.reload();
                          });
                        }
                      }
                    });
                }
                else{
                  location.reload();
                }
              })
            },
            onRowRemoved: function(e) {
              // console.log(e);
            },
        onEditorPrepared: function (e) {
          // console.log(e);
        }
        });
        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }
  });
</script>