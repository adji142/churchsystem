<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<style type="text/css">
  .xContainer{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    vertical-align: middle;
  }
  .image_result{
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid black;
    /*flex-grow: 1;*/
    vertical-align: middle;
    align-content: center;
    flex-basis: 200;
    width: 150px;
    height: 200px;
  }
  .image_result img {
    max-width: 100%; /* Fit the image to the container width */
    height: 100%; /* Maintain the aspect ratio */
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
            <!-- <h2>Absensi Personel</h2> -->
              <div class="col-md-3 col-sm-3  ">
                Tanggal Awal
                <input type="date" name="TglAwal" id="TglAwal" class="form-control ">
              </div>
              <div class="col-md-3 col-sm-3  ">
                Tanggal Akhir
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
                <br>
                <button class="btn btn-primary" id="btn_Search">Cari Data</button>
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
<?php
  require_once(APPPATH."views/parts/Footer.php");
?>
<script type="text/javascript">
  var SelectedNoJadwal = "";
  var SelectedCabangID = "";
  var SelectedKonfirmasiID = "";
  $(function () {
    var CabangID = "<?php echo $CabangID; ?>"

    $(document).ready(function () {
      $('#CabangID').select2({
        width: '100%'
      });

      $('#CabangIDFilter').select2({
        width: '100%'
      });

      if (CabangID != 0) {
        // $('#CabangID').prop('disabled', true);
        $('#CabangID').val(CabangID).trigger('change');

        // $('#CabangIDFilter').prop('disabled', true);
        $('#CabangIDFilter').val(CabangID).trigger('change');
      }

      var now = new Date();
      var day = ("0" + now.getDate()).slice(-2);
      var month = ("0" + (now.getMonth() + 1)).slice(-2);
      var today = now.getFullYear()+"-"+month+"-01";
      var lastDayofYear = now.getFullYear()+"-"+month+"-"+day;

      $('#TglAwal').val(today);
      $('#TglAkhir').val(lastDayofYear);

      readData();
    });

    function readData() {
      var NikPersonel = "<?php echo $NIKPersonel; ?>";
      $.ajax({
        type: "post",
        url: "<?=base_url()?>PenugasanController/ReadKonfirmasiList",
        data: {
          'TglAwal':$('#TglAwal').val(),
          'TglAkhir':$('#TglAkhir').val(),
          'NoTransaksi' : '',
          'CabangID' : $('#CabangIDFilter').val(),
          'NikPersonel' : NikPersonel,
          'NoReff' : ''
        },
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });
    }

    $('#btn_Search').click(function () {
      readData();
    })
    $('#post_').submit(function (e) {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);
      $(this).find(':input:disabled').prop('disabled', false);
      e.preventDefault();
      var me = $(this);
      $.ajax({
        type    :'post',
        url     : '<?=base_url()?>AbsensiController/CRUD',
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
    function bindGrid(data) {
      var canAdd = "<?php echo $canAdd; ?>";
      var canEdit = "<?php echo $canEdit; ?>";
      var canDelete = "<?php echo $canDelete; ?>";

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
                // allowUpdating: canEdit,
                // allowDeleting: canDelete,
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
                fileName: "Daftar Konfirmasi"
            },
            columns: [
                {
                    dataField: "NoTransaksi",
                    caption: "No. Reg Jadwal",
                    allowEditing:false,
                    visible:false
                },
                {
                    dataField: "Tanggal",
                    caption: "Tanggal",
                    allowEditing:false,
                },
                {
                    dataField: "CabangName",
                    caption: "Cabang",
                    allowEditing:false,
                    visible:true,
                },
                {
                    dataField: "NamaIbadah",
                    caption: "Ibadah / Sesi",
                    allowEditing:false
                },
                {
                    dataField: "CabangID",
                    caption: "CabangID",
                    allowEditing:false,
                    visible: false
                },
                {
                    dataField: "PIC",
                    caption: "NIK",
                    allowEditing:false,
                    visible:false
                },
                {
                    dataField: "NamaLengkap",
                    caption: "Nama",
                    allowEditing:false,
                    visible:false
                },
                
                {
                    dataField: "JamMulai",
                    caption: "Mulai",
                    allowEditing:false,
                    visible:false
                },
                {
                    dataField: "JamSelesai",
                    caption: "Selesai",
                    allowEditing:false,
                    visible:false
                },
                {
                    dataField: "KonfirmasiID",
                    caption: "ID",
                    allowEditing:false,
                    visible: false
                },
                {
                    dataField: "diKonfirmasi",
                    caption: "Y/N",
                    allowEditing:false,
                },
                {
                    dataField: "KonfirmasiKeterangan",
                    caption: "Keterangan",
                    allowEditing:false,
                    visible:false
                },
                {
                    dataField: "FileItem",
                    caption: "Action",
                    allowEditing:false,
                    cellTemplate: function(cellElement, cellInfo) {
                      SelectedCabangID = cellInfo.data.CabangID;
                      SelectedNoJadwal = cellInfo.data.NoTransaksi;
                      SelectedKonfirmasiID = cellInfo.data.KonfirmasiID;

                      console.log(cellInfo.data)
                      var LinkAccess = "";
                      if (cellInfo.data.diKonfirmasi == "N") {
                        LinkAccess = "<button class='btn btn-warning' onClick='absenModals()'>Konfirmasi</button>";
                      }
                      // console.log();
                      cellElement.append(LinkAccess);
                  }
                }
            ],
            onEditingStart: function(e) {
                GetData(e.data.id,e.data.CabangID);
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
                      url     : '<?=base_url()?>DivisiController/CRUD',
                      data    : {'id':e.data.id,'CabangID':e.data.CabangID,'formtype':'delete'},
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
    function absenModals () {
      // alert(SelectedNoJadwal + ' - ' + SelectedCabangID);
      Swal.fire({
        title: "Konfirmasi Jadwal Pelayananmu",
        input: "text",
        inputAttributes: {
          autocapitalize: "on"
        },
        showCancelButton: true,
        confirmButtonText: "Bisa Hadir",
        cancelButtonText : "Tidak Bisa Hadir",
        showLoaderOnConfirm: true,
        preConfirm: async (login) => {
          // console.log(login);
          $.ajax({
            type    :'post',
            url     : '<?=base_url()?>JadwalPelayananController/KonfirmasiAction',
            data    : {'KonfirmasiID': SelectedKonfirmasiID,'Konfirmasi':1,'KonfirmasiKeterangan':login},
            dataType: 'json',
            success : function (response) {
              if(response.success == true){
                swal.fire({
                  title: "Sukses!",
                  text: "Terimakasih sudah memberi feedback.",
                  icon: "success"
                }).then((result)=>{
                  location.reload();
                  // Close
                  // window.close();
                });
              }
              else{
                swal.fire({
                  title: "Error!",
                  text: response.message,
                  icon: "error"
                }).then((result)=>{
                  location.reload();
                  // Close
                  // window.close();
                });
              }
            }
          });
        },
        allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {
        console.log(result);
        if (result.dismiss === Swal.DismissReason.cancel) {
          // Close
          // console.log("masuk")
          // window.close();
          $.ajax({
            type    :'post',
            url     : '<?=base_url()?>JadwalPelayananController/KonfirmasiAction',
            data    : {'KonfirmasiID': SelectedKonfirmasiID,'Konfirmasi':2,'KonfirmasiKeterangan':login},
            dataType: 'json',
            success : function (response) {
              if(response.success == true){
                swal.fire({
                  title: "Sukses!",
                  text: "Terimakasih sudah memberi feedback.",
                  icon: "success"
                }).then((result)=>{
                  location.reload();
                  // Close
                  // window.close();
                });
              }
              else{
                swal.fire({
                  title: "Error!",
                  text: response.message,
                  icon: "error"
                }).then((result)=>{
                  location.reload();
                  // Close
                  // window.close();
                });
              }
            }
          });
        }
      });

      // var NikPersonel = "<?php echo $NIKPersonel; ?>";
      // // alert(NikPersonel);
      // $.ajax({
      //   type: "post",
      //   url: "<?=base_url()?>AbsensiController/Read",
      //   data: {
      //     'TglAwal':$('#TglAwal').val(),
      //     'TglAkhir':$('#TglAkhir').val(),
      //     'NoTransaksi' : '',
      //     'CabangID' : SelectedCabangID,
      //     'NikPersonel' : NikPersonel,
      //     'NoReff' : SelectedNoJadwal
      //   },
      //   dataType: "json",
      //   success: function (response) {
      //     // bindGrid(response.data);
      //     // console.log(response.data);
      //     $.each(response.data,function (k,v) {
      //       $('#CabangID').val(v.CabangID).trigger('change');
      //       $('#NIK').val(v.PIC);
      //       $('#NamaLengkap').val(v.NamaLengkap);
      //       $('#DivisiID').val(v.DivisiID).trigger('change');
      //       $('#JabatanID').val(v.JabatanID).trigger('change');
      //       $('#ReffJadwal').val(SelectedNoJadwal);

      //       $('#modal_').modal('show');
      //     });
      //   }
      // });
    }
</script>