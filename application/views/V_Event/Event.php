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
            <!-- <h2>Data Event</h2> -->
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
              Jenis Event
              <select class="form-control col-md-6" id="JenisEventIDFilter" name="JenisEventIDFilter" >
                <option value="0">Pilih Jenis Event</option>
              </select>
            </div>
            <div class="col-md-6 col-sm-6 ">
              <br>
              <button class="btn btn-primary" id="btn_Search">Cari Data</button>
              <button class="btn btn-danger" id="btn_Add">Tambah Data</button>
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
        <h4 class="modal-title" id="myModalLabel">Modal Data Event</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
          <div class="item form-group">
            <label class="col-form-label col-md-2 col-sm-2" for="TglEvent">No. Reg Event <span class="required">*</span>
            </label>
            <div class="col-md-3 col-sm-3 ">
              <input type="text" name="NoTransaksi" id="NoTransaksi" required="" placeholder="Nomor Register" readonly="" class="form-control ">
              <input type="hidden" name="formtype" id="formtype" value="add">
            </div>

            <label class="col-form-label col-md-2 col-sm-2" for="TglEvent">Tgl Event <span class="required">*</span>
            </label>
            <div class="col-md-3 col-sm-3 ">
              <input type="date" name="TglEvent" id="TglEvent" required="" placeholder="Nomor Register Event" class="form-control ">
            </div>
            <div class="col-md-2 col-sm-2 ">
              <input type="time" name="JamEvent" id="JamEvent" required="" class="form-control ">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-2 col-sm-2" for="first-name">Cabang <span class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 ">
              <select class="form-control col-md-6" id="CabangID" name="CabangID" >
                <option value="0">Pilih Cabang</option>
                <?php

                  foreach ($Cabang as $key) {
                    echo "<option value = '".$key->id."'>".$key->CabangName."</option>";
                  }
                ?>
              </select>
            </div>

            <label class="col-form-label col-md-2 col-sm-2" for="JenisEvent">Jenis Event <span class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 ">
              <select class="form-control col-md-6" id="JenisEventID" name="JenisEventID" >
                <option value="0">Pilih Jenis Event</option>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-2 col-sm-2" for="TglEvent">Nama Event <span class="required">*</span>
            </label>
            <div class="col-md-10 col-sm-10 ">
              <input type="text" name="NamaEvent" id="NamaEvent" required="" placeholder="Nama Event" class="form-control ">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-2 col-sm-2" for="TglEvent">Deskripsi Event <span class="required">*</span>
            </label>
            <div class="col-md-10 col-sm-10 ">
              <textarea id="Keterangan" name="Keterangan" class="resizable_textarea form-control" placeholder="Deskripsi Event"></textarea>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-2 col-sm-2" for="TglEvent">Lokasi Event <span class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 ">
              <input type="text" name="LokasiEvent" id="LokasiEvent" Lokasi="" placeholder="Lokasi Event" class="form-control ">
            </div>

            <label class="col-form-label col-md-2 col-sm-2" for="TglEvent">Alamat <span class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 ">
              <textarea id="AlamatEvent" name="AlamatEvent" class="resizable_textarea form-control" placeholder="Alamat Event"></textarea>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-2 col-sm-2" for="TglEvent">Nama C.P <span class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 ">
              <input type="text" name="ContactPerson" id="ContactPerson" placeholder="Nama Contact Person" class="form-control ">
            </div>

            <label class="col-form-label col-md-2 col-sm-2" for="TglEvent">No. HP CP <span class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 ">
              <input type="text" name="NoHPContactPerson" id="NoHPContactPerson" Lokasi="" placeholder="No. HP Contact Person" class="form-control ">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-2 col-sm-2" for="TglEvent">Event Berulang <span class="required">*</span>
            </label>
            <div class="col-md-2 col-sm-2 ">
              <input type="checkbox" name="Berulang" id="Berulang" class="form-control " value="0">
            </div>

            <label class="col-form-label col-md-1 col-sm-1" for="TglEvent">Interval <span class="required">*</span>
            </label>
            <div class="col-md-3 col-sm-3 ">
              <input type="number" name="IntervalBerulang" id="IntervalBerulang" placeholder="Inverval" class="form-control ">
            </div>

            <div class="col-md-4 col-sm-4 ">
              <select class="form-control" id="IntervalType" name="IntervalType" >
                <option value="Hari">Hari</option>
                <option value="Minggu">Minggu</option>
                <option value="Bulan">Bulan</option>
                <option value="Tri Semester">Tri Semester</option>
                <option value="Semester">Semester</option>
                <option value="Tahun">Tahun</option>
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
    var CabangID = "<?php echo $CabangID; ?>";
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

      $('#JenisEventID').select2({
        width: '100%'
      });

      $('#JenisEventIDFilter').select2({
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

      $('#btn_Add').attr('disabled',!canAdd);

      GetRecordData();
    });

    function GetRecordData() {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>EventController/Read",
        data: {'TglAwal':$('#TglAwal').val(),'TglAkhir' : $('#TglAkhir').val(),'CabangIDFilter':$('#CabangIDFilter').val(), 'JenisEventIDFilter' : $('#JenisEventIDFilter').val()},
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

    $('#CabangID').change(function () {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>JenisEventController/Read",
        data: {'id':'', 'CabangID': $('#CabangID').val() },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response);
          $('#JenisEventID').empty();
          var newOption = $('<option>', {
            value: -1,
            text: "Pilih Jenis Event"
          });

          $('#JenisEventID').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.id,
              text: v.NamaJenisEvent
            });

            $('#JenisEventID').append(newOption);
          });
        }
      });
    });

    $('#CabangIDFilter').change(function () {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>JenisEventController/Read",
        data: {'id':'', 'CabangID': $('#CabangID').val() },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response);
          $('#JenisEventIDFilter').empty();
          var newOption = $('<option>', {
            value: -1,
            text: "Pilih Jenis Event"
          });

          $('#JenisEventIDFilter').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.id,
              text: v.NamaJenisEvent
            });

            $('#JenisEventIDFilter').append(newOption);
          });
        }
      });
    });

    $('#post_').submit(function (e) {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);
      $(this).find(':input:disabled').prop('disabled', false);
      e.preventDefault();
      var me = $(this);
      $.ajax({
        type    :'post',
        url     : '<?=base_url()?>EventController/CRUD',
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

    $('#btn_Search').click(function () {
      GetRecordData();
    });
    $('#btn_Add').click(function () {
      var id = "0";
      window.location.href = '<?Php echo base_url(); ?>event/input/-/'+CabangID;
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
        url: "<?=base_url()?>EventController/Find",
        data: {'id':id, CabangID:CabangID},
        dataType: "json",
        success: function (response) {
          $.each(response.data,function (k,v) {
            $('#formtype').val("edit");

            $('#NoTransaksi').val(v.NoTransaksi)
            $('#TglEvent').val(v.TglEventFIx)
            $('#JamEvent').val(v.JamEventFormted)
            $('#NamaEvent').val(v.NamaEvent)
            $('#CabangID').val(v.CabangID).trigger('change');
            $('#JenisEventID').val(v.JenisEventID)
            $('#LokasiEvent').val(v.LokasiEvent)
            $('#AlamatEvent').val(v.AlamatEvent)
            $('#ContactPerson').val(v.ContactPerson)
            $('#NoHPContactPerson').val(v.NoHPContactPerson)
            $('#Berulang').val(v.Berulang)
            $('#IntervalBerulang').val(v.IntervalBerulang)
            $('#IntervalType').val(v.IntervalType)
            $('#Keterangan').val(v.Keterangan)

            $('#modal_').modal('show');
          });
        }
      });
    }
    function bindGrid(data) {

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
                    dataField: "NoTransaksi",
                    caption: "No. Register",
                    allowEditing:false
                },
                {
                    dataField: "NamaEvent",
                    caption: "Nama Event",
                    allowEditing:false
                },
                {
                    dataField: "Keterangan",
                    caption: "Deskripsi",
                    allowEditing:false
                },
                {
                    dataField: "TglEventFormated",
                    caption: "Tgl Event",
                    allowEditing:false
                },
                {
                    dataField: "JamMulaiFormated",
                    caption: "Jam Mulai",
                    allowEditing:false
                },
                {
                    dataField: "JamSelesaiFormated",
                    caption: "Jam Selesai",
                    allowEditing:false
                },
                {
                    dataField: "ContactPerson",
                    caption: "Contact Person",
                    allowEditing:false
                },
                {
                    dataField: "NoHPContactPerson",
                    caption: "No.HP Contact Person",
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
                // GetData(e.data.NoTransaksi, e.data.CabangID);
                window.location.href = '<?Php echo base_url(); ?>event/input/'+e.data.NoTransaksi+'/'+e.data.CabangID;
            },
            onInitNewRow: function(e) {
                // logEvent("InitNewRow");
                // $('#modal_').modal('show');
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
                      url     : '<?=base_url()?>EventController/CRUD',
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