<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<!-- page content -->
<style>
    .preserve-whitespace {
        white-space: pre !important;
    }
</style>
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <!-- <h2>Akun Kas</h2> -->
            <div class="row">
              <h2>Akun Kas</h2>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6  ">
                <select class="form-control col-md-6 Select2Container" id="CabangIDFilter" name="CabangIDFilter" >
                  <option value="0">Pilih Cabang</option>
                  <?php

                    foreach ($Cabang as $key) {
                      echo "<option value = '".$key->id."'>".$key->CabangName."</option>";
                    }
                  ?>
                </select>
              </div>

              <div class="col-md-6 col-sm-6  ">
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
        <h4 class="modal-title" id="myModalLabel">Modal Akun Kas</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Area <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select class="form-control Select2Container" id="Area" name="Area" >
                <option value="">Pilih Area</option>
                <?php

                  foreach ($area as $key) {
                    echo "<option value = '".$key->id."'>".$key->NamaArea."</option>";
                  }
                ?>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Provinsi <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select class="form-control Select2Container" id="ProvID" name="ProvID" >
                <option value="">Pilih Provinsi</option>
                <?php 
                  foreach ($prov as $key) {
                    echo "<option value = '".$key->prov_id."' >".$key->prov_name."</option>";
                  }
                ?>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kota <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select class="form-control Select2Container" id="KotaID" name="KotaID" >
                <option value="">Pilih Kota</option>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Cabang <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select class="form-control Select2Container" id="CabangID" name="CabangID" >
                <option value="0">Pilih Cabang</option>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kode Akun <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" name="KodeAkun" id="KodeAkun" required="" placeholder="Kode Akun" class="form-control ">
              <input type="hidden" name="formtype" id="formtype" value="add">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Akun <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" name="NamaAkun" id="NamaAkun" required="" placeholder="Nama Akun" class="form-control ">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Level <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select class="form-control Select2Container" id="Level" name="Level" >
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kode Akun Induk <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select class="form-control Select2Container" id="KodeAkunInduk" name="KodeAkunInduk" >
                <option value="">Pilih Kode Akun Induk</option>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Keterangan <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" name="Keterangan" id="Keterangan" placeholder="Keterangan" class="form-control ">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">PIC Kas <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select class="form-control Select2Container" id="PICKas" name="PICKas">
                <option value="">Pilih PIC Kas</option>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Ibadah <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select class="form-control Select2Container" id="JadwalIbadahID" name="JadwalIbadahID">
                <option value="">Pilih Ibadah</option>
              </select>
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

      $('.Select2Container').select2({
        width: '100%'
      });

      if (CabangID != 0) {
        $('#CabangID').prop('disabled', true);
        $('#CabangID').val(CabangID).trigger('change');

        $('#CabangIDFilter').prop('disabled', true);
        $('#CabangIDFilter').val(CabangID).trigger('change');
      }

      GetPersonel()
      readData();
    });

    function GetPersonel() {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>PersonelController/Read",
        data: {'NIK':'','CabangID': $('#CabangID').val(),'Wilayah': "0",'Provinsi' : "-1",'Kota': "",'DivisiID':"",'JabatanID':'','NIKIn': ''},
        dataType: "json",
        success: function (responsePersonel) {
          $('#PICKas').empty();
          var newOption = $('<option>', {
            value: "",
            text: "Pilih PIC Persembahan"
          });

          $('#PICKas').append(newOption); 
          $.each(responsePersonel.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.NIK,
              text: v.Nama
            });

            $('#PICKas').append(newOption);
          });
        }
      });
    }

    $('#ProvID').change(function () {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>DemografiController/ReadDemografi",
        data: {'demografilevel':'dem_kota', 'wherefield': 'prov_id', 'wherevalue': $('#ProvID').val() },
        dataType: "json",
        success: function (response) {
          $('#KotaID').empty();
          var newOption = $('<option>', {
            value: "",
            text: "Pilih Kota"
          });

          $('#KotaID').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.city_id,
              text: v.city_name
            });

            $('#KotaID').append(newOption);
          });
        }
      });

      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>CabangController/Read",
        data: {'id':'', 'ProvID': $('#ProvID').val()},
        dataType: "json",
        success: function (response) {
          $('#CabangID').empty();
          var newOption = $('<option>', {
            value: 0,
            text: "Pilih Cabang"
          });

          $('#CabangID').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.id,
              text: v.CabangName
            });

            $('#CabangID').append(newOption);
          });

          // Fill Cabang

        }
      });

    });

    $('#Level').change(function () {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>AkunKasController/ReadRaw",
        data: {
          'Area' : $('#Area').val(),
          // 'ProvID' : $('#ProvID').val(),
          // 'KotaID' : $('#KotaID').val(),
          'CabangID' : "0",
          'LevelKurang' : parseInt($('#Level').val())
        },
        dataType: "json",
        success: function (response) {
          $('#KodeAkunInduk').empty();
          var newOption = $('<option>', {
            value: "",
            text: "Pilih Kode Akun Induk"
          });

          $('#KodeAkunInduk').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.KodeAkun,
              text: v.NamaAkun
            });

            $('#KodeAkunInduk').append(newOption);
          });

          // Fill Cabang

        }
      });
    });


    $('#CabangID').change(function () {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>JadwalIbadahController/Read",
        data: {
          'CabangID' : $('#CabangID').val(),
        },
        dataType: "json",
        success: function (response) {
          $('#JadwalIbadahID').empty();
          var newOption = $('<option>', {
            value: "",
            text: "Pilih Jadwal Ibadah"
          });

          $('#JadwalIbadahID').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.id,
              text: v.NamaIbadah
            });

            $('#JadwalIbadahID').append(newOption);
          });

          // Fill Cabang

        }
      });
    })

    $('#post_').submit(function (e) {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);
      $(this).find(':input:disabled').prop('disabled', false);
      e.preventDefault();
      var me = $(this);
      $.ajax({
        type    :'post',
        url     : '<?=base_url()?>AkunKasController/CRUD',
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
    })
    function GetData(id,CabangID) {
      var where_field = 'id';
      var where_value = id;
      var table = 'users';
      $.ajax({
        type: "post",
        url: "<?=base_url()?>AkunKasController/ReadRaw",
        data: {'KodeAkun':id, CabangID:CabangID},
        dataType: "json",
        success: function (response) {
          $.each(response.data,function (k,v) {
            $('#formtype').val("edit");
            $('#Area').val(v.Area).trigger('change');
            $('#ProvID').val(v.ProvID).trigger('change');
            $('#KotaID').val(v.KotaID).trigger('change');
            $('#CabangID').val(v.CabangID).trigger('change');
            $('#Level').val(v.Level).trigger('change');
            $('#KodeAkunInduk').val(v.KodeAkunInduk).trigger('change');
            $('#JadwalIbadahID').val(v.JadwalIbadahID).trigger('change');
            $('#KodeAkun').val(v.KodeAkun);
            $('#NamaAkun').val(v.NamaAkun.trimStart());
            $('#Keterangan').val(v.Keterangan);
            $('#PICKas').val(v.PIC).trigger('change');

            $('#KodeAkun').prop('readonly', true);
            $('#modal_').modal('show');
          });
        }
      });
    }
    function readData() {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>AkunKasController/Read",
        data: {'KodeAkun':'','CabangID':$('#CabangIDFilter').val()},
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
            keyExpr: "KodeAkun",
            showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: true
            },
            editing: {
                mode: "row",
                allowAdding:canAdd,
                allowUpdating: canEdit,
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
                fileName: "Daftar Akun Kas"
            },
            columns: [
                {
                    dataField: "KodeAkun",
                    caption: "Kode Akun",
                    allowEditing:false
                },
                {
                    dataField: "NamaAkun",
                    caption: "Nama Akun",
                    allowEditing:false,
                    cellTemplate: function(container, options) {
                        $('<span>')
                        .addClass('preserve-whitespace')
                        .text(options.value)
                        .appendTo(container);
                    }
                },
                {
                    dataField: "Keterangan",
                    caption: "Keterangan",
                    allowEditing:false
                },
                {
                    dataField: "Saldo",
                    caption: "Saldo",
                    allowEditing:false,
                    dataType: 'number',
                    format: { type: 'fixedPoint', precision: 2 }
                },
                {
                    dataField: "CabangID",
                    caption: "CabangID",
                    allowEditing:false,
                    visible:false
                },
            ],
            onEditingStart: function(e) {
                GetData(e.data.KodeAkun, e.data.CabangID);
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
                      url     : '<?=base_url()?>AkunKasController/CRUD',
                      data    : {'KodeAkun':e.data.KodeAkun, CabangID:e.data.CabangID,'formtype':'delete'},
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