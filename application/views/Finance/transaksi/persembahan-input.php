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
            <h2>Input Data Laporan Persembahan</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="item form-group">
                  <label class="col-form-label col-md-2 col-sm-2" for="first-name">No. Register <span class="required">*</span>
                  </label>
                  <div class="col-md-4 col-sm-4 ">
                    <input type="text" name="NoTransaksi" id="NoTransaksi" required="" placeholder="<AUTO>" readonly="" value="" class="form-control">
                    <input type="hidden" name="formtype" id="formtype" value="add">
                  </div>

                  <label class="col-form-label col-md-2 col-sm-2" for="first-name">Tanggal <span class="required">*</span>
                  </label>
                  <div class="col-md-4 col-sm-4 ">
                    <input type="date" name="TglTransaksi" id="TglTransaksi" required="" class="form-control ">
                  </div>
                </div>
              </div>

              <div class="col-md-12 col-sm-12">
                <div class="item form-group">
                  <label class="col-form-label col-md-2 col-sm-2" for="first-name">Hari Ibadah <span class="required">*</span>
                  </label>
                  <div class="col-md-4 col-sm-4 ">
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
              </div>

              <div class="col-md-12 col-sm-12">
                <div class="item form-group">
                  <label class="col-form-label col-md-2 col-sm-2" for="first-name">Cabang <span class="required">*</span>
                  </label>
                  <div class="col-md-10 col-sm-10 ">
                    <select class="form-control" id="CabangID" name="CabangID" disabled="">
                      <option value="0">Pilih Cabang</option>
                      <?php

                        foreach ($Cabang as $key) {
                          echo "<option value = '".$key->id."'>".$key->CabangName."</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-12 col-sm-12">
                <div class="item form-group">
                  <label class="col-form-label col-md-2 col-sm-2" for="first-name">Sesi Ibadah <span class="required">*</span>
                  </label>
                  <div class="col-md-10 col-sm-10 ">
                    <select class="form-control" id="JadwalIbadahID" name="JadwalIbadahID" disabled="">
                      <option value="">Pilih Sesi Ibadah</option>
                      <?php

                        foreach ($jadwalibadah as $key) {
                          echo "<option value = '".$key->id."'>".$key->NamaIbadah."</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-12 col-sm-12">
                <div class="item form-group">
                  <label class="col-form-label col-md-2 col-sm-2" for="first-name">PIC Persembahan <span class="required">*</span>
                  </label>
                  <div class="col-md-4 col-sm-4 ">
                    <select class="form-control" id="PICPerhitungan" name="PICPerhitungan">
                      <option value="">Pilih PIC</option>
                    </select>
                  </div>

                  <label class="col-form-label col-md-2 col-sm-2" for="first-name">Akun Kas <span class="required">*</span>
                  </label>
                  <div class="col-md-4 col-sm-4 ">
                    <select class="form-control" id="KodeAkunKas" name="KodeAkunKas" >
                      <option value="">Pilih Akun</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-12 col-sm-12">
                <div class="item form-group">
                  <label class="col-form-label col-md-2 col-sm-2" for="first-name">Keterangan <span class="required">*</span>
                  </label>
                  <div class="col-md-10 col-sm-10 ">
                    <input type="text" name="Keterangan" id="Keterangan" class="form-control">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="x_panel">
          <div class="x_title">
            <h2>Realisasi PK</h2>
            <div class="clearfix"></div>
          </div>

          <div class="x_content">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="dx-viewport demo-container">
                  <div id="data-grid-demo">
                    <div id="gridContainerPersembahan">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="x_panel">
          <div class="x_title">
            <h2>Sisa Persembahan</h2>
            <div class="clearfix"></div>
          </div>

          <div class="x_content">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <table class="table table-hover" id="DenomTable">
                  <thead>
                    <tr>
                      <th>Denom</th>
                      <th>Qty</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-12 col-sm-12">
                <hr>
                <div class="item form-group">
                  <div class="col-md-4 col-sm-4 ">
                    Total Persembahan
                    <input type="text" name="0" id="PemasukanTotal" value="0" disabled="" class="form-control">
                  </div>

                  <div class="col-md-4 col-sm-4 ">
                    Pengeluaran PK
                    <input type="text" name="0" id="PengeluaranTotal" value="0" disabled="" class="form-control">
                  </div>

                  <div class="col-md-4 col-sm-4 ">
                    Saldo
                    <input type="text" name="0" id="SaldoTotal" value="0" disabled="" class="form-control">
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-sm-12">
                <hr>
                <button class="btn btn-success" id="bt_save" disabled="">Simpan Data Sisa Persembahan</button>
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
        <h4 class="modal-title" id="myModalLabel">Modal Transaksi</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Akun Kas <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <select class="form-control" id="KodeAkunKasLainLain" name="KodeAkunKasLainLain" >
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Total <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="number" name="TotalLainLain" id="TotalLainLain" required="" placeholder="Total" class="form-control ">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Keterangan <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" name="KeteranganLainLain" id="KeteranganLainLain" required="" placeholder="Keterangan" class="form-control ">
            </div>
          </div>

          <div class="item" form-group>
            <button class="btn btn-primary" id="btn_SaveLainLain" >Save</button>
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
    var objectID = [];
    var jsonObject = [];
    var ParseCabangID = "<?php echo $ParseCabangID; ?>";
    var HariIbadah = "<?php echo $HariIbadah; ?>";
    var TanggalIbadah = "<?php echo $TanggalIbadah; ?>";
    var JadwalIbadahID = "<?php echo $JadwalIbadahID; ?>";

    var pemasukanlainlainsavemode = "add";
    var tableDataSource = [];
    $(document).ready(function () {
      $('#KodeAkunKas').select2({
        width: '100%'
      });
      $('#KodeAkunKasLainLain').select2({
        width: '100%'
      });

      $('#PICPerhitungan').select2({
        width: '100%'
      });

      var now = new Date();
      var day = ("0" + now.getDate()).slice(-2);
      var month = ("0" + (now.getMonth() + 1)).slice(-2);
      var today = now.getFullYear()+"-"+month+"-01";
      var lastDayofYear = now.getFullYear()+"-"+month+"-"+day;

      $('#TglTransaksi').val(lastDayofYear);
      $('#Hari').val(HariIbadah).change();
      $('#CabangID').val(ParseCabangID).change();
      $('#JadwalIbadahID').val(JadwalIbadahID).change();

      GetPersonel();
      getAkunKas();
      console.log(CabangID);

      generateDefaultArray();
      generateTextObject();
      CalculateTotal();
      // getSavedData();
      SetEnableCommand();
      // generateDefaultArray();
    });

    function GetPersonel() {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>PersonelController/Read",
        data: {'NIK':'','CabangID': $('#CabangID').val(),'Wilayah': "0",'Provinsi' : "-1",'Kota': "",'DivisiID':"",'JabatanID':'','NIKIn': ''},
        dataType: "json",
        success: function (responsePersonel) {
          $('#PICPerhitungan').empty();
          var newOption = $('<option>', {
            value: "",
            text: "Pilih PIC Persembahan"
          });

          $('#PICPerhitungan').append(newOption); 
          $.each(responsePersonel.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.NIK,
              text: v.Nama
            });

            $('#PICPerhitungan').append(newOption);
          });
        }
      });
    }

    function generateDefaultArray() {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>PersembahanController/ReadDataPK",
        data: {
          'Tanggal' : TanggalIbadah,
          'Hari'    : $('#Hari').val(),
          'JadwalIbadahID' : $('#JadwalIbadahID').val(),
          'CabangID' : $('#CabangID').val()
        },
        dataType: "json",
        success: function (response) {
          // console.log(response);
          tableDataSource = response.data;
          bindGridHasilabsen(response.data)
        }

      });
    }

    function getSavedData() {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>PersembahanController/ReadPenerimaanUang",
        data: {'BaseReff':BaseReff, 'CabangID': CabangID,'BaseType':'JDW','isDenom':'Y' },
        dataType: "json",
        success: function (response) {
          $.each(response.data,function (z,y) {
            $('#KodeAkunKas').val(y.KodeAkunKas).trigger('change');
            $('#formtype').val('edit');
            $('#NoTransaksi').val(y.NoTransaksi);
          });
          SetEnableCommand();
        }

      });

      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>PersembahanController/ReadPenerimaanUang",
        data: {'BaseReff':BaseReff, 'CabangID': CabangID,'BaseType':'JDW','isDenom':'N' },
        dataType: "json",
        success: function (response) {
          $.each(response.data,function (z,y) {
            var item = {
              'KodeAkun' : y.KodeAkunKas,
              'NamaAkun' : y.NamaAkun,
              'Jumlah' : parseFloat(y.Jumlah),
              'Keterangan' : y.Keterangan,
              'NoTransaksi' : y.NoTransaksi
            };
            jsonObject.push(item);
            $('#formtype').val('edit');
          })
          SetEnableCommand();
        }

      });
    }

    function getAkunKas() {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>AkunKasController/Read",
        data: {'KodeAkun':'', 'CabangID': $('#CabangID').val() },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response);
          $('#KodeAkunKas').empty();
          var newOption = $('<option>', {
            value: "",
            text: "Pilih Akun"
          });

          $('#KodeAkunKas').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.KodeAkun,
              text: v.NamaAkun
            });

            $('#KodeAkunKas').append(newOption);
          });


          // 
          $('#KodeAkunKasLainLain').empty();
          var newOption = $('<option>', {
            value: "",
            text: "Pilih Akun"
          });

          $('#KodeAkunKasLainLain').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.KodeAkun,
              text: v.NamaAkun
            });

            $('#KodeAkunKasLainLain').append(newOption);
          });
        }
      });
    }

    function generateTextObject() {
      var TotalPersembahan = 0;
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>PersembahanController/ReadDenom",
        dataType: "json",
        success: function (response) {
          var table = document.getElementById('DenomTable');

          var xrow = table.rows.length -1;
          $.each(response.data,function (k,v) {
            
            var idText = generateRandomText(5)

            var newRow = document.createElement('tr');

            var cell1 = document.createElement('td');
            newRow.appendChild(cell1);

            var cell2 = document.createElement('td');
            newRow.appendChild(cell2);

            var cell3 = document.createElement('td');
            newRow.appendChild(cell3);

            table.appendChild(newRow);

            var item = {
              ID : idText,
              Denom : v.NamaDenom
            }
            objectID.push(item);

            // Denom
            var textBoxDenome = document.createElement('input');
            textBoxDenome.type = 'text';
            textBoxDenome.id = 'den'+idText;
            textBoxDenome.name = v.NamaDenom;
            textBoxDenome.value = parseInt(v.NamaDenom).toLocaleString('en-US');
            textBoxDenome.classList.add('form-control');
            textBoxDenome.readOnly = true;
            textBoxDenome.tabIndex = 999;
            // console.log(v.NamaDenom.toLocaleString('en-US', { style: 'decimal' }));

            var row = table.rows[xrow];
            var cell = row.cells[0];
            cell.appendChild(textBoxDenome);

            // Qty
            var textBoxQty = document.createElement('input');
            textBoxQty.type = 'text';
            textBoxQty.id = 'qty'+idText;
            textBoxQty.name = 'qty'+idText;
            textBoxQty.value = 0;
            textBoxQty.classList.add('form-control');
            textBoxQty.tabIndex = xrow;
            // textBoxQty.style.width = "50%";

            // console.log(v.NamaDenom.toLocaleString('en-US', { style: 'decimal' }));

            var rowQty = table.rows[xrow];
            var cellQty = rowQty.cells[1];
            cellQty.appendChild(textBoxQty);

            
            // Total
            var textBoxTotal = document.createElement('input');
            textBoxTotal.type = 'text';
            textBoxTotal.id = 'Tot'+idText;
            // textBoxTotal.name = 'Tot'+idText;
            textBoxTotal.name = 0;
            textBoxTotal.value = 0;
            textBoxTotal.classList.add('form-control');
            textBoxTotal.readOnly = true;
            textBoxTotal.tabIndex = 999;

            // console.log(v.NamaDenom.toLocaleString('en-US', { style: 'decimal' }));

            var rowTotal = table.rows[xrow];
            var cellTotal = rowTotal.cells[2];
            cellTotal.appendChild(textBoxTotal);

            // Get Saved Data
            $.ajax({
              async:false,
              type: "post",
              url: "<?=base_url()?>PersembahanController/ReadPenerimaanUang",
              data: {'TglIbadah':TanggalIbadah, 'CabangID': ParseCabangID,'JadwalIbadahID':JadwalIbadahID,'Hari':HariIbadah },
              dataType: "json",
              success: function (responsedata) {
                console.log(responsedata.data[0].NoTransaksi);
                if (responsedata.data.length > 0) {
                  $('#NoTransaksi').val(responsedata.data[0].TRX);
                  $('#TglTransaksi').val(responsedata.data[0].TglTransaksi);
                  $('#PICPerhitungan').val(responsedata.data[0].PICHeader).trigger('change');
                  $('#KodeAkunKas').val(responsedata.data[0].KodeAkun).trigger('change');
                  $('#KodeAkunKas').prop('disabled', true);
                  $('#formtype').val('edit');
                  $.each(responsedata.data,function (z,y) {
                    console.log(v.KodeDenom + ".00 >> " + y.Denominasi)
                    if (v.KodeDenom+".00" == y.Denominasi) {
                      // $('#qty'+y.ID).val(v.Qty);
                      textBoxQty.value = y.Qty;
                      textBoxTotal.value = (y.Qty * parseInt(y.Denominasi)).toLocaleString('en-US')
                      textBoxTotal.name = y.Qty * parseInt(y.Denominasi);
                      TotalPersembahan += (y.Qty * parseInt(y.Denominasi));
                      // console.log('masuk')
                    }
                  })
                }

              }

            });

            // Add event
            textBoxQty.addEventListener('change',handleTextBoxChange);

            xrow +=1;
          });

          var newRow = document.createElement('tr');

          var cell1 = document.createElement('td');
          newRow.appendChild(cell1);

          var cell2 = document.createElement('td');
          cell2.id = "xTotal";
          // cell2.colSpan = 2;
          newRow.appendChild(cell2);

          var cell3 = document.createElement('td');
          newRow.appendChild(cell3);

          table.appendChild(newRow);

          var xTotalCell = document.getElementById('xTotal');
          xTotalCell.colSpan = 2;
          // Total Value
          var textBoxValueTotal = document.createElement('input');
          textBoxValueTotal.type = 'text';
          textBoxValueTotal.id = 'TotalValue';
          textBoxValueTotal.name = TotalPersembahan;
          textBoxValueTotal.value = TotalPersembahan.toLocaleString('en-US');
          textBoxValueTotal.classList.add('form-control');
          textBoxValueTotal.readOnly = true;

          // console.log(v.NamaDenom.toLocaleString('en-US', { style: 'decimal' }));

          var rowValueTotal = table.rows[xrow +1];
          var cellValueTotal = rowValueTotal.cells[1];
          cellValueTotal.appendChild(textBoxValueTotal);

          // Text

          var textNode = document.createTextNode("Total :");
          var rowText = table.rows[xrow +1];
          var cellText = rowText.cells[0];
          cellText.appendChild(textNode);
        }
      });
    }

    function handleTextBoxChange(event) {
      var textBox = event.target;
      var randomID = textBox.id.substring(3,textBox.id.length);
      var denom = $('#den'+randomID).attr('name');
      // console.log(textBox);

      if ($('#qty'+randomID).val() == "") {
        $('#qty'+randomID).val(0)
      }
      var TotaltextBox = document.getElementById('Tot' +randomID);
      TotaltextBox.name = parseInt(denom) * parseInt($('#qty'+randomID).val())
      TotaltextBox.value = (parseInt(denom) * parseInt($('#qty'+randomID).val())).toLocaleString('en-US');

      // console.log('Textbox ID:', textBox.id + " " + denom);
      var TotalValue =0;
      for (var i = 0; i < objectID.length; i++) {
        // Things[i]
        // console.log(objectID[i]['ID']);
        // if (true) {}
        if (true) {}
        TotalValue += (isNaN(parseInt($('#Tot'+objectID[i]['ID']).attr('name')))) ? 0 : parseInt($('#Tot'+objectID[i]['ID']).attr('name'));

        console.log(parseInt($('#Tot'+objectID[i]['ID']).attr('name')))
      }

      var ValueTotalTextBox = document.getElementById('TotalValue');
      ValueTotalTextBox.name = TotalValue;
      ValueTotalTextBox.value = TotalValue.toLocaleString('en-US');

      CalculateTotal()
      SetEnableCommand();
    }

    function generateRandomText(length) {
      var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      var result = '';
      for (var i = 0; i < length; i++) {
          var randomIndex = Math.floor(Math.random() * characters.length);
          result += characters.charAt(randomIndex);
      }
      return result;
    }

    function CalculateTotal() {
      var dataGridInstance = $('#gridContainerPersembahan').dxDataGrid('instance');
      var allRowsData  = dataGridInstance.getDataSource().items();

      var totalPK = 0;
      var TotalPersembahan = 0;

      // console.log(tableDataSource)
      // PK
      for (var i = 0; i < tableDataSource.length; i++) {
        totalPK += parseFloat(tableDataSource[i]['Rate']);
      }

      TotalPersembahan += totalPK;
      // Persembahan

      for (var i = 0; i < objectID.length; i++) {
        TotalPersembahan += parseInt($('#Tot'+objectID[i]['ID']).attr('name'))

      }

      // Show Data

      var PengeluaranTotal = document.getElementById('PengeluaranTotal');
      var PemasukanTotal = document.getElementById('PemasukanTotal');
      var SaldoTotal = document.getElementById('SaldoTotal');

      console.log(totalPK)

      PengeluaranTotal.name = totalPK;
      PengeluaranTotal.value = totalPK.toLocaleString('en-US');

      PemasukanTotal.name = TotalPersembahan;
      PemasukanTotal.value = TotalPersembahan.toLocaleString('en-US');

      SaldoTotal.name = TotalPersembahan - totalPK;
      SaldoTotal.value = (TotalPersembahan - totalPK).toLocaleString('en-US');
    }

    $('#btn_SaveLainLain').click(function () {
      var dataGridInstance = $('#gridContainer').dxDataGrid('instance');
      var allRowsData  = dataGridInstance.getDataSource().items();

      var selectAkun = document.getElementById('KodeAkunKasLainLain');
      var AkunOption = selectAkun.options[selectAkun.selectedIndex];
      var temp = [];
      var item = {
        'KodeAkun' : $('#KodeAkunKasLainLain').val(),
        'NamaAkun' : AkunOption.text,
        'Jumlah' : parseFloat($('#TotalLainLain').val()),
        'Keterangan' : $('#KeteranganLainLain').val(),
        'NoTransaksi' : ''
      };
      temp.push(item);

      if (pemasukanlainlainsavemode == "add") {
        jsonObject.push(item);
        bindGrid(jsonObject);
        $('#modal_').modal('toggle');
      }
      else{
        editItem(temp);
        $('#modal_').modal('toggle');
      }
    });

    function cekDuplicate(griddata, newValue) {
      var itemCount = 0;
      var duplicate = false;
      for (var i = 0 ; i < griddata.length; i++) {
          if (griddata[i].KodeAkun == newValue) {
              itemCount += 1;
          }
      }

      if (itemCount > 0) {
          duplicate = true;
      }
      return duplicate;
    }

    function editItem(newData) {
        var itemIndex = -1;
        // console.log(jsonObject[0]['KodeAkun'])
        for (var i = 0; i < jsonObject.length; i++) {
            // console.log(jsonObject[i]['KodeAkun'])
            if (jsonObject[i]['KodeAkun'] == newData[0]['KodeAkun']) {
                itemIndex = i;
                // console.log(i)
            }
        }

        jsonObject.splice(itemIndex,1);
        // var SubTotal = newData.Qty * newData.Harga;
        // newData.LineTotal = SubTotal - (newData.Diskon / 100 * SubTotal)
        jsonObject.push(newData[0]);
        // console.log(newData)
        bindGrid(jsonObject);
        // SetEnableCommand();
    }

    $('#KodeAkunKas').change(function () {
      SetEnableCommand();
    })

    $('#PICPerhitungan').change(function () {
      SetEnableCommand();
    })

    function SetEnableCommand() {
      var errorCount = 0;

      if ($('#KodeAkunKas').val() == "") {
        errorCount +=1;
      }

      if ($('#PICPerhitungan').val() == "") {
        errorCount +=1;
      }

      if (errorCount > 0) {
        // $('#bt_save').
        $('#bt_save').prop('disabled', true);
      }
      else{
        $('#bt_save').prop('disabled', false);
      }

    }

    $('#bt_save').click(function () {
      $('#bt_save').text('Tunggu Sebentar.....');
      $('#bt_save').attr('disabled',true);

      var objectPK = [];
      var objectPersembahan = [];

      var dataGridInstance = $('#gridContainerPersembahan').dxDataGrid('instance');
      var allRowsData  = dataGridInstance.getDataSource().items();

      for (var i = 0; i < allRowsData.length; i++) {

        if (parseFloat(allRowsData[i]['Rate']) > 0) {
          var item = {
            'DivisiID'  : allRowsData[i]['DivisiID'],
            'NIK'       : allRowsData[i]['NIK'],
            'RatePKID'  : allRowsData[i]['RatePKID'],
            'Rate'      : parseFloat(allRowsData[i]['Rate'])
          }
          objectPK.push(item);
        }
      }

      for (var i = 0; i < objectID.length; i++) {
        // Things[i]
        if (parseFloat($('#qty'+objectID[i]['ID']).val()) > 0) {
          var item = {
            'Denominasi'      : parseFloat($('#den'+objectID[i]['ID']).attr('name')),
            'Qty'             : parseFloat($('#qty'+objectID[i]['ID']).val()),
            'Jumlah'          : parseFloat($('#Tot'+objectID[i]['ID']).attr('name')),
            'PICPerhitungan'  : ''
          }

          objectPersembahan.push(item);
        }
      }

      var selectedOption = $('#JadwalIbadahID').find('option:selected');

      var obj = {
        'NoTransaksi' : $('#NoTransaksi').val(),
        'formtype' : $('#formtype').val(),
        'TglTransaksi' : $('#TglTransaksi').val(),
        'PICPerhitungan' : $('#PICPerhitungan').val(),
        'Keterangan' : $('#Keterangan').val(),
        'JadwalIbadahID' : $('#JadwalIbadahID').val(),
        'TglIbadah' : TanggalIbadah,
        'CabangID' : $('#CabangID').val(),
        'HariIbadah' : $('#Hari').val(),
        'NamaIbadah' : selectedOption.text(),
        'KodeAkunKas' : $('#KodeAkunKas').val(),
        'PK' : objectPK,
        'DenomPersembahan' : objectPersembahan
      }

      console.log(obj)
      // Do Something shit
      $.ajax({
        url: "<?=base_url()?>PersembahanController/SavePersembahan",
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(obj),
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
                  window.location.href = '<?=base_url()?>finance/persembahan';
                });
            }
            else{
                Swal.fire({
                  icon: "error",
                  title: "Opps...",
                  text: response.message,
                });
                $('#bt_save').text('Save');
                $('#bt_save').attr('disabled',false);
            }
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error('Error:', error);
        }
      });
    });

    function bindGrid(data) {
      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
        dataSource: data,
        keyExpr: "KodeAkun",
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
            allowAdding:true,
            allowUpdating: true,
            allowDeleting: true,
            texts: {
                confirmDeleteMessage: ''  
            }
        },
        columns: [
          {
            dataField: "NoTransaksi",
            caption: "Kode Akun",
            allowEditing:false,
            visible: false
          },
          {
            dataField: "KodeAkun",
            caption: "Kode Akun",
            allowEditing:false
          },
          {
            dataField: "NamaAkun",
            caption: "Nama Akun",
            allowEditing:false
          },
          {
              dataField: "Jumlah",
              caption: "Jumlah",
              allowEditing:false,
              dataType: 'number',
              format: { type: 'fixedPoint', precision: 2 }
          },
          {
            dataField: "Keterangan",
            caption: "Keterangan",
            allowEditing:false
          },
        ],
        onInitNewRow: function(e) {
          pemasukanlainlainsavemode = "add";
          $('#modal_').modal('show');
        },
        onEditingStart: function(e) {
          pemasukanlainlainsavemode = "edit";
          $('#modal_').modal('show');

          $('#KodeAkunKasLainLain').val(e.data.KodeAkun).trigger('change');
          $('#TotalLainLain').val(e.data.Jumlah);
          $('#KeteranganLainLain').val(e.data.Keterangan);
          // GetData(e.data.KodeBank, e.data.CabangID);
        },
      })
    }

    function bindGridHasilabsen(data) {
      $("#gridContainerPersembahan").dxDataGrid({
        allowColumnResizing: true,
        dataSource: data,
        keyExpr: "NamaDivisi",
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
            texts: {
                confirmDeleteMessage: ''  
            }
        },
        columns: [
          {
            dataField: "NamaDivisi",
            caption: "Nama Divisi",
            allowEditing:false
          },
          {
            dataField: "NIK",
            caption: "No. Induk Anggota",
            allowEditing:false,
          },
          {
            dataField: "NamaLengkap",
            caption: "Nama Lengkap",
            allowEditing:false
          },
          {
              dataField: "Rate",
              caption: "Rate",
              allowEditing:false,
              dataType: 'number',
              format: { type: 'fixedPoint', precision: 2 }
          },
          {
            dataField: "TglAbsen",
            caption: "Tanggal Absen",
            allowEditing:false,
          },
          {
            dataField: "CabangID",
            caption: "CabangID",
            allowEditing:false,
            visible: false
          },
          {
            dataField: "JadwalIbadahID",
            caption: "JadwalIbadahID",
            allowEditing:false,
            visible: false
          },
          {
            dataField: "DivisiID",
            caption: "DivisiID",
            allowEditing:false,
            visible: false
          },
          {
            dataField: "RatePKID",
            caption: "RatePKID",
            allowEditing:false,
            visible: false
          },
          {
            dataField: "Foto",
            caption: "Foto",
            allowEditing:false,
            visible: false
          },
          // {
          //   dataField: "FileItem",
          //   caption: "Action",
          //   allowEditing:false,
          //   cellTemplate: function(cellElement, cellInfo) {
          //     SelectedCabangID = cellInfo.data.CabangID;
          //     SelectedNoJadwal = cellInfo.data.NoTransaksi;
          //     console.log(cellInfo.data)
          //     var LinkAccess = "";
          //     if (cellInfo.data.NoAbsen == "") {
          //       LinkAccess = "<button class='btn btn-warning' onClick='absenModals()'>Hadir</button>";
          //     }
          //     // console.log();
          //     cellElement.append(LinkAccess);
          //   }
          // }
        ],
        summary: {
          totalItems: [
            { 
              column: 'Rate', 
              summaryType: 'sum',
              customizeText: function(data) {
                return "Total Rate: "+ data.value.toLocaleString('en-US');
              }
            } // Total price
          ],
          texts: {
              sum: 'Total Rate: {0}'
          }
        },
        onInitNewRow: function(e) {
          pemasukanlainlainsavemode = "add";
          $('#modal_').modal('show');
        },
        onEditingStart: function(e) {
          pemasukanlainlainsavemode = "edit";
          $('#modal_').modal('show');

          $('#KodeAkunKasLainLain').val(e.data.KodeAkun).trigger('change');
          $('#TotalLainLain').val(e.data.Jumlah);
          $('#KeteranganLainLain').val(e.data.Keterangan);
          // GetData(e.data.KodeBank, e.data.CabangID);
        },
      })
    }

  })
</script>