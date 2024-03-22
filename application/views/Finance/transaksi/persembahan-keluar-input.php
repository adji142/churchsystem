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
            <h2>Input Data Pengeluaran</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-md-4 col-sm-4  ">
                Tanggal
                <input type="date" name="TglTransaksi" id="TglTransaksi" class="form-control ">
              </div>
              <div class="col-md-12 col-sm-12">
                <hr>
                <div class="dx-viewport demo-container">
                  <div id="data-grid-demo">
                    <div id="gridContainer">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-sm-12">
                <hr>
                <label class="col-form-label col-md-3 col-sm-3" for="first-name">Akun Kas <span class="required">*</span>
                </label>
                <div class="col-md-9 col-sm-9 ">
                  <select class="form-control" id="KodeAkunKas" name="KodeAkunKas" >
                    <option value="">Pilih Akun</option>
                  </select>
                  <input type="hidden" name="datapemasukan" id="datapemasukan">
                  <input type="hidden" name="formtype" id="formtype" value="add">
                  <input type="hidden" name="NoTransaksi" id="NoTransaksi" value="">
                  <input type="hidden" name="NoTransaksiOther" id="NoTransaksiOther" value="">
                </div>
              </div>
              <div class="col-md-12 col-sm-12">
                <hr>
                <button class="btn btn-danger" id="bt_save" disabled="">Simpan Data Pengeluaran</button>
              </div>
            </div>
          </div>
        </div>
      </div>
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
    var CabangID = "<?php echo $parseCabangID; ?>";
    var BaseReff = "<?php echo $NoTransaksi; ?>";
    var pemasukanlainlainsavemode = "add";

    $(document).ready(function () {
      $('#KodeAkunKas').select2({
        width: '100%'
      });
      var now = new Date();
      var day = ("0" + now.getDate()).slice(-2);
      var month = ("0" + (now.getMonth() + 1)).slice(-2);
      var today = now.getFullYear()+"-"+month+"-01";
      var lastDayofYear = now.getFullYear()+"-"+month+"-"+day;

      $('#TglTransaksi').val(lastDayofYear);

      bindGrid(jsonObject);
      getAkunKas();
      getAbsensi();
    })

    function getAkunKas() {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>AkunKasController/Read",
        data: {'KodeAkun':'', 'CabangID': CabangID },
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

    $('#KodeAkunKas').change(function () {
      SetEnableCommand();
    })

    function getAbsensi() {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>PersembahanController/ReadDataRate",
        data: {'NoJadwal':BaseReff, 'CabangID': CabangID },
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
          SetEnableCommand();
        }
      });
    }

    function SetEnableCommand() {
      var errorCount = 0;

      var dataGridInstance = $('#gridContainer').dxDataGrid('instance');
      var allRowsData  = dataGridInstance.getDataSource().items();

      if (allRowsData.length == 0) {
        errorCount +=1;
      }

      if ($('#AkunKasController').val() == "") {
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

      var saveObject = [];

      var dataGridInstance = $('#gridContainer').dxDataGrid('instance');
      var allRowsData  = dataGridInstance.getDataSource().items();

      for (var i = 0; i < allRowsData.length; i++) {
        // Things[i]
        item = {
          'NIK'         : allRowsData[i]['NIK'],
          'NamaLengkap' : allRowsData[i]['NamaLengkap'],
          'BaseReff'    : BaseReff,
          'CabangID'    : CabangID,
          'Jumlah'      : allRowsData[i]['Rate']
        }

        saveObject.push(item);
      }

      console.log(saveObject);

      var obj = {
        'CabangID' : CabangID,
        'formtype' : $('#formtype').val(),
        'NoTransaksi' : $('#NoTransaksi').val(),
        'BaseReff' : BaseReff,
        'KodeAkunKas' : $('#KodeAkunKas').val(),
        'TglTransaksi' : $('#TglTransaksi').val(),
        'detail' : saveObject,
      }
      // Do Something shit
      $.ajax({
        url: "<?=base_url()?>PersembahanController/CRUDPengeluaran",
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
        keyExpr: "NIK",
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
            // allowAdding:true,
            allowUpdating: true,
            allowDeleting: true,
            texts: {
                confirmDeleteMessage: ''  
            }
        },
        columns: [
          {
            dataField: "NIK",
            caption: "NIK",
            allowEditing:false,
          },
          {
            dataField: "NamaLengkap",
            caption: "Nama Pelayan",
            allowEditing:false
          },
          {
            dataField: "NamaDivisi",
            caption: "Divisi",
            allowEditing:false
          },
          {
            dataField: "NamaJabatan",
            caption: "Jabatan",
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
            dataField: "Rate",
            caption: "Jumlah",
            allowEditing:false,
            dataType: 'number',
            format: { type: 'fixedPoint', precision: 2 }
          },
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