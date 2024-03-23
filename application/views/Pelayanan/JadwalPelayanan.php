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

              <div class="col-md-12 col-sm-12">
                <h2>Personil</h2>
                <hr>
                <div class="dx-viewport demo-container">
                  <div id="data-grid-demo">
                    <div id="gridContainerDetail">
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
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Modal Jabatan</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Jabatan <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" name="NamaJabatan" id="NamaJabatan" required="" placeholder="Nama Jabatan" class="form-control ">
              <input type="hidden" name="id" id="id">
              <input type="hidden" name="DivisiID" id="DivisiID" value="<?php echo $DivisiID ?>">
              <input type="hidden" name="paramCabangID" id="paramCabangID" value="<?php echo $paramCabangID ?>">
              <input type="hidden" name="formtype" id="formtype" value="add">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Level <span class="required">*</span>
            </label>
            <div class="col-md-12 col-sm-12 ">
              <select class="form-control col-md-6" id="Level" name="Level" >
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Cabang <span class="required">*</span>
            </label>
            <div class="col-md-12 col-sm-12 ">
              <select class="form-control col-md-6" id="CabangID" name="CabangID" >
                <option value="0">Pilih Cabang</option>
                <?php
                  $rs = $this->ModelsExecuteMaster->GetData('cabang')->result();

                  foreach ($rs as $key) {
                    echo "<option value = '".$key->id."'>".$key->CabangName."</option>";
                  }
                ?>
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
      getDetail('','');
    });

    $('#btn_Add').click(function () {
      var NoTransaksi = "-";
      window.location.href = '<?Php echo base_url(); ?>pelayanan/jadwal/'+NoTransaksi+'/'+CabangID;
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

    function getDetail(NoTransaksi, xCabangID) {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>JadwalPelayananController/ReadDetail",
        data: {NoTransaksi:NoTransaksi,'CabangID':xCabangID},
        dataType: "json",
        success: function (response) {
          if (response.success == true) {
            bindGridDetail(response.data);
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

    $('#post_').submit(function (e) {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);
      $(this).find(':input:disabled').prop('disabled', false);
      e.preventDefault();
      var me = $(this);
      $.ajax({
        type    :'post',
        url     : '<?=base_url()?>JabatanController/CRUD',
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
    function GetData(id) {
      var where_field = 'id';
      var where_value = id;
      var table = 'users';
      $.ajax({
        type: "post",
        url: "<?=base_url()?>JabatanController/Read",
        data: {'id':id},
        dataType: "json",
        success: function (response) {
          $.each(response.data,function (k,v) {
            $('#formtype').val("edit");

            $('#id').val(v.id);
            $('#NamaJabatan').val(v.NamaJabatan);
            $('#Level').val(v.Level);
            $('#CabangID').val(v.CabangID).trigger('change');

            $('#modal_').modal('show');
          });
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
            fileName: "Daftar Role"
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
        onEditingStart: function(e) {
            // GetData(e.data.id);
            window.location.href = '<?Php echo base_url(); ?>pelayanan/jadwal/'+e.data.NoTransaksi+'/'+CabangID;
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
                  url     : '<?=base_url()?>JabatanController/CRUD',
                  data    : {'id':id,'formtype':'delete'},
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
      }).dxDataGrid('instance');

      dataGridInstance.on('selectionChanged', function(e) {
        var selectedRows = e.selectedRowsData;
        getDetail(selectedRows[0].NoTransaksi,selectedRows[0].CabangID)
      });
        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }

    function bindGridDetail(data) {
      var canAdd = "<?php echo $canAdd; ?>";
      var canEdit = "<?php echo $canEdit; ?>";
      var canDelete = "<?php echo $canDelete; ?>";

      $("#gridContainerDetail").dxDataGrid({
        allowColumnResizing: true,
        dataSource: data,
        keyExpr: "LineNumber",
        showBorders: true,
        allowColumnReordering: true,
        allowColumnResizing: true,
        columnAutoWidth: true,
        showBorders: true,
        paging: {
            enabled: false
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
                dataField: "LineNum",
                caption: "#",
                allowEditing:false
            },
            {
                dataField: "NamaLengkap",
                caption: "Nama",
                allowEditing:false,
            },
            {
                dataField: "CabangName",
                caption: "Cabang",
                allowEditing:false
            },
            {
                dataField: "NamaDivisi",
                caption: "Divisi",
                allowEditing:false,
                visible: false
            },
            {
                dataField: "NamaJabatan",
                caption: "Jabatan",
                allowEditing:false,
            },
            {
                dataField: "diKonfirmasi",
                caption: "Bisa Hadir (Y/N)",
                allowEditing:false,
            },
            {
                dataField: "KonfirmasiKeterangan",
                caption: "Keterangan",
                allowEditing:false,
            },
        ],
      });
        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }
  });
</script>