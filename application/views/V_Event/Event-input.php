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
            <?php 
            // var_dump($header);
              if ($event) {
                echo "<h2>Edit Jadwal Ibadah</h2>";
                echo "<input type='hidden' id='formtype' value = 'edit'>";
                echo '<textarea  id="event" style ="display:none;">'.json_encode($event).'</textarea>';
                echo '<textarea  id="template" style ="display:none;">'.json_encode($template).'</textarea>';
              }
              else{
                echo "<h2>Tambah Jadwal Ibadah</h2>";
                echo "<input type='hidden' id='formtype' value = 'add'>";
                echo '<textarea  id="event" style ="display:none;"></textarea>';
                echo '<textarea  id="template" style ="display:none;"></textarea>';
              }
            ?>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="item form-group">
                  <label class="col-form-label col-md-2 col-sm-2" for="TglEvent">No. Reg Event <span class="required">*</span>
                  </label>
                  <div class="col-md-3 col-sm-3 ">
                    <input type="text" name="NoTransaksi" id="NoTransaksi" required="" placeholder="Nomor Register" readonly="" class="form-control ">
                  </div>

                  <label class="col-form-label col-md-2 col-sm-2" for="TglEvent">Tgl Event <span class="required">*</span>
                  </label>
                  <div class="col-md-3 col-sm-3 ">
                    <input type="date" name="TglEvent" id="TglEvent" required="" placeholder="Nomor Register Event" class="form-control ">
                  </div>
                </div>

                <div class="item form-group">
                  <label class="col-form-label col-md-2 col-sm-2" for="JamMulai">Jam Mulai <span class="required">*</span>
                  </label>
                  <div class="col-md-3 col-sm-3 ">
                    <input type="time" name="JamMulai" id="JamMulai" required="" placeholder="Nomor Register" class="form-control ">
                  </div>

                  <label class="col-form-label col-md-2 col-sm-2" for="JamSelesai">Jam Selesai <span class="required">*</span>
                  </label>
                  <div class="col-md-3 col-sm-3 ">
                    <input type="time" name="JamSelesai" id="JamSelesai" required="" placeholder="Nomor Register Event" class="form-control ">
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

      $('#JenisEventID').select2({
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

      var now = new Date();
      var day = ("0" + now.getDate()).slice(-2);
      var month = ("0" + (now.getMonth() + 1)).slice(-2);
      var today = now.getFullYear()+"-"+month+"-01";
      var lastDayofYear = now.getFullYear()+"-"+month+"-"+day;

      $('#TglEvent').val(lastDayofYear);

      if ($('#event').val() != ""){
        var event = $.parseJSON($('#event').val());
        // console.log(jadwalibadah)
        $('#NoTransaksi').val(event[0]['NoTransaksi']);
        $('#TglEvent').val(event[0]['TglEvent']);
        $('#NamaEvent').val(event[0]['NamaEvent']);
        $('#CabangID').val(event[0]['CabangID']).trigger('change');
        $('#JenisEventID').val(event[0]['JenisEventID']).trigger('change');
        $('#LokasiEvent').val(event[0]['LokasiEvent']);
        $('#AlamatEvent').val(event[0]['AlamatEvent']);
        $('#ContactPerson').val(event[0]['ContactPerson']);
        $('#NoHPContactPerson').val(event[0]['NoHPContactPerson']);
        $('#Berulang').val(event[0]['Berulang']);
        $('#IntervalBerulang').val(event[0]['IntervalBerulang']);
        $('#IntervalType').val(event[0]['IntervalType']);
        $('#Keterangan').val(event[0]['Keterangan']);
        $('#JamMulai').val(event[0]['JamMulaiFormated']);
        $('#JamSelesai').val(event[0]['JamSelesaiFormated']);

        // console.log($('#template').val())
        if ($('#template').val() != "") {
          template = $.parseJSON($('#template').val());
          // console.log(template)

          $.each(template,function (k,v) {
            var item = {
              'DivisiID' : v.DivisiID,
              'JabatanID' : v.JabatanID,
              'NamaDivisi' : v.NamaDivisi,
              'NamaJabatan' : v.NamaJabatan,
              'checked' : v.checked,
              'JumlahPelayan' : v.JumlahPelayan
            }
            jsonObject.push(item);
          })
          bindGrid(jsonObject)
        }
      }
    });

    $('#CabangID').change(function () {

      $.ajax({
        type: "post",
        url: "<?=base_url()?>JadwalIbadahController/ReadTemplate",
        data: {'CabangID':$('#CabangID').val(),'BaseType':'EVENT'},
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

      // Divisi

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
    $('#btn_Save').click(function () {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);
      var gridInstance = $("#gridContainer").dxDataGrid("instance");
      var dataSource = gridInstance.getDataSource();

      dataSource.load().done(function(data) {
          var dataParam = {
            'id' : $('#id').val(),
            'NoTransaksi' : $('#NoTransaksi').val(),
            'TglEvent' : $('#TglEvent').val(),
            'NamaEvent' : $('#NamaEvent').val(),
            'JenisEventID' : $('#JenisEventID').val(),
            'LokasiEvent' : $('#LokasiEvent').val(),
            'AlamatEvent' : $('#AlamatEvent').val(),
            'ContactPerson' : $('#ContactPerson').val(),
            'NoHPContactPerson' : $('#NoHPContactPerson').val(),
            'Berulang' : $('#Berulang').val(),
            'IntervalBerulang' : $('#IntervalBerulang').val(),
            'IntervalType' : $('#IntervalType').val(),
            'CabangID' : $('#CabangID').val(),
            'Keterangan' : $('#Keterangan').val(),
            'JamMulai' : $('#JamMulai').val(),
            'JamSelesai' : $('#JamSelesai').val(),
            'formtype': $('#formtype').val(),
            'detail' : data
        };

        // console.log(JSON.stringify(dataParam));
        $.ajax({
            url: "<?=base_url()?>EventController/CRUDJson",
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
                      window.location.href = '<?=base_url()?>event';
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

    // $('#post_').submit(function (e) {
    //   $('#btn_Save').text('Tunggu Sebentar.....');
    //   $('#btn_Save').attr('disabled',true);
    //   $(this).find(':input:disabled').prop('disabled', false);
    //   e.preventDefault();
    //   var me = $(this);
    //   $.ajax({
    //     type    :'post',
    //     url     : '<?=base_url()?>EventController/CRUD',
    //     data    : me.serialize(),
    //     dataType: 'json',
    //     success : function (response) {
    //       if(response.success == true){
    //         $('#modal_').modal('toggle');
    //         Swal.fire({
    //           type: 'success',
    //           title: 'Horay..',
    //           text: 'Data Berhasil disimpan!',
    //           // footer: '<a href>Why do I have this issue?</a>'
    //         }).then((result)=>{
    //           location.reload();
    //         });
    //       }
    //       else{
    //         $('#modal_').modal('toggle');
    //         Swal.fire({
    //           type: 'error',
    //           title: 'Woops...',
    //           text: response.message,
    //           // footer: '<a href>Why do I have this issue?</a>'
    //         }).then((result)=>{
    //           $('#modal_').modal('show');
    //           $('#btn_Save').text('Save');
    //           $('#btn_Save').attr('disabled',false);
    //         });
    //       }
    //     }
    //   });
    // });
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
      var canAdd = "<?php echo $canAdd; ?>";
      var canEdit = "<?php echo $canEdit; ?>";
      var canDelete = "<?php echo $canDelete; ?>";

      var dataGridInstance = $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "JabatanID",
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
        };
        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }

    $('#NamaEvent').change(function () {
      setEnableCommand();
    })

    $('#CabangID').change(function () {
      setEnableCommand();
    })

    $('#JamMulai').change(function () {
      setEnableCommand();
    })

    $('#JamSelesai').change(function () {
      setEnableCommand();
    })

    $('#Deskripsi').change(function () {
      setEnableCommand();
    })

    $('#LokasiEvent').change(function () {
      setEnableCommand();
    })

    $('#AlamatEvent').change(function () {
      setEnableCommand();
    })

    $('#ContactPerson').change(function () {
      setEnableCommand();
    })

    $('#NoHPContactPerson').change(function () {
      setEnableCommand();
    })

    $('#JenisEventID').change(function () {
      setEnableCommand();
    })

    function setEnableCommand() {
      var errorCount = 0;


      if ($('#NamaEvent').val() == "") {
        errorCount += 1;
      }

      if ($('#CabangID').val() == '0') {
        errorCount += 1;
      }

      if ($('#JamMulai').val() == "") {
        errorCount += 1;
      }

      if ($('#JamSelesai').val() == "") {
        errorCount += 1;
      }

      if ($('#Deskripsi').val() == "") {
        errorCount += 1;
      }

      if ($('#LokasiEvent').val() == "") {
        errorCount += 1;
      }

      if ($('#AlamatEvent').val() == "") {
        errorCount += 1;
      }

      if ($('#ContactPerson').val() == "") {
        errorCount += 1;
      }

      if ($('#NoHPContactPerson').val() == "") {
        errorCount += 1;
      }

      if ($('#JenisEventID').val() == "-1") {
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