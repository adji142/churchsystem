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
            <h2>Jadwal Ibadah</h2>
            <br>
            <hr>
            <div class="col-md-6 col-sm-6 ">
              Cabang
              <select class="form-control" id="CabangIDFilter" name="CabangIDFilter" >
                <option value="0">Pilih Cabang</option>
                <?php

                  foreach ($Cabang as $key) {
                    echo "<option value = '".$key->id."'>".$key->CabangName."</option>";
                  }
                ?>
              </select>
            </div>
            <div class="col-md-6 col-sm-6 ">
              <br>
              <button class="btn btn-primary" id="btn_Search">Cari Data</button>
              <button class="btn btn-danger" id="btn_Add">Tambah Data</button>
            </div>
            <div class="clearfix"></div>
            <hr>
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
        <h4 class="modal-title" id="myModalLabel">Modal Jadwal Ibadah</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Jadwal Ibdah <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" name="NamaIbadah" id="NamaIbadah" required="" placeholder="Nama Jadwal Ibadah" class="form-control ">
              <input type="hidden" name="id" id="id">
              <input type="hidden" name="formtype" id="formtype" value="add">
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
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Hari <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select class="form-control col-md-6" id="Hari" name="Hari" >
                <option value="0">Pilih Hari</option>
                <?php

                  foreach ($Hari as $key) {
                    echo "<option value = '".$key->KodeHari."'>".$key->NamaHari."</option>";
                  }
                ?>
              </select>
            </div>

          </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Jam Mulai <span class="required">*</span>
              </label>
              <div class="col-md-3 col-sm-3 ">
                <input type="Time" name="MulaiJam" id="MulaiJam" required="" placeholder="Jenis Event" class="form-control ">
              </div>

              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Jam Selesai <span class="required">*</span>
              </label>
              <div class="col-md-3 col-sm-3 ">
                <input type="Time" name="SelesaiJam" id="SelesaiJam"  placeholder="Jenis Event" class="form-control ">
              </div>
            </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Keterangan <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-9 ">
                <input type="text" name="Keterangan" id="Keterangan"  placeholder="Keterangan" class="form-control ">
              </div>
            </div>
              <div class="item" form-group>
                <button class="btn btn-primary" id="btn_Save">Save</button>
              </div>
            </form>
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
  $(function () {
    var CabangID = "<?php echo $CabangID; ?>"
    var canAdd = "<?php echo $canAdd; ?>";
    var canEdit = "<?php echo $canEdit; ?>";
    var canDelete = "<?php echo $canDelete; ?>";
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

      $('#btn_Add').attr('disabled',!canAdd);

      ReadData();
    });

    $('#btn_Add').click(function () {
      var id = "0";
      window.location.href = '<?Php echo base_url(); ?>jadwalibadah/input/'+id+'/'+CabangID;
    });

    $('#btn_Search').click(function () {
      ReadData();
    });

    function ReadData() {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>JadwalIbadahController/Read",
        data: {'id':'',CabangID:$('#CabangIDFilter').val()},
        dataType: "json",
        success: function (response) {
          if (response.success == true) {
            bindGrid(response.data);
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
        url     : '<?=base_url()?>JadwalIbadahController/CRUD',
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
    function GetData(id,CabangID) {
      var where_field = 'id';
      var where_value = id;
      var table = 'users';
      $.ajax({
        type: "post",
        url: "<?=base_url()?>JadwalIbadahController/Read",
        data: {'id':id, CabangID:CabangID},
        dataType: "json",
        success: function (response) {
          $.each(response.data,function (k,v) {
            $('#formtype').val("edit");

            $('#id').val(v.id);
            $('#NamaIbadah').val(v.NamaIbadah);
            $('#Hari').val(v.Hari).change();
            $('#CabangID').val(v.CabangID).trigger('change');
            $('#MulaiJam').val(v.MulaiJamFormated);
            $('#SelesaiJam').val(v.SelesaiJamFormated);
            $('#Keterangan').val(v.Keterangan);
            $('#modal_').modal('show');
          });
        }
      });
    }
    function bindGrid(data) {
      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "id",
            showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            remoteOperations: true,
            paging: {
                enabled: true
            },
            editing: {
                mode: "row",
                // allowAdding:canAdd,
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
            rowDragging: {
              allowReordering: true,
              onReorder(e) {
                const visibleRows = e.component.getVisibleRows();
                const toIndex = tasks.findIndex((item) => item.ID === visibleRows[e.toIndex].data.ID);
                const fromIndex = tasks.findIndex((item) => item.ID === e.itemData.ID);

                tasks.splice(fromIndex, 1);
                tasks.splice(toIndex, 0, e.itemData);

                e.component.refresh();
              },
            },
            columns: [
                {
                    dataField: "NamaIbadah",
                    caption: "Nama Jadwal",
                    allowEditing:false
                },
                {
                    dataField: "NamaHari",
                    caption: "Hari",
                    allowEditing:false
                },
                {
                    dataField: "CabangName",
                    caption: "Cabang",
                    allowEditing:false
                },
                {
                    dataField: "MulaiJamFormated",
                    caption: "Jam Mulai",
                    allowEditing:false
                },
                {
                    dataField: "SelesaiJamFormated",
                    caption: "Jam Selesai",
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
                // GetData(e.data.id, e.data.CabangID);
                window.location.href = '<?Php echo base_url(); ?>jadwalibadah/input/'+e.data.id+'/'+e.data.CabangID;
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
                      url     : '<?=base_url()?>JadwalIbadahController/CRUD',
                      data    : {'id':e.data.id, CabangID:e.data.CabangID,'formtype':'delete'},
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