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
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Modal Absensi</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Divisi <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" name="NoTransaksi" id="NoTransaksi" required="" placeholder="<AUTO>" class="form-control" readonly="">
              <input type="hidden" name="formtype" id="formtype" value="add">
              <input type="hidden" name="ReffJadwal" id="ReffJadwal" value="">
            </div>
          </div>

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
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nomer Induk Pelayan <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" name="NIK" id="NIK" required="" placeholder="NIK" class="form-control" readonly="">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Pelayan <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" name="NamaLengkap" id="NamaLengkap" required="" placeholder="NamaLengkap" class="form-control" readonly="">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Divisi / Jabatan <span class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 ">
              <label></label>
              <select class="form-control col-md-12" id="DivisiID" name="DivisiID" disabled="">
                <option value="0">Pilih Divisi</option>
              </select>
            </div>
            <label></label>
            <div class="col-md-4 col-sm-4 ">
              <label></label>
              <select class="form-control col-md-12" id="JabatanID" name="JabatanID" disabled="">
                <option value="0">Pilih Jabatan</option>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <div class="col-md-12 col-sm-12 ">
              <textarea id = "image_base64" name = "image_base64" style="display:none"> </textarea>
              <input type="file" id="Attachment" name="Attachment" accept=".jpg" class="btn btn-warning" style="display: none;"/>
              <div class="xContainer">
                <div id="image_result" class="image_result">
                
                </div>
              </div>
            </div>
          </div>
          <div class="item form-group">
            <div class="col-md-12 col-sm-12 text-center">
              <a class="btn btn-success" id = "bt_take_picture" style="color: white"> Take Picture </a>
              <a class="btn btn-danger" id = "bt_clear" style="color: white"> Clear </a>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Keterangan <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" name="Keterangan" id="Keterangan" required="" placeholder="Keterangan" class="form-control" >
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
  var SelectedNoJadwal = "";
  var SelectedCabangID = "";
  $(function () {
    var CabangID = "<?php echo $CabangID; ?>"
    
    var _URL = window.URL || window.webkitURL;
    var _URLePub = window.URL || window.webkitURL;

    Webcam.set({
      width: 150,
      height: 200,
      image_format: 'jpeg',
      jpeg_quality: 90,
      constraints: { facingMode: 'environment' }
    });
    Webcam.attach( '#image_result' );

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

    $('#CabangID').change(function () {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>DivisiController/Read",
        data: {'id':'', 'CabangID': $('#CabangID').val() },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response);
          $('#DivisiID').empty();
          var newOption = $('<option>', {
            value: -1,
            text: "Pilih Divisi"
          });

          $('#DivisiID').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.id,
              text: v.NamaDivisi
            });

            $('#DivisiID').append(newOption);
          });
        }
      });
    });

    $('#DivisiID').change(function () {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>JabatanController/Read",
        data: {'DivisiID':$('#DivisiID').val(), 'CabangID': $('#CabangID').val() },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response);
          $('#JabatanID').empty();
          var newOption = $('<option>', {
            value: -1,
            text: "Pilih Jabatan"
          });

          $('#JabatanID').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.id,
              text: v.NamaJabatan
            });

            $('#JabatanID').append(newOption);
          });
        }
      });
    });

    function readData() {
      var NikPersonel = "<?php echo $NIKPersonel; ?>";
      $.ajax({
        type: "post",
        url: "<?=base_url()?>AbsensiController/Read",
        data: {
          'TglAwal':$('#TglAwal').val(),
          'TglAkhir':$('#TglAkhir').val(),
          'NoTransaksi' : '',
          'CabangID' : CabangID,
          'NikPersonel' : NikPersonel,
          'NoReff' : ''
        },
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });
    }
    $('#post_').submit(function (e) {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);
      $(this).find(':input:disabled').prop('disabled', false);
      e.preventDefault();
      var me = $(this);
      $.ajax({
        type    :'post',
        url     : '<?=base_url()?>AbsensiController/CRUD',
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

    $('#bt_take_picture').click(function(){
      Webcam.snap(function(data_uri){
        // console.log(data_uri);
        $('#my_camera').css('display','none');
        $('#image_result').html("<img src ='"+data_uri+"' width = '400'> ");
        // $('#result').css('display','');
        $('#image_base64').val(data_uri);
      })
    });

    $('#bt_clear').click(function(){
      // $('#image_result').css('display','');
      Webcam.attach( '#image_result' );
      $('#image_base64').val("");
      // $('#image_result').css('display','none');
    });

    $('.close').click(function() {
      location.reload();
    });
    function GetData(id,CabangID) {
      var where_field = 'id';
      var where_value = id;
      var table = 'users';
      $.ajax({
        type: "post",
        url: "<?=base_url()?>DivisiController/Read",
        data: {'id':id,CabangID:CabangID},
        dataType: "json",
        success: function (response) {
          $.each(response.data,function (k,v) {
            $('#formtype').val("edit");

            $('#id').val(v.id);
            $('#NamaDivisi').val(v.NamaDivisi);
            $('#CabangID').val(v.CabangID).trigger('change');

            $('#modal_').modal('show');
          });
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
                enabled: false
            },
            editing: {
                mode: "row",
                // allowAdding:canAdd,
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
                fileName: "Daftar Role"
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
                    caption: "#",
                    allowEditing:false,
                },
                {
                    dataField: "NoAbsen",
                    caption: "#",
                    allowEditing:false,
                    visible: false
                },
                {
                    dataField: "FileItem",
                    caption: "Action",
                    allowEditing:false,
                    cellTemplate: function(cellElement, cellInfo) {
                      SelectedCabangID = cellInfo.data.CabangID;
                      SelectedNoJadwal = cellInfo.data.NoTransaksi;
                      console.log(cellInfo.data)
                      var LinkAccess = "";
                      if (cellInfo.data.NoAbsen == "") {
                        LinkAccess = "<button class='btn btn-warning' onClick='absenModals()'>Hadir</button>";
                      }
                      // console.log();
                      cellElement.append(LinkAccess);
                  }
                }
            ],
            onEditingStart: function(e) {
                GetData(e.data.id,e.data.CabangID);
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
                      url     : '<?=base_url()?>DivisiController/CRUD',
                      data    : {'id':e.data.id,'CabangID':e.data.CabangID,'formtype':'delete'},
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
    function absenModals () {
      // alert(SelectedNoJadwal + ' - ' + SelectedCabangID);
      var NikPersonel = "<?php echo $NIKPersonel; ?>";
      // alert(NikPersonel);
      $.ajax({
        type: "post",
        url: "<?=base_url()?>AbsensiController/Read",
        data: {
          'TglAwal':$('#TglAwal').val(),
          'TglAkhir':$('#TglAkhir').val(),
          'NoTransaksi' : '',
          'CabangID' : SelectedCabangID,
          'NikPersonel' : NikPersonel,
          'NoReff' : SelectedNoJadwal
        },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response.data);
          $.each(response.data,function (k,v) {
            $('#CabangID').val(v.CabangID).trigger('change');
            $('#NIK').val(v.PIC);
            $('#NamaLengkap').val(v.NamaLengkap);
            $('#DivisiID').val(v.DivisiID).trigger('change');
            $('#JabatanID').val(v.JabatanID).trigger('change');
            $('#ReffJadwal').val(SelectedNoJadwal);

            $('#modal_').modal('show');
          });
        }
      });
    }
</script>