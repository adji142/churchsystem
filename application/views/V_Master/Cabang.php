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
            <h2>Cabang</h2>
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
        <h4 class="modal-title" id="myModalLabel">Modal Cabang</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Cabang <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" name="CabangName" id="CabangName" required="" placeholder="Nama Cabang" class="form-control ">
              <input type="hidden" name="id" id="id">
              <input type="hidden" name="formtype" id="formtype" value="add">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Provinsi <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select id="ProvID" name="ProvID" class="form-control">
                <?php 
                  $data = $this->ModelsExecuteMaster->GetData("dem_provinsi");
                  foreach ($data->result() as $key) {
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
              <select id="KotaID" name="KotaID" class="form-control">
                <option value="">Pilih Kota</option>
                <?php 
                  $data = $this->ModelsExecuteMaster->GetData("dem_kota");
                  foreach ($data->result() as $key) {
                    echo "<option value = '".$key->city_id."' >".$key->city_name."</option>";
                  }
                ?>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kecamatan <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select id="KecID" name="KecID" class="form-control">
                <!-- <option value="-1">Pilih Kecamatan</option> -->
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kelurahan <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select id="KelID" name="KelID" class="form-control">
                <!-- <option value="-1">Pilih Kelurahan</option> -->
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Alamat Saksi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <textarea id="Alamat" name="Alamat" class="resizable_textarea form-control" placeholder="Alamat Saksi"></textarea>
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
        $(document).ready(function () {
          $('#CabangID').select2({
            width: '200px'
          });

          $('#ProvID').select2({
            width: '200px'
          });
          $('#KotaID').select2({
            width: '200px'
          });
          $('#KecID').select2({
            width: '200px'
          });
          $('#KelID').select2({
            width: '200px'
          });

          var CabangID = "<?php echo $CabangID; ?>"
          if (CabangID != 0) {
            $('#CabangID').prop('disabled', true);
          }
          $.ajax({
            type: "post",
            url: "<?=base_url()?>CabangController/Read",
            data: {'id':''},
            dataType: "json",
            success: function (response) {
              bindGrid(response.data);
            }
          });
        });

        $('#ProvID').change(function () {
          $.ajax({
            async:false,
            type: "post",
            url: "<?=base_url()?>DemografiController/ReadDemografi",
            data: {'demografilevel':'dem_kota', 'wherefield': 'prov_id', 'wherevalue': $('#ProvID').val() },
            dataType: "json",
            success: function (response) {
              // bindGrid(response.data);
              // console.log(response);
              $('#KotaID').empty();
              var newOption = $('<option>', {
                value: -1,
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
        });


        $('#KotaID').change(function () {
          $.ajax({
            async:false,
            type: "post",
            url: "<?=base_url()?>DemografiController/ReadDemografi",
            data: {'demografilevel':'dem_kecamatan', 'wherefield': 'kota_id', 'wherevalue': $('#KotaID').val() },
            dataType: "json",
            success: function (response) {
              // bindGrid(response.data);
              // console.log(response);
              $('#KecID').empty();
              var newOption = $('<option>', {
                value: -1,
                text: "Pilih Kecamatan"
              });

              $('#KecID').append(newOption); 
              $.each(response.data,function (k,v) {
                var newOption = $('<option>', {
                  value: v.dis_id,
                  text: v.dis_name
                });

                $('#KecID').append(newOption);
              });
            }
          });
        });

        $('#KecID').change(function () {
          $.ajax({
            async:false,
            type: "post",
            url: "<?=base_url()?>DemografiController/ReadDemografi",
            data: {'demografilevel':'dem_kelurahan', 'wherefield': 'kec_id', 'wherevalue': $('#KecID').val() },
            dataType: "json",
            success: function (response) {
              // bindGrid(response.data);
              // console.log(response);
              $('#KelID').empty();
              var newOption = $('<option>', {
                value: -1,
                text: "Pilih Kelurahan"
              });

              $('#KelID').append(newOption); 
              $.each(response.data,function (k,v) {
                var newOption = $('<option>', {
                  value: v.subdis_id,
                  text: v.subdis_name
                });

                $('#KelID').append(newOption);
              });
            }
          });
        });

        $('#post_').submit(function (e) {
          $('#btn_Save').text('Tunggu Sebentar.....');
          $('#btn_Save').attr('disabled',true);
          e.preventDefault();
          var me = $(this);
          $.ajax({
                type    :'post',
                url     : '<?=base_url()?>CabangController/CRUD',
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
        url: "<?=base_url()?>CabangController/Read",
        data: {'id':id},
        dataType: "json",
        success: function (response) {
          $.each(response.data,function (k,v) {
            $('#formtype').val("edit");

            $('#id').val(v.id);
            $('#CabangName').val(v.CabangName);
            $('#Alamat').val(v.Alamat);
            $('#ProvID').val(v.ProvID).trigger('change');
            $('#KotaID').val(v.KotaID).trigger('change');
            $('#KecID').val(v.KecID).trigger('change');
            $('#KelID').val(v.KelID).trigger('change');

            $('#modal_').modal('show');
          });
        }
      });
    }
    function bindGrid(data) {
      var canAdd = "<?php echo $canAdd; ?>";
      var canEdit = "<?php echo $canEdit; ?>";
      var canDelete = "<?php echo $canDelete; ?>";

      var CabangID = "<?php echo $CabangID; ?>";

      if (CabangID != "0") {
        canAdd = 0;
        canDelete = 0;
      }
      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "id",
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
            columns: [
                {
                    dataField: "id",
                    caption: "id",
                    allowEditing:false,
                    visible: false
                },
                {
                    dataField: "CabangName",
                    caption: "Nama Cabang",
                    allowEditing:false
                },
                {
                    dataField: "Alamat",
                    caption: "Alamat",
                    allowEditing:false
                },
                {
                    dataField: "prov_name",
                    caption: "Provinsi",
                    allowEditing:false
                },
                {
                    dataField: "city_name",
                    caption: "Kota",
                    allowEditing:false
                },
                {
                    dataField: "dis_name",
                    caption: "Kecamatan",
                    allowEditing:false
                },
                {
                    dataField: "subdis_name",
                    caption: "Kelurahan",
                    allowEditing:false
                },
            ],
            onEditingStart: function(e) {
                GetData(e.data.id);
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
                      url     : '<?=base_url()?>CabangController/CRUD',
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