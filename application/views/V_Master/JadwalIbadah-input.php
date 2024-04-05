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
            <!-- <h2>Jadwal Ibadah</h2> -->
            <?php 
            // var_dump($jadwalibadah);
              if ($jadwalibadah) {
                echo "<h2>Edit Jadwal Ibadah</h2>";
                echo "<input type='hidden' id='formtype' value = 'edit'>";
                echo '<textarea  id="jadwalibadah" style ="display:none;">'.json_encode($jadwalibadah).'</textarea>';
                echo '<textarea  id="template" style ="display:none;">'.json_encode($template).'</textarea>';
              }
              else{
                echo "<h2>Tambah Jadwal Ibadah</h2>";
                echo "<input type='hidden' id='formtype' value = 'add'>";
                echo '<textarea  id="jadwalibadah" style ="display:none;"></textarea>';
                echo '<textarea  id="template" style ="display:none;"></textarea>';
              }
            ?>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Jadwal Ibdah <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 ">
                    <input type="text" name="NamaIbadah" id="NamaIbadah" required="" placeholder="Nama Jadwal Ibadah" class="form-control ">
                    <input type="hidden" name="id" id="id">
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
                  <!-- <div class="item" form-group>
                    <button class="btn btn-primary" id="btn_Save">Save</button>
                  </div> -->
              </div>
              <div class="col-md-12 col-sm-12">
                <h2>Template Pelayanan</h2>
                <hr>
                <div class="dx-viewport demo-container">
                  <div id="data-grid-demo">
                    <div id="gridContainer">
                    </div>
                  </div>
                </div>
                <div class="item" form-group>
                    <button class="btn btn-primary" id="btn_Save" disabled="">Save</button>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel">Modal Jadwal Ibadah</h4>
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
      </button>
    </div>
    <div class="modal-body">
        <div class="item form-group">
          <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Divisi <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 ">
            <select class="form-control col-md-6" id="DivisiID" name="DivisiID" >
              <option value="0">Pilih Divisi</option>
            </select>
          </div>
        </div>

        <div class="item form-group">
          <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Jabatan <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 ">
            <select class="form-control col-md-6" id="JabatanID" name="JabatanID" >
              <option value="0">Pilih Jabatan</option>
            </select>
          </div>
        </div>
        <div class="item form-group">
          <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Keterangan <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 ">
            <input type="number" name="JumlahPelayan" id="JumlahPelayan"  placeholder="Jumlah Pelayan" class="form-control ">
          </div>
        </div>
        <div class="item" form-group>
          <button class="btn btn-primary" id="btn_SaveModals">Save</button>
        </div>
      </div>
  </div>
  <!-- <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  </div> -->
</div>
</div>
<?php
  require_once(APPPATH."views/parts/Footer.php");
?>
<script type="text/javascript">
  $(function () {
    var CabangID = "<?php echo $CabangID; ?>"
    var jsonObject = [];
    var template = [];
    var DivisiName = '';
    var JabatanName = '';
    $(document).ready(function () {
      $('#CabangID').select2({
        width: '100%'
      });
      $('#DivisiID').select2({
        width: '100%'
      });
      $('#JabatanID').select2({
        width: '100%'
      });

      if (CabangID != 0) {
        $('#CabangID').prop('disabled', true);
        $('#CabangID').val(CabangID).trigger('change');
      }

      if ($('#jadwalibadah').val() != ""){
        var jadwalibadah = $.parseJSON($('#jadwalibadah').val());
        // console.log(jadwalibadah)
        $('#id').val(jadwalibadah[0]['id']);
        $('#NamaIbadah').val(jadwalibadah[0]['NamaIbadah']);
        $('#Hari').val(jadwalibadah[0]['Hari']);
        $('#MulaiJam').val(jadwalibadah[0]['MulaiJamFormated']);
        $('#SelesaiJam').val(jadwalibadah[0]['SelesaiJamFormated']);
        $('#CabangID').val(jadwalibadah[0]['CabangID']).trigger('change');
        $('#Keterangan').val(jadwalibadah[0]['Keterangan']);

        console.log($('#template').val())
        if ($('#template').val() != "" || $('#template').val() != "[]") {
          template = $.parseJSON($('#template').val());
          // console.log(template)

          if (template.length > 0) {
            jsonObject.length = 0;
            var x = 0;
            $.each(template,function (k,v) {
              var item = {
                'DivisiID' : v.DivisiID,
                'JabatanID' : v.JabatanID,
                'NamaDivisi' : v.NamaDivisi,
                'NamaJabatan' : v.NamaJabatan,
                'checked' : v.checked,
                'JumlahPelayan' : v.JumlahPelayan
              }
              // console.log(x);
              x += 1;
              jsonObject.push(item);
            });
            // console.log(jsonObject);
            bindGrid(jsonObject)
          }
        }
      }
      setEnableCommand();
    });


    $('#btn_Save').click(function () {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);
      var gridInstance = $("#gridContainer").dxDataGrid("instance");
      var dataSource = gridInstance.getDataSource();

      dataSource.load().done(function(data) {
          var dataParam = {
            'id' : $('#id').val(),
            'NamaIbadah' : $('#NamaIbadah').val(),
            'Hari' : $('#Hari').val(),
            'MulaiJam' : $('#MulaiJam').val(),
            'SelesaiJam' : $('#SelesaiJam').val(),
            'CabangID' : $('#CabangID').val(),
            'Keterangan' : $('#Keterangan').val(),
            'formtype' : $('#formtype').val(),
            'detail' : data
        };

        // console.log(JSON.stringify(dataParam));
        $.ajax({
            async:false,
            url: "<?=base_url()?>JadwalIbadahController/CRUDJson",
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(dataParam),
            success: function(response) {
                // Handle the response from the controller
                // console.log('Response from controller:', response);
                if (response.success == true) {
                    Swal.fire({
                      icon: "success",
                      title: "Horray...",
                      text: "Data berhasil disimpan!",
                    }).then((result)=>{
                      // location.reload();
                      window.location.href = '<?=base_url()?>jadwalibadah';
                    });
                }
                else{
                    Swal.fire({
                      icon: "error",
                      title: "Opps...",
                      text: response.message,
                    });
                    $('#btn_Save').text('Save');
                    $('#btn_Save').attr('disabled',false);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error:', error);
            }
        });
      });
    })

    $('#CabangID').change(function () {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>JadwalIbadahController/ReadTemplate",
        data: {'CabangID':"0",'BaseType':'JADWALIBADAH'},
        dataType: "json",
        success: function (response) {
          // console.log(template);
          if (template.length == 0) {
            // bindGrid(response.data);
            jsonObject = response.data;
            bindGrid(jsonObject)
          }
        }
      });

      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>DivisiController/Read",
        data: {'id':'', 'CabangID': "0" },
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
        data: {'DivisiID':$('#DivisiID').val(), 'CabangID': "0" },
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
    $('#btn_SaveModals').click(function () {
      if (cekDuplicate(jsonObject, $('#JabatanID').val())) {
          alert('Data Sudah ada di baris lain');
      }
      else{
        var item = {
          'DivisiID' : $('#DivisiID').val(),
          'JabatanID' : $('#JabatanID').val(),
          'NamaDivisi' : DivisiName,
          'NamaJabatan' : JabatanName,
          'checked' : 'Y',
          'JumlahPelayan' : $('#JumlahPelayan').val()
        }
        // console.log(item);
        jsonObject.push(item);
        bindGrid(jsonObject);
        $('#modal_').modal('toggle');
      }
    })

    $("#DivisiID").change(function() {
        DivisiName = $(this).find("option:selected").text();
    });
    $("#JabatanID").change(function() {
        JabatanName = $(this).find("option:selected").text();
    });

    function cekDuplicate(griddata, newValue) {
        var itemCount = 0;
        var duplicate = false;
        for (var i = 0 ; i < griddata.length; i++) {
            if (griddata[i].JabatanID == newValue) {
                itemCount += 1;
            }
        }

        if (itemCount > 0) {
            duplicate = true;
        }
        return duplicate;
    }
    function GetData(id,CabangID) {
      var where_field = 'id';
      var where_value = id;
      var table = 'users';
      $.ajax({
        async:false,
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
      var canAdd = "<?php echo $canAdd; ?>";
      var canEdit = "<?php echo $canEdit; ?>";
      var canDelete = "<?php echo $canDelete; ?>";

      // setEnableCommand();

      var dataGridInstance = $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "DivisiID",
            showBorders: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: false
            },
            grouping: {
                autoExpandAll: true,
                allowCollapsing: true
            },
            editing: {
                mode: "row",
                allowAdding:canAdd,
                allowUpdating: true,
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
            selection:{
                mode: "single"
            },
            columns: [
                {
                    caption: "No",
                    width: 50,
                    allowFiltering: false,
                    allowSorting: false,
                    allowEditing:false,
                    cellTemplate: function(container, options) {
                        var dataGrid = options.component,
                            rowIndex = dataGrid.getRowIndexByKey(options.key) + 1;
                        $("<div>")
                            .addClass("dx-datagrid-number-column")
                            .text(rowIndex)
                            .appendTo(container);
                    }
                },
                {
                    dataField: "DivisiID",
                    caption: "#",
                    allowEditing:false,
                    visible:false
                },
                {
                    dataField: "JabatanID",
                    caption: "#",
                    allowEditing:false,
                    visible:false
                },
                {
                    dataField: "NamaDivisi",
                    caption: "Divisi",
                    allowEditing:false,
                },
                
                {
                    dataField: "NamaJabatan",
                    caption: "Jabatan",
                    allowEditing:false,
                    visible:false
                },
                {
                    dataField: "JumlahPelayan",
                    caption: "Jumlah Pelayan",
                    defaultValue : 1
                },
            ],
            onInitNewRow: function(e) {
                // logEvent("InitNewRow");
                $('#modal_').modal('show');
            },
        }).dxDataGrid('instance');
        var allRowsData  = dataGridInstance.getDataSource().items();

        if (allRowsData.length == 0) {
          // $('#bt_save').
          $('#btn_Save').prop('disabled', true);
        }
        else{
          $('#btn_Save').prop('disabled', false);
        }
        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }

    $('#NamaIbadah').change(function () {
      setEnableCommand();
    });

    $('#CabangID').change(function () {
      setEnableCommand();
    });

    $('#Hari').change(function () {
      setEnableCommand();
    });

    $('#MulaiJam').change(function () {
      setEnableCommand();
    });

    $('#SelesaiJam').change(function () {
      setEnableCommand();
    });

    function setEnableCommand() {
      var errorCount = 0;


      if ($('#NamaIbadah').val() == "") {
        errorCount += 1;
      }

      if ($('#CabangID').val() == '0') {
        errorCount += 1;
      }

      if ($('#Hari').val() == "0") {
        errorCount += 1;
      }

      if ($('#MulaiJam').val() == "") {
        errorCount += 1;
      }

      if ($('#SelesaiJam').val() == "") {
        errorCount += 1;
      }

      if (errorCount > 0) {
        // $('#bt_save').
        $('#btn_Save').prop('disabled', true);
      }
      else{
        $('#btn_Save').prop('disabled', false);
      }
    }
  });
</script>