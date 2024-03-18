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
            // var_dump($header);
              if ($header) {
                echo "<h2>Edit Jadwal Pelayanan</h2>";
                echo "<input type='hidden' id='formtype' value = 'edit'>";
                echo '<textarea  id="headerData" style ="display:none;">'.json_encode($header).'</textarea>';
              }
              else{
                echo "<h2>Tambah Jadwal Pelayanan</h2>";
                echo "<input type='hidden' id='formtype' value = 'add'>";
                echo '<textarea  id="headerData" style ="display:none;"></textarea>';
              }
            ?>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="item form-group">
                    <label class="col-form-label col-md-2 col-sm-2" for="first-name">No. Register <span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 ">
                      <input type="text" name="NoTransaksi" id="NoTransaksi" required="" placeholder="<AUTO>" readonly="" class="form-control" value = "<?php echo ($header) ? $header[0]->NoTransaksi : '' ?>">
                      <input type="hidden" name="formtype" id="formtype" value="add">
                    </div>

                    <label class="col-form-label col-md-2 col-sm-2" for="first-name">Tanggal <span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 ">
                      <input type="date" name="TglTransaksi" id="TglTransaksi" required="" class="form-control " value = "<?php echo ($header) ? $header[0]->TglTransaksi : '' ?>">
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
                            if ($key->id == $header[0]->CabangID) {
                              echo "<option value = '".$key->id."' selected>".$key->CabangName."</option>";
                            }
                            else{
                              echo "<option value = '".$key->id."' >".$key->CabangName."</option>";
                            }
                          }
                        ?>
                      </select>
                    </div>

                    <label class="col-form-label col-md-2 col-sm-2" for="first-name">Jenis Ibadah <span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 ">
                      <select class="form-control col-md-6" id="JenisTransaksi" name="JenisTransaksi" >
                        <option value="0">Pilih Jenis Ibadah</option>
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

                  <div class="item form-group">
                    <label class="col-form-label col-md-2 col-sm-2" for="first-name">PIC Kegiatan <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <select class="form-control col-md-6" id="PICKegiatan" name="PICKegiatan" >
                        <option value="0">Pilih PIC Kegiatan</option>
                      </select>
                    </div>
                  </div>

                </div>
                <label></label>
              </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-sm-12">
        <div class="x_panel">
          <div class="x_title">
            <div class="col-md-12 col-sm-12">
              <h2>Petugas Pelayanan</h2><br>
            </div>
            <div class="col-md-12 col-sm-12">
              <button class="btn btn-primary" id="btn_add_pelayan" disabled="">Tambah Pelayan</button>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table class="table table-hover" id="PelayanTable">
              <thead>
                <tr>
                  <th>Divisi</th>
                  <th>Jabatan</th>
                  <th>Cabang</th>
                  <th>Personil</th>
                  <!-- <th>Action</th> -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <!-- <td></td> -->
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-sm-12">
        <h2></h2>
        <button class="btn btn-primary" id="btn_save">Simpan</button>
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
          <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Personel <span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 ">
            <select class="form-control col-md-6" id="NIK" name="NIK" >
              <option value="0">Pilih Personel</option>
            </select>
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
  document.addEventListener('DOMContentLoaded',function () {
    
  });
  $(function () {
    var CabangID = "<?php echo $CabangID; ?>";
    var jsonObject = [];
    var detailObject = [];

    var CabangFill = [];
    var DepartementFill = [];
    var JabatanFill = [];
    var PersonelFill = [];

    var hakUbahCabang = false;
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

      $('#DivisiID').select2({
        width: '100%'
      });

      $('#JabatanID').select2({
        width: '100%'
      });

      $('#NIK').select2({
        width: '100%'
      });

      $('#PICKegiatan').select2({
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

      // edit mode
      if ($('#headerData').val() != "") {
        var headerData = $.parseJSON($('#headerData').val());
        // console.log(headerData);
        if (headerData.length > 0) {
          $('#TglTransaksi').val(headerData[0].TglTransaksi);
          $('#CabangID').val(headerData[0].CabangID).trigger('change');
          $('#JenisTransaksi').val(headerData[0].JenisTransaksi).trigger('change');
          $('#JadwalIbadahID').val(headerData[0].JadwalIbadahID).trigger('change');
          $('#EventID').val(headerData[0].EventID).trigger('change');
          $('#NamaJadwal').val(headerData[0].NamaJadwal);
          $('#DeskripsiJadwal').val(headerData[0].DeskripsiJadwal);
          $('#PICKegiatan').val(headerData[0].PICKegiatan).trigger('change');

          $.ajax({
            async:false,
            type: "post",
            url: "<?=base_url()?>JadwalPelayananController/ReadDetail",
            data: {'NoTransaksi':$('#NoTransaksi').val(), 'CabangID': $('#CabangID').val() },
            dataType: "json",
            success: function (response) {
              console.log(response)
              if (response.success == true) {
                $.each(response.data,function (k,v) {
                  // var item = {
                  //   NIK : v.PIC,
                  //   Nama : v.NamaLengkap,
                  //   DivisiID : v.DivisiID,
                  //   NamaDivisi : v.NamaDivisi,
                  //   JabatanID : v.JabatanID,
                  //   NamaJabatan : v.NamaJabatan,
                  //   NoHP : v.NoHP,
                  //   Email : v.Email
                  // }
                  // jsonObject.push(item);
                  var table = document.getElementById('PelayanTable');
                  var xrow = table.rows.length -1;
                  var idText = generateRandomText(5)

                  var newRow = document.createElement('tr');

                  var cell1 = document.createElement('td');
                  newRow.appendChild(cell1);

                  var cell2 = document.createElement('td');
                  newRow.appendChild(cell2);

                  var cell3 = document.createElement('td');
                  newRow.appendChild(cell3);

                  var cell4 = document.createElement('td');
                  newRow.appendChild(cell4);

                  table.appendChild(newRow);

                  var selectDivisi = document.createElement('select');
                  var selectJabatan = document.createElement('select');
                  var selectCabang = document.createElement('select');
                  var selectPersonil = document.createElement('select');

                  selectDivisi.id = 'divisi'+idText;
                  selectJabatan.id = 'jabatan'+idText;
                  selectCabang.id = 'cabang'+idText;
                  selectPersonil.id = 'personel'+idText;

                  var item = {
                    ID : idText,
                    PIC : v.PIC
                  }

                  detailObject.push(item);
                  // Divisi
                  for (var i = 0; i < DepartementFill.length; i++) {
                    // Things[i]
                    var option = document.createElement('option');
                    option.value = DepartementFill[i]['id']; // Set option value
                    option.text = DepartementFill[i]['NamaDivisi']; // Set option text
                    selectDivisi.appendChild(option);
                  }

                  var row = table.rows[xrow];
                  var cell = row.cells[0];
                  cell.appendChild(selectDivisi);

                  $('#divisi'+idText).val(v.DivisiID);
                  $('#divisi'+idText).prop('disabled', true);
                  $('#divisi'+idText).select2({
                    width: '100%'
                  });
                  // Divisi

                  // Jabatan

                  for (var i = 0; i < JabatanFill.length; i++) {
                    // Things[i]
                    var option = document.createElement('option');
                    option.value = JabatanFill[i]['id']; // Set option value
                    option.text = JabatanFill[i]['NamaJabatan']; // Set option text
                    selectJabatan.appendChild(option);
                  }
                  var rowjabatan = table.rows[xrow];
                  var celljabatan = rowjabatan.cells[1];
                  celljabatan.appendChild(selectJabatan);

                  $('#jabatan'+idText).val(v.JabatanID);
                  $('#jabatan'+idText).prop('disabled', true);
                  $('#jabatan'+idText).select2({
                    width: '100%'
                  });
                  // Jabatan

                  // Cabang
                  var sourceSelect = document.getElementById('CabangID');

                  for (var i = 0; i < sourceSelect.options.length; i++) {

                      var option = sourceSelect.options[i];
                      var newOption = document.createElement('option');
                      newOption.value = option.value;
                      newOption.textContent = option.textContent;
                      selectCabang.appendChild(newOption);
                  }

                  var rowcabang = table.rows[xrow];
                  var cellcabang = rowcabang.cells[2];
                  cellcabang.appendChild(selectCabang);

                  $('#cabang'+idText).val(v.CabangID).trigger('change');
                  $('#cabang'+idText).prop('disabled', !hakUbahCabang);
                  $('#cabang'+idText).select2({
                    width: '70%'
                  });
                  // Cabang

                  $.ajax({
                    async :false,
                    type: "post",
                    url: "<?=base_url()?>PersonelController/Read",
                    data: {
                      'NIK':'',
                      'CabangID':$('#cabang'+idText).val(),
                      'DivisiID': $('#divisi'+idText).val(),
                      'JabatanID':$('jabatan'+idText).val()
                    },
                    dataType: "json",
                    success: function (xResponse) {
                      // console.log(response);
                      for (var i = 0; i < xResponse.data.length; i++) {
                        // Things[i]
                        // console.log(xResponse.data[i]['Nama'])
                        var option = document.createElement('option');
                        option.value = xResponse.data[i]['NIK']; // Set option value
                        option.text = xResponse.data[i]['Nama']; // Set option text
                        selectPersonil.appendChild(option);
                      }
                    }
                  });

                  var rowpersonel = table.rows[xrow];
                  var cellpersonel = rowpersonel.cells[3];
                  cellpersonel.appendChild(selectPersonil);
                  // console.log(xrow)

                  var personelcode = $('#NIK').val();
                  // console.log(v.PIC)

                  // $('#personel'+v.id).prop('disabled', true);
                  $('#personel'+idText).val(v.PIC).trigger('change');
                  // var PersonelElement = document.getElementById('personel'+idText);
                  // PersonelElement.value = v.PIC;
                  $('#personel'+idText).select2({
                    width: '100%'
                  });
                });

                
                // console.log(jsonObject)
                // bindGridPersonel(jsonObject);
                console.log(detailObject);
                $('#btn_add_pelayan').prop('disabled', false);

                // for (var i = 0; i < detailObject.length; i++) {
                //   // Things[i]
                //   console.log(detailObject[i]['ID'])
                //   $('#personel'+detailObject[i]['ID']).val(detailObject[i]['PIC']).trigger('change');
                // }
              }
            }
          });

        }
      }
      else{
        bindGridPersonel([]);
      }

    });
    $('#btn_Select').click(function () {
        // var dataGridInstance = $('#gridContainerLookup').dxDataGrid('instance');
        // var selectedRowsData = dataGridInstance.getSelectedRowsData();
        // AppendItem(selectedRowsData);

        var table = document.getElementById('PelayanTable');
        var xrow = table.rows.length -1;
        var idText = generateRandomText(5)

        var newRow = document.createElement('tr');

        var cell1 = document.createElement('td');
        newRow.appendChild(cell1);

        var cell2 = document.createElement('td');
        newRow.appendChild(cell2);

        var cell3 = document.createElement('td');
        newRow.appendChild(cell3);

        var cell4 = document.createElement('td');
        newRow.appendChild(cell4);

        table.appendChild(newRow);

        var selectDivisi = document.createElement('select');
        var selectJabatan = document.createElement('select');
        var selectCabang = document.createElement('select');
        var selectPersonil = document.createElement('select');

        selectDivisi.id = 'divisi'+idText;
        selectJabatan.id = 'jabatan'+idText;
        selectCabang.id = 'cabang'+idText;
        selectPersonil.id = 'personel'+idText;

        var item = {
          ID : idText
        }

        detailObject.push(item);
        // Divisi
        for (var i = 0; i < DepartementFill.length; i++) {
          // Things[i]
          var option = document.createElement('option');
          option.value = DepartementFill[i]['id']; // Set option value
          option.text = DepartementFill[i]['NamaDivisi']; // Set option text
          selectDivisi.appendChild(option);
        }

        var row = table.rows[xrow];
        var cell = row.cells[0];
        cell.appendChild(selectDivisi);

        $('#divisi'+idText).val($('#DivisiID').val());
        $('#divisi'+idText).prop('disabled', true);
        $('#divisi'+idText).select2({
          width: '100%'
        });
        // Divisi

        // Jabatan

        for (var i = 0; i < JabatanFill.length; i++) {
          // Things[i]
          var option = document.createElement('option');
          option.value = JabatanFill[i]['id']; // Set option value
          option.text = JabatanFill[i]['NamaJabatan']; // Set option text
          selectJabatan.appendChild(option);
        }
        var rowjabatan = table.rows[xrow];
        var celljabatan = rowjabatan.cells[1];
        celljabatan.appendChild(selectJabatan);

        $('#jabatan'+idText).val($('#JabatanID').val());
        $('#jabatan'+idText).prop('disabled', true);
        $('#jabatan'+idText).select2({
          width: '100%'
        });
        // Jabatan

        // Cabang
        var sourceSelect = document.getElementById('CabangID');

        for (var i = 0; i < sourceSelect.options.length; i++) {

            var option = sourceSelect.options[i];
            var newOption = document.createElement('option');
            newOption.value = option.value;
            newOption.textContent = option.textContent;
            selectCabang.appendChild(newOption);
        }

        var rowcabang = table.rows[xrow];
        var cellcabang = rowcabang.cells[2];
        cellcabang.appendChild(selectCabang);

        $('#cabang'+idText).val($('#CabangID').val()).trigger('change');
        $('#cabang'+idText).prop('disabled', !hakUbahCabang);
        $('#cabang'+idText).select2({
          width: '70%'
        });
        // Cabang

        $.ajax({
          type: "post",
          url: "<?=base_url()?>PersonelController/Read",
          data: {
            'NIK':'',
            'CabangID':$('#cabang'+idText).val(),
            'DivisiID': $('#divisi'+idText).val(),
            'JabatanID':$('jabatan'+idText).val()
          },
          dataType: "json",
          success: function (xResponse) {
            // console.log(response);
            for (var i = 0; i < xResponse.data.length; i++) {
              // Things[i]
              // console.log(xResponse.data[i]['Nama'])
              var option = document.createElement('option');
              option.value = xResponse.data[i]['NIK']; // Set option value
              option.text = xResponse.data[i]['Nama']; // Set option text
              selectPersonil.appendChild(option);
            }
          }
        });

        var rowpersonel = table.rows[xrow];
        var cellpersonel = rowpersonel.cells[3];
        cellpersonel.appendChild(selectPersonil);
        // console.log(xrow)

        var personelcode = $('#NIK').val();
        console.log(personelcode)

        // $('#personel'+v.id).prop('disabled', true);
        $('#personel'+idText).val($('#NIK').val()).trigger('change');
        $('#personel'+idText).select2({
          width: '100%'
        });
        // $('#personel'+idText).val(personelcode).trigger('change');

        $('#modal_').modal('toggle');
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
        data: {'TglAwal':$('#TglTransaksi').val(),'TglAkhir':'2999-01-01', 'CabangIDFilter': $('#CabangID').val(),'JenisEventIDFilter':'0' },
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

      // Departement
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>DivisiController/Read",
        data: {'id':'', 'CabangID': $('#CabangID').val() },
        dataType: "json",
        success: function (response) {
          DepartementFill = response.data;

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

      // Jabatan
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>JabatanController/Read",
        data: {'DivisiID':'', 'CabangID': $('#CabangID').val() },
        dataType: "json",
        success: function (response) {
          JabatanFill = response.data;
        }
      });

      // Personil
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>PersonelController/Read",
        data: {'NIK':'', 'CabangID': $('#CabangID').val() },
        dataType: "json",
        success: function (response) {
          PersonelFill = response.data;
          $('#NIK').empty();
          var newOption = $('<option>', {
            value: -1,
            text: "Pilih Personel"
          });

          $('#NIK').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.NIK,
              text: v.Nama
            });

            $('#NIK').append(newOption);
          });


          //  PIC Kegiatan

          $('#PICKegiatan').empty();
          var newOption = $('<option>', {
            value: -1,
            text: "Pilih Personel"
          });

          $('#PICKegiatan').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.NIK,
              text: v.Nama
            });

            $('#PICKegiatan').append(newOption);
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

    $('#btn_save').click(function () {
      $('#btn_save').text('Tunggu Sebentar.....');
      $('#btn_save').attr('disabled',true);

      for (var i = 0; i < detailObject.length; i++) {
        var selectPersonel = document.getElementById('personel'+detailObject[i]['ID']);
        var selectCabang = document.getElementById('cabang'+detailObject[i]['ID']);
        var selectJabatan = document.getElementById('jabatan'+detailObject[i]['ID']);
        var selectDivisi = document.getElementById('divisi'+detailObject[i]['ID']);

        var personelOption = selectPersonel.options[selectPersonel.selectedIndex];
        var cabangOption = selectCabang.options[selectCabang.selectedIndex];
        var jabatanOption = selectJabatan.options[selectJabatan.selectedIndex];
        var divisiOption = selectDivisi.options[selectDivisi.selectedIndex];

        var personelText = personelOption.text;
        var cabangText = cabangOption.text;
        var jabatanText = jabatanOption.text;
        var divisiText = divisiOption.text;

        var item = {
          NIK : $('#personel'+detailObject[i]['ID']).val(),
          Nama : personelText,
          DivisiID : $('#divisi'+detailObject[i]['ID']).val(),
          NamaDivisi : divisiText,
          JabatanID : $('#jabatan'+detailObject[i]['ID']).val(),
          NamaJabatan : jabatanText,
          NoHP : '',
          Email : ''
        }
        jsonObject.push(item);
      }

      var dataParam = {
          'NoTransaksi' : $('#NoTransaksi').val(),
          'TglTransaksi' : $('#TglTransaksi').val(),
          'CabangID' : $('#CabangID').val(),
          'JenisTransaksi' : $('#JenisTransaksi').val(),
          'JadwalIbadahID' : $('#JadwalIbadahID').val(),
          'EventID' : $('#EventID').val(),
          'NamaJadwal' : $('#NamaJadwal').val(),
          'DeskripsiJadwal' : $('#DeskripsiJadwal').val(),
          'PICKegiatan' : $('#PICKegiatan').val(),
          'formtype' : $('#formtype').val(),
          'detail' : jsonObject
      };
      console.log(dataParam);

      $.ajax({
          url: "<?=base_url()?>JadwalPelayananController/CRUD",
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
                    window.location.href = '<?=base_url()?>pelayanan/jadwal';
                  });
              }
              else{
                  Swal.fire({
                    icon: "error",
                    title: "Opps...",
                    text: response.message,
                  });
                  $('#btn_save').text('Save');
                  $('#btn_save').attr('disabled',false);
              }
          },
          error: function(xhr, status, error) {
              // Handle errors
              console.error('Error:', error);
          }
      });
    });

    $('#btn_add_pelayan').click(function () {
      $('#modal_').modal('show');
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
    $('#JadwalIbadahID').change(function() {
      // console.log(CabangFill);
      // console.log(DepartementFill);
      // console.log(JabatanFill);
      // var detailObject = [];
      if ($('#headerData').val() == "") {
        console.log($('#JadwalIbadahID').val());
        if ($('#JadwalIbadahID').val() != "") {
          $('#btn_add_pelayan').prop('disabled', false);
        }
        $.ajax({
          type: "post",
          url: "<?=base_url()?>TemplatePetugasController/find",
          data: {'CabangID':$('#CabangID').val(),'BaseReff':$('#JadwalIbadahID').val(),'BaseType':'JADWALIBADAH'},
          dataType: "json",
          success: function (response) {
            // console.log(response)
            // elementContainer
            var xrow = 1;
            var table = document.getElementById('PelayanTable');
            $.each(response.data,function (k,v) {
              var idText = generateRandomText(5)

              var selectDivisi = document.createElement('select');
              var selectJabatan = document.createElement('select');
              var selectCabang = document.createElement('select');
              var selectPersonil = document.createElement('select');

              selectDivisi.id = 'divisi'+idText;
              selectJabatan.id = 'jabatan'+idText;
              selectCabang.id = 'cabang'+idText;
              selectPersonil.id = 'personel'+idText;

              var item = {
                ID : idText
              }

              detailObject.push(item);
              // Divisi
              for (var i = 0; i < DepartementFill.length; i++) {
                // Things[i]
                var option = document.createElement('option');
                option.value = DepartementFill[i]['id']; // Set option value
                option.text = DepartementFill[i]['NamaDivisi']; // Set option text
                selectDivisi.appendChild(option);
              }

              var newRow = document.createElement('tr');

              var cell1 = document.createElement('td');
              newRow.appendChild(cell1);

              var cell2 = document.createElement('td');
              newRow.appendChild(cell2);

              var cell3 = document.createElement('td');
              newRow.appendChild(cell3);

              var cell4 = document.createElement('td');
              newRow.appendChild(cell4);

              // var cell5 = document.createElement('td');
              // newRow.appendChild(cell5);

              table.appendChild(newRow);

              var row = table.rows[xrow];
              var cell = row.cells[0];
              cell.appendChild(selectDivisi);

              $('#divisi'+idText).val(v.DivisiID);
              $('#divisi'+idText).prop('disabled', true);
              $('#divisi'+idText).select2({
                width: '100%'
              });
              // Divisi

              // Jabatan

              for (var i = 0; i < JabatanFill.length; i++) {
                // Things[i]
                var option = document.createElement('option');
                option.value = JabatanFill[i]['id']; // Set option value
                option.text = JabatanFill[i]['NamaJabatan']; // Set option text
                selectJabatan.appendChild(option);
              }
              var rowjabatan = table.rows[xrow];
              var celljabatan = rowjabatan.cells[1];
              celljabatan.appendChild(selectJabatan);

              $('#jabatan'+idText).val(v.JabatanID);
              $('#jabatan'+idText).prop('disabled', true);
              $('#jabatan'+idText).select2({
                width: '100%'
              });
              // Jabatan

              // Cabang
              var sourceSelect = document.getElementById('CabangID');

              for (var i = 0; i < sourceSelect.options.length; i++) {

                  var option = sourceSelect.options[i];
                  var newOption = document.createElement('option');
                  newOption.value = option.value;
                  newOption.textContent = option.textContent;
                  selectCabang.appendChild(newOption);
              }

              var rowcabang = table.rows[xrow];
              var cellcabang = rowcabang.cells[2];
              cellcabang.appendChild(selectCabang);

              $('#cabang'+idText).val(v.CabangID).trigger('change');
              $('#cabang'+idText).prop('disabled', !hakUbahCabang);
              $('#cabang'+idText).select2({
                width: '70%'
              });
              // Cabang

              $.ajax({
                async: false,
                type: "post",
                url: "<?=base_url()?>PersonelController/Read",
                data: {
                  'NIK':'',
                  'CabangID':$('#cabang'+idText).val(),
                  'DivisiID': $('#divisi'+idText).val(),
                  'JabatanID':$('#jabatan'+idText).val()
                },
                dataType: "json",
                success: function (xResponse) {
                  // console.log(response);
                  for (var i = 0; i < xResponse.data.length; i++) {
                    // Things[i]
                    // console.log(xResponse.data[i]['Nama'])
                    var option = document.createElement('option');
                    option.value = xResponse.data[i]['NIK']; // Set option value
                    option.text = xResponse.data[i]['Nama']; // Set option text

                    if (xResponse.data[i]['selectedPersonel'] == "A") {
                      option.style.color = 'green';
                    }

                    selectPersonil.appendChild(option);
                  }
                }
              });

              var rowpersonel = table.rows[xrow];
              var cellpersonel = rowpersonel.cells[3];
              cellpersonel.appendChild(selectPersonil);
              // console.log(xrow)

              // $('#personel'+v.id).val(xResponse.data[i]['Nama']);
              // $('#personel'+v.id).prop('disabled', true);
              $('#personel'+idText).select2({
                width: '100%',
                templateSelection:function (option) {
                  // console.log(option.element.style.color)
                  // console.log('templateSelection')
                  return $('<span style="color:' + option.element.style.color + ';">' + option.text + '</span>');
                },
                templateResult:function (option) {
                  if (typeof option.element === 'undefined' ) {
                    console.log(option.element)
                  }
                  else{
                    return $('<span style="color:' + option.element.style.color + ';">' + option.text + '</span>');
                  }
                }
              });

              xrow +=1;
            })
          }
        });
        
        // console.log(jsonObject);

        // if (detailObject.length > 0) {
        //   for (var i = 0; i < detailObject.length; i++) {
        //     var comboDivisi = document.getElementById('myComboBox');
        //     var comboJabatan = document.getElementById('myComboBox');
        //     var comboCabang = document.getElementById('myComboBox');
        //     var comboCabang = document.getElementById('myComboBox');
        //   }
        // }
      }
    });

    $('#EventID').change(function() {
      // console.log(CabangFill);
      // console.log(DepartementFill);
      // console.log(JabatanFill);
      // var detailObject = [];
      if ($('#headerData').val() == "") {
        console.log($('#EventID').val());
        if ($('#EventID').val() != "") {
          $('#btn_add_pelayan').prop('disabled', false);
        }
        $.ajax({
          type: "post",
          url: "<?=base_url()?>TemplatePetugasController/find",
          data: {'CabangID':$('#CabangID').val(),'BaseReff':$('#EventID').val(),'BaseType':'EVENT'},
          dataType: "json",
          success: function (response) {
            // console.log(response)
            // elementContainer
            var xrow = 1;
            var table = document.getElementById('PelayanTable');
            $.each(response.data,function (k,v) {
              var idText = generateRandomText(5)

              var selectDivisi = document.createElement('select');
              var selectJabatan = document.createElement('select');
              var selectCabang = document.createElement('select');
              var selectPersonil = document.createElement('select');

              selectDivisi.id = 'divisi'+idText;
              selectJabatan.id = 'jabatan'+idText;
              selectCabang.id = 'cabang'+idText;
              selectPersonil.id = 'personel'+idText;

              var item = {
                ID : idText
              }

              detailObject.push(item);
              // Divisi
              for (var i = 0; i < DepartementFill.length; i++) {
                // Things[i]
                var option = document.createElement('option');
                option.value = DepartementFill[i]['id']; // Set option value
                option.text = DepartementFill[i]['NamaDivisi']; // Set option text
                selectDivisi.appendChild(option);
              }

              var newRow = document.createElement('tr');

              var cell1 = document.createElement('td');
              newRow.appendChild(cell1);

              var cell2 = document.createElement('td');
              newRow.appendChild(cell2);

              var cell3 = document.createElement('td');
              newRow.appendChild(cell3);

              var cell4 = document.createElement('td');
              newRow.appendChild(cell4);

              // var cell5 = document.createElement('td');
              // newRow.appendChild(cell5);

              table.appendChild(newRow);

              var row = table.rows[xrow];
              var cell = row.cells[0];
              cell.appendChild(selectDivisi);

              $('#divisi'+idText).val(v.DivisiID);
              $('#divisi'+idText).prop('disabled', true);
              $('#divisi'+idText).select2({
                width: '100%'
              });
              // Divisi

              // Jabatan

              for (var i = 0; i < JabatanFill.length; i++) {
                // Things[i]
                var option = document.createElement('option');
                option.value = JabatanFill[i]['id']; // Set option value
                option.text = JabatanFill[i]['NamaJabatan']; // Set option text
                selectJabatan.appendChild(option);
              }
              var rowjabatan = table.rows[xrow];
              var celljabatan = rowjabatan.cells[1];
              celljabatan.appendChild(selectJabatan);

              $('#jabatan'+idText).val(v.JabatanID);
              $('#jabatan'+idText).prop('disabled', true);
              $('#jabatan'+idText).select2({
                width: '100%'
              });
              // Jabatan

              // Cabang
              var sourceSelect = document.getElementById('CabangID');

              for (var i = 0; i < sourceSelect.options.length; i++) {

                  var option = sourceSelect.options[i];
                  var newOption = document.createElement('option');
                  newOption.value = option.value;
                  newOption.textContent = option.textContent;
                  selectCabang.appendChild(newOption);
              }

              var rowcabang = table.rows[xrow];
              var cellcabang = rowcabang.cells[2];
              cellcabang.appendChild(selectCabang);

              $('#cabang'+idText).val(v.CabangID).trigger('change');
              $('#cabang'+idText).prop('disabled', !hakUbahCabang);
              $('#cabang'+idText).select2({
                width: '70%'
              });
              // Cabang

              $.ajax({
                async: false,
                type: "post",
                url: "<?=base_url()?>PersonelController/Read",
                data: {
                  'NIK':'',
                  'CabangID':$('#cabang'+idText).val(),
                  'DivisiID': $('#divisi'+idText).val(),
                  'JabatanID':$('#jabatan'+idText).val()
                },
                dataType: "json",
                success: function (xResponse) {
                  // console.log(response);
                  for (var i = 0; i < xResponse.data.length; i++) {
                    // Things[i]
                    // console.log(xResponse.data[i]['Nama'])
                    var option = document.createElement('option');
                    option.value = xResponse.data[i]['NIK']; // Set option value
                    option.text = xResponse.data[i]['Nama']; // Set option text

                    if (xResponse.data[i]['selectedPersonel'] == "A") {
                      option.style.color = 'green';
                    }

                    selectPersonil.appendChild(option);
                  }
                }
              });

              var rowpersonel = table.rows[xrow];
              var cellpersonel = rowpersonel.cells[3];
              cellpersonel.appendChild(selectPersonil);
              // console.log(xrow)

              // $('#personel'+v.id).val(xResponse.data[i]['Nama']);
              // $('#personel'+v.id).prop('disabled', true);
              $('#personel'+idText).select2({
                width: '100%',
                templateSelection:function (option) {
                  // console.log(option.element.style.color)
                  // console.log('templateSelection')
                  return $('<span style="color:' + option.element.style.color + ';">' + option.text + '</span>');
                },
                templateResult:function (option) {
                  if (typeof option.element === 'undefined' ) {
                    console.log(option.element)
                  }
                  else{
                    return $('<span style="color:' + option.element.style.color + ';">' + option.text + '</span>');
                  }
                }
              });

              xrow +=1;
            })
          }
        });
        
        // console.log(jsonObject);

        // if (detailObject.length > 0) {
        //   for (var i = 0; i < detailObject.length; i++) {
        //     var comboDivisi = document.getElementById('myComboBox');
        //     var comboJabatan = document.getElementById('myComboBox');
        //     var comboCabang = document.getElementById('myComboBox');
        //     var comboCabang = document.getElementById('myComboBox');
        //   }
        // }
      }
    });

    function generateRandomText(length) {
      var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      var result = '';
      for (var i = 0; i < length; i++) {
          var randomIndex = Math.floor(Math.random() * characters.length);
          result += characters.charAt(randomIndex);
      }
      return result;
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
      console.log(data);
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