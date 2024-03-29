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
            <h2>Rate PK</h2>
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
            <div class="col-md-3 col-sm-3 ">
              <br>
              <button class="btn btn-primary" id="btn_Search">Cari Data</button>
            </div>
            <div class="clearfix"></div>
            <hr>
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
        <h4 class="modal-title" id="myModalLabel">Modal Rate</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Deskripsi Rate <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" name="NamaRate" id="NamaRate" required="" placeholder="Deskripsi Rate" class="form-control ">
              <input type="hidden" name="id" id="id">
              <input type="hidden" name="formtype" id="formtype" value="add">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Tgl Berlaku <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="date" name="TglBerlaku" id="TglBerlaku" required="" class="form-control ">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Cabang <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select class="form-control" id="CabangID" name="CabangID" >
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
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Ibadah <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select class="form-control col-md-6" id="IbadahID" name="IbadahID" >
                <option value="">Pilih Jadwal Ibadah</option>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Hari <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select class="form-control" id="Hari" name="Hari" disabled="">
                <option value="">Pilih Hari</option>
                <?php

                  foreach ($Hari as $key) {
                    echo "<option value = '".$key->KodeHari."'>".$key->NamaHari."</option>";
                  }
                ?>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Sesi <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" name="Sesi" id="Sesi" class="form-control" readonly="">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Bidang Pelayanan <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select class="form-control" id="BidangPelayananID" name="BidangPelayananID">
                <option value="">Pilih Bidang Pelayanan</option>
                <?php

                  foreach ($BidangPelayanan as $key) {
                    var_dump($key);
                    echo "<option value = '".$key->id."'>".$key->PosisiPelayanan."</option>";
                  }
                ?>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Rate (Rp) <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="number" name="Rate" id="Rate" required="" placeholder="Rate (Rp)" class="form-control ">
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

      $('#Hari').select2({
        width: '100%'
      });

      $('#IbadahID').select2({
        width: '100%'
      });

      $('#BidangPelayananID').select2({
        width: '100%'
      });

      if (CabangID != 0) {
        $('#CabangID').prop('disabled', true);
        $('#CabangID').val(CabangID).trigger('change');

        $('#CabangIDFilter').prop('disabled', true);
        $('#CabangIDFilter').val(CabangID).trigger('change');
      }

      getRateData();
    });

    function getRateData() {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>RatePKController/Read",
        data: {'id':'', 'CabangID':$('#CabangIDFilter').val()},
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });
    }

    $('#btn_Search').click(function () {
      getRateData()
    })
    $('#CabangID').change(function () {
      $.ajax({
          async:false,
          type: "post",
          url: "<?=base_url()?>JadwalIbadahController/Read",
          data: {'CabangID': $('#CabangID').val(),'Hari': $('#Hari').val()},
          dataType: "json",
          success: function (response) {
            // bindGrid(response.data);
            // console.log(response);
            $('#IbadahID').empty();
            var newOption = $('<option>', {
              value: "",
              text: "Pilih Sesi Ibadah"
            });

            $('#IbadahID').append(newOption); 
            $.each(response.data,function (k,v) {
              var newOption = $('<option>', {
                value: v.id,
                text: v.NamaIbadah
              });

              $('#IbadahID').append(newOption);
            });
          }
      });
    });

    $('#IbadahID').change(function () {
      $.ajax({
          async:false,
          type: "post",
          url: "<?=base_url()?>JadwalIbadahController/Read",
          data: {'id': $('#IbadahID').val(),'CabangID': $('#CabangID').val()},
          dataType: "json",
          success: function (response) {
            // bindGrid(response.data);
            // console.log(response.data[0].Hari);
            $('#Hari').val(response.data[0]['Hari']).trigger('change');
            $('#Sesi').val(response.data[0]['MulaiJamFormated'] + " - " + response.data[0]['SelesaiJamFormated'])
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
        url     : '<?=base_url()?>RatePKController/CRUD',
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
        url: "<?=base_url()?>RatePKController/Read",
        data: {'id':id,CabangID:CabangID},
        dataType: "json",
        success: function (response) {
          console.log(response.data)
          $.each(response.data,function (k,v) {
            $('#formtype').val("edit");
            $('#id').val(v.id);
            $('#NamaRate').val(v.NamaRate);
            $('#TglBerlaku').val(v.TglBerlaku)
            $('#CabangID').val(v.CabangID).trigger('change');
            $('#IbadahID').val(v.IbadahID).trigger('change')
            $('#Hari').val(v.Hari).trigger('change');
            $('#Sesi').val(v.Sesi)
            $('#BidangPelayananID').val(v.BidangPelayananID).trigger('change')
            $('#Rate').val(v.Rate);

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
            keyExpr: "id",
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
                fileName: "Daftar Role"
            },
            columns: [
                {
                    dataField: "NamaRate",
                    caption: "Nama",
                    allowEditing:false
                },
                {
                    dataField: "CabangID",
                    caption: "Nama",
                    allowEditing:false,
                    visible: false
                },
                {
                    dataField: "CabangName",
                    caption: "Cabang",
                    allowEditing:false
                },
                {
                    dataField: "TglBerlaku",
                    caption: "Valid Date",
                    allowEditing:false
                },
                {
                    dataField: "NamaIbadah",
                    caption: "Ibadah",
                    allowEditing:false
                },
                {
                    dataField: "Hari",
                    caption: "Hari",
                    allowEditing:false
                },
                {
                    dataField: "Sesi",
                    caption: "Sesi",
                    allowEditing:false
                },
                {
                    dataField: "PosisiPelayanan",
                    caption: "Bidang Pelayanan",
                    allowEditing:false
                },
                {
                    dataField: "Rate",
                    caption: "Rate (Rp)",
                    allowEditing:false,
                    dataType: 'number',
                    format: { type: 'fixedPoint', precision: 2 }
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
                      url     : '<?=base_url()?>RatePKController/CRUD',
                      data    : {'id':id,'CabangID':e.data.CabangID,'formtype':'delete'},
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