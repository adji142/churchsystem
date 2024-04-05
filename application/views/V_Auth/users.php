<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
    // echo $this->session->userdata('RecordOwnerID');
?>
<style type="text/css">
  .select2-container {
  width: 50% !important;
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
                    <h2>User</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-12 col-sm-12  form-group">
                      <form class="form-horizontal form-label-left">
                        <div class="form-group row">
                          <label class="control-label col-md-1 col-sm-1 ">Roles</label>
                            <div class="col-md-4 col-sm-4 ">
                              <select class="form-control" id="fil_roles" name="fil_roles">
                                <option value="">Semua Role</option>
                                <?php
                                  $rs = $this->db->query("select a.*, b.CabangName from roles a left join cabang b on a.CabangID = b.id")->result();
                                  foreach ($rs as $key) {
                                    echo "<option value = '".$key->id."'>".$key->rolename."</option>";
                                  }
                                ?>
                              </select>
                            </div>
                            <div class="col-md-3 col-sm-3 ">
                              <button type="button" class="btn btn-primary" id="filter_">Filter</button>
                            </div>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-12 col-sm-12  form-group">
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
        </div>
        <!-- /page content -->

        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Modal User</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Username <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="uname" id="uname" required="" placeholder="Username" class="form-control ">
                      <input type="hidden" name="id" id="id">
                      <input type="hidden" name="formtype" id="formtype" value="add">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama User <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="nama" id="nama" required="" placeholder="Nama User" class="form-control ">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Password <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="Password" name="pass" id="pass" required="" placeholder="Password" class="form-control ">
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

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Role <span class="required">*</span>
                    </label>
                    <div class="col-md-12 col-sm-12 ">
                      <select class="form-control col-md-6" id="roles" name="roles" >
                        <option value="0">Pilih Role</option>
                      </select>
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Akses Data <span class="required">*</span>
                    </label>
                    <div class="col-md-3 col-sm-12 ">
                      <input type="checkbox" name="canAdd" id="canAdd" class="form-control col-md-3" value="0"> Add
                    </div>
                    <div class="col-md-3 col-sm-12 ">
                      <input type="checkbox" name="canEdit" id="canEdit" class="form-control col-md-3" value="0"> Edit
                    </div>
                    <div class="col-md-3 col-sm-12 ">
                      <input type="checkbox" name="canDelete" id="canDelete" class="form-control col-md-3" value="0"> Delete
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Allow Finance Dashboard <span class="required">*</span>
                    </label>
                    <div class="col-md-3 col-sm-12 ">
                      <input type="checkbox" name="AllowFinanceDashboard" id="AllowFinanceDashboard" class="form-control col-md-3" value="0"> Add
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">NIK Personel <span class="required">*</span>
                    </label>
                    <div class="col-md-12 col-sm-12 ">
                      <select class="form-control col-md-6" id="NIKPersonel" name="NIKPersonel" >
                        <option value="">Pilih Personel</option>
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
    $(document).ready(function () {
      $('#roles').select2({
        width : '100%'
      });

      $('#CabangID').select2({
        width : '100%'
      });

      $('#NIKPersonel').select2({
        width : '100%'
      });

      var CabangID = "<?php echo $CabangID;?>"
      if (CabangID != 0) {
        $('#CabangID').prop('readonly', true);
      }

      $('#CabangID').val('0').trigger('change');

      var RecordOwnerID = "<?php echo $this->session->userdata('RecordOwnerID') ?>";
      var kriteria = '';
      var skrip = "";
      var userid = '';
      var roleid = $('#fil_roles').val();

      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>Auth/read",
        data: {kriteria:kriteria,skrip:skrip,userid:userid,roleid:roleid},
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });
    });

    $('#canAdd').change(function(){
      if($(this).is(":checked")) {
          $('#canAdd').val("1")
      } else {
          $('#canAdd').val("0")
      }
    });

    $('#canEdit').change(function(){
      if($(this).is(":checked")) {
          $('#canEdit').val("1")
      } else {
          $('#canEdit').val("0")
      }
    });

    $('#canDelete').change(function(){
      if($(this).is(":checked")) {
          $('#canDelete').val("1")
      } else {
          $('#canDelete').val("0")
      }
    });

    $('#AllowFinanceDashboard').change(function(){
      if($(this).is(":checked")) {
          $('#AllowFinanceDashboard').val("1")
      } else {
          $('#AllowFinanceDashboard').val("0")
      }
    });

    $('#filter_').click(function () {
      var kriteria = '';
      var skrip = " a.RecordOwnerID = '" + RecordOwnerID+"' ";
      var userid = '';
      var roleid = $('#fil_roles').val();

      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>Auth/read",
        data: {kriteria:kriteria,skrip:skrip,userid:userid,roleid:roleid},
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });
    });

    $('#CabangID').change(function (e) {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>C_UserManagement/ReadRole",
        data: {'id':''},
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          $('#roles').empty();

          $('#roles').append($('<option>', {
                value: -1,
                text: 'Pilih Role'
            }));

          $.each(response.data,function (k,v) {
            $('#roles').append($('<option>', {
                value: v.id,
                text: v.rolename
            }));
          })
        }
      });

      // NIK

      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>PersonelController/Read",
        data: {'NIK':'','CabangID':$('#CabangID').val(), 'Provinsi':'-1','Wilayah':"0"},
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          $('#NIKPersonel').empty();
          $('#NIKPersonel').append($('<option>', {
                value: "",
                text: "Pilih Personel"
            }));

          $.each(response.data,function (k,v) {
            $('#NIKPersonel').append($('<option>', {
                value: v.NIK,
                text: v.Nama
            }));
          })
        }
      });
    })
    $('#post_').submit(function (e) {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);

      e.preventDefault();
      var me = $(this);

      $.ajax({
        async:false,
        type    :'post',
        url     : '<?=base_url()?>Auth/RegisterUser',
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
        async:false,
        type: "post",
        url: "<?=base_url()?>Auth/ReadUser",
        data: {'id':id},
        dataType: "json",
        success: function (response) {
          $.each(response.data,function (k,v) {
            console.log(response.data);
            // $('#KodePenyakit').val(v.KodePenyakit).change;
            $("#uname").prop("readonly", true);
            $('#uname').val(v.username);
            $('#nama').val(v.nama);
            $('#pass').val(response.decript);
            $('#CabangID').val(v.CabangID).trigger('change');
            $('#roles').val(v.roleid).trigger('change');
            $('#id').val(v.id);

            $('#myCheckbox').prop('checked', false);

            $('#canAdd').val(v.canAdd);
            $('#canEdit').val(v.canEdit);
            $('#canDelete').val(v.canDelete);
            $('#NIKPersonel').val(v.NIKPersonel).trigger('change');
            $('#AllowFinanceDashboard').val(v.AllowFinanceDashboard);
            // $('#Nilai').val(v.Nilai);
            console.log(v.NIKPersonel)

            if (v.canAdd == 1) {
              $('#canAdd').prop('checked', true);
            }
            else{
              $('#canAdd').prop('checked', false); 
            }

            if (v.canEdit == 1) {
              $('#canEdit').prop('checked', true);
            }
            else{
              $('#canEdit').prop('checked', false); 
            }

            if (v.canDelete == 1) {
              $('#canDelete').prop('checked', true);
            }
            else{
              $('#canDelete').prop('checked', false); 
            }

            if (v.AllowFinanceDashboard == 1) {
              $('#AllowFinanceDashboard').prop('checked', true);
            }
            else{
              $('#AllowFinanceDashboard').prop('checked', false); 
            }

            $('#formtype').val("edit");

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
            keyExpr: "UserId",
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
                fileName: "Daftar Penyakit"
            },
            columns: [
                {
                    dataField: "UserId",
                    caption: "#",
                    allowEditing:false
                },
                {
                    dataField: "username",
                    caption: "Username",
                    allowEditing:false
                },
                {
                    dataField: "nama",
                    caption: "Nama",
                    allowEditing:false
                },
                {
                    dataField: "rolename",
                    caption: "Level Akses",
                    allowEditing:false
                },
                {
                    dataField: "canAdd",
                    caption: "Akses Add",
                    allowEditing:false
                },
                {
                    dataField: "canEdit",
                    caption: "Akses Edit",
                    allowEditing:false
                },
                {
                    dataField: "canDelete",
                    caption: "Akses Delete",
                    allowEditing:false
                },
                {
                    dataField: "AllowFinanceDashboard",
                    caption: "Allow Finance Dashboard",
                    allowEditing:false
                }
                // {
                //     dataField: "NamaPenyakit",
                //     caption: "Nama Penyakit",
                //     allowEditing:false
                // },
                // {
                //     dataField: "Nilai",
                //     caption: "Nilai",
                //     allowEditing:false
                // },
            ],
            onEditingStart: function(e) {
                GetData(e.data.UserId);
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
              id = e.data.UserId;
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

                  $.ajax({
                      async:false,
                      type    :'post',
                      url     : '<?=base_url()?>Auth/RegisterUser',
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