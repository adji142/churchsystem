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
            <?php 
              if ($header) {
                echo "<h2>Edit Jadwal Pelayanan</h2>";
              }
              else{
                echo "<h2>Tambah Jadwal Pelayanan</h2>";
              }
            ?>
            <?php if ($header): ?>
              
            <?php endif ?>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="item form-group">
                    <label class="col-form-label col-md-2 col-sm-2" for="first-name">No. Register <span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 ">
                      <input type="text" name="NoTransaksi" id="NoTransaksi" required="" placeholder="<AUTO>" readonly="" class="form-control ">
                      <input type="hidden" name="formtype" id="formtype" value="add">
                    </div>

                    <label class="col-form-label col-md-2 col-sm-2" for="first-name">Tanggal <span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 ">
                      <input type="date" name="TglTransaksi" id="TglTransaksi" required="" class="form-control ">
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

                    <label class="col-form-label col-md-2 col-sm-2" for="first-name">Transaksi <span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 ">
                      <select class="form-control col-md-6" id="JenisTransaksi" name="JenisTransaksi" >
                        <option value="0">Pilih Transaksi</option>
                        <option value="1">Ibadah Rutin</option>
                        <option value="2">Events</option>
                      </select>
                    </div>

                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-2 col-sm-2" for="first-name">Jadwal Ibadah <span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 ">
                      <select class="form-control col-md-6" id="JadwalIbadahID" name="JadwalIbadahID">
                        <option value="0">Pilih Jadwal</option>
                      </select>
                    </div>

                    <label class="col-form-label col-md-2 col-sm-2" for="first-name">Event <span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 ">
                      <select class="form-control col-md-6" id="EventID" name="EventID" >
                        <option value="0">Pilih Event</option>
                      </select>
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-2 col-sm-2" for="first-name">Nama Jadwal <span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 ">
                      <input type="text" name="NamaJadwal" id="NamaJadwal" required="" placeholder="Nama Jadwal" class="form-control ">
                    </div>

                    <label class="col-form-label col-md-2 col-sm-2" for="first-name">Deskripsi <span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 ">
                      <textarea id="DeskripsiJadwal" name="DeskripsiJadwal" class="resizable_textarea form-control" placeholder="Deskripsi"></textarea>
                    </div>
                  </div>

                </div>

                <div class="col-md-12 col-sm-12">
                  <h2>Petugas Pelayanan</h2>
                  <hr>
                  <div class="dx-viewport demo-container">
                    <div id="data-grid-demo">
                      <div id="gridContainerPelayan">
                      </div>
                    </div>
                  </div>
                </div>
                <label></label>
                <div class="col-md-12 col-sm-12">
                  <h2></h2>
                  <button class="btn btn-primary" id="btn_save">Simpan</button>
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
        <h4 class="modal-title" id="myModalLabel">Data Personel</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="dx-viewport demo-container">
          <div id="data-grid-demo">
            <div id="gridContainerLookup">
            </div>
          </div>
        </div>

        <div class="item" form-group>
          <button class="btn btn-primary" id="btn_Select">Pilih</button>
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
    var CabangID = "<?php echo $CabangID; ?>";
    var jsonObject = [];
    $(document).ready(function () {
      $('#CabangID').select2({
        width: '100%'
      });

      $('#JenisTransaksi').select2({
        width: '100%'
      });

      $('#JadwalIbadahID').select2({
        width: '100%'
      });

      $('#EventID').select2({
        width: '100%'
      });

      if (CabangID != 0) {
        $('#CabangID').prop('disabled', true);
        $('#CabangID').val(CabangID).trigger('change');
      }

      var now = new Date();
      var day = ("0" + now.getDate()).slice(-2);
      var month = ("0" + (now.getMonth() + 1)).slice(-2);
      var today = now.getFullYear()+"-"+month+"-01";
      var lastDayofYear = now.getFullYear()+"-"+month+"-"+day;

      $('#TglTransaksi').val(lastDayofYear);

      bindGridPersonel([]);
    });
    $('#btn_Select').click(function () {
        var dataGridInstance = $('#gridContainerLookup').dxDataGrid('instance');
        var selectedRowsData = dataGridInstance.getSelectedRowsData();
        AppendItem(selectedRowsData);
    });

    $('#CabangID').change(function () {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>JadwalIbadahController/Read",
        data: {'id':'', 'CabangID': $('#CabangID').val() },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response);
          $('#JadwalIbadahID').empty();
          var newOption = $('<option>', {
            value: -1,
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
        }
      });

      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>EventController/Read",
        data: {'TglAwal':$('#TglTransaksi').val(),'TglAkhir':'2999-01-01', 'CabangIDFilter': $('#CabangID').val(),'JenisEventIDFilter':'' },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response);
          $('#EventID').empty();
          var newOption = $('<option>', {
            value: -1,
            text: "Pilih Event"
          });

          $('#EventID').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.NoTransaksi,
              text: v.NamaEvent
            });

            $('#EventID').append(newOption);
          });
        }
      });
    });

    $('#btn_Save').click(function () {
      
    })

    function AppendItem(data) {
        var dataGridInstance = $('#gridContainerPelayan').dxDataGrid('instance');
        var allRowsData  = dataGridInstance.getDataSource().items();

        if (allRowsData.length > 0) {
            if (cekDuplicate(allRowsData, data[0].NIK)) {
                alert('Data Sudah ada di baris lain');
            }
            else{
                var item = {
                    NIK : data[0].NIK,
                    Nama : data[0].Nama,
                    DivisiID : data[0].DivisiID,
                    NamaDivisi : data[0].NamaDivisi,
                    JabatanID : data[0].JabatanID,
                    NamaJabatan : data[0].NamaJabatan,
                    NoHP : data[0].NoHP,
                    Email : data[0].Email
                }
                jsonObject.push(item);
            }
        }
        else{
            var item = {
                NIK : data[0].NIK,
                Nama : data[0].Nama,
                DivisiID : data[0].DivisiID,
                NamaDivisi : data[0].NamaDivisi,
                JabatanID : data[0].JabatanID,
                NamaJabatan : data[0].NamaJabatan,
                NoHP : data[0].NoHP,
                Email : data[0].Email
            }
            jsonObject.push(item);
        }
        $('#modal_').modal('toggle');
        bindGridPersonel(jsonObject);
        // SetEnableCommand();
        // bindGridDetail();
        // console.log(jsonObject);
    }

    function cekDuplicate(griddata, newValue) {
        var itemCount = 0;
        var duplicate = false;
        for (var i = 0 ; i < griddata.length; i++) {
            if (griddata[i].NIK == newValue) {
                itemCount += 1;
            }
        }

        if (itemCount > 0) {
            duplicate = true;
        }
        return duplicate;
    }

    $('#post_').submit(function (e) {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);
      $(this).find(':input:disabled').prop('disabled', false);
      e.preventDefault();
      var me = $(this);
      $.ajax({
        type    :'post',
        url     : '<?=base_url()?>DivisiController/CRUD',
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

    $('#JenisTransaksi').change(function () {
      console.log($('#JenisTransaksi').val())
      if ($('#JenisTransaksi').val() == 1) {
        $('#JadwalIbadahID').prop('disabled', false);
        $('#EventID').prop('disabled', true);
      }
      else if ($('#JenisTransaksi').val() == 2) {
        $('#EventID').prop('disabled', false);
        $('#JadwalIbadahID').prop('disabled', true);
      }
      else{
        $('#JadwalIbadahID').prop('disabled', true);
        $('#EventID').prop('disabled', true);
      }
    })

    
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
    
    function bindGridPersonelLookup(data) {
        var oldData = {};
        var dataGridInstance = $("#gridContainerLookup").dxDataGrid({
            allowColumnResizing: true,
            dataSource: data,
            keyExpr: "NIK",
            showBorders: true,
            paging: {
                enabled: true
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Search..."
            },
            editing: {
                mode: "row",
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            selection:{
                mode: "single"
            },
            columns: [
                {
                    dataField: "NIK",
                    caption: "Nomor Induk",
                    allowEditing:false,
                },
                {
                    dataField: "Nama",
                    caption: "Nama",
                    allowEditing:false,
                },
                {
                    dataField: "DivisiID",
                    caption: "Divisi",
                    allowEditing:false,
                    visible: false
                },
                {
                    dataField: "NamaDivisi",
                    caption: "Divisi",
                    allowEditing:false,
                },
                {
                    dataField: "JabatanID",
                    caption: "Jabatan",
                    allowEditing:true,
                    visible:false
                },
                {
                    dataField: "NamaJabatan",
                    caption: "Jabatan",
                    allowEditing:true,
                },
                {
                    dataField: "NoHP",
                    caption: "No. HP",
                    allowEditing:true,
                },
                {
                    dataField: "Email",
                    caption: "Email",
                    allowEditing:true,
                },
            ],
        }).dxDataGrid('instance');
    }

    function bindGridPersonel(data) {
        var oldData = {};
        var dataGridInstance = $("#gridContainerPelayan").dxDataGrid({
            allowColumnResizing: true,
            dataSource: data,
            keyExpr: "NIK",
            showBorders: true,
            paging: {
                enabled: true
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Search..."
            },
            editing: {
                mode: "row",
                allowAdding:true,
                allowDeleting: true,
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            columns: [
                {
                    dataField: "NIK",
                    caption: "Nomor Induk",
                    allowEditing:false,
                },
                {
                    dataField: "Nama",
                    caption: "Nama",
                    allowEditing:false,
                },
                {
                    dataField: "DivisiID",
                    caption: "Divisi",
                    allowEditing:false,
                    visible: false
                },
                {
                    dataField: "NamaDivisi",
                    caption: "Divisi",
                    allowEditing:false,
                },
                {
                    dataField: "JabatanID",
                    caption: "Jabatan",
                    allowEditing:true,
                    visible:false
                },
                {
                    dataField: "NamaJabatan",
                    caption: "Jabatan",
                    allowEditing:true,
                },
                {
                    dataField: "NoHP",
                    caption: "No. HP",
                    allowEditing:true,
                },
                {
                    dataField: "Email",
                    caption: "Email",
                    allowEditing:true,
                },
            ],
            onInitNewRow: function(e) {
              $.ajax({
                type: "post",
                url: "<?=base_url()?>PersonelController/Read",
                data: {'NIK':'','CabangID':$('#CabangID').val()},
                dataType: "json",
                success: function (response) {
                  bindGridPersonelLookup(response.data);
                }
              });
              $('#modal_').modal('show');
            },
            onEditorPrepared:function (args) {
            }
        }).dxDataGrid('instance');
    }
  });
</script>