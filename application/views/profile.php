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

<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Profile</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id="post_" data-parsley-validate class="form-horizontal form-label-left">

              <div class="item form-group">
                <div class="col-md-12 col-sm-12 ">
                  <textarea id = "image_base64" name = "image_base64" style="display:none"> </textarea>
                  <input type="file" id="Attachment" name="Attachment" accept=".jpg" class="btn btn-warning" style="display: none;"/>
                  <div class="xContainer">
                    <div id="image_result" class="image_result">
                    
                    </div>
                  </div>
                </div>
              </div>

              <br>
              <div class="item form-group">
                <div class="col-md-12 col-sm-12 ">
                  <label>Nomor Induk Personel</label>
                  <input type="text" name="NIK" id="NIK" required="" placeholder="<AUTO>" class="form-control " value="" readonly="">
                  <input type="hidden" name="formtype" id="formtype" value="add">
                </div>
              </div>
              <div class="item form-group">
                <div class="col-md-3 col-sm-3 ">
                  <label>Gelar Depan</label>
                  <input type="text" name="GelarDepan" id="GelarDepan" placeholder="Gelar Depan" class="form-control ">
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label>Nama</label>
                  <input type="text" name="NamaLengkap" id="NamaLengkap" required="" placeholder="Nama Lengkap" class="form-control ">
                </div>
                <div class="col-md-3 col-sm-3 ">
                  <label>Gelar belakang</label>
                  <input type="text" name="GelarBelakang" id="GelarBelakang" placeholder="Gelar Belakang" class="form-control ">
                </div>
              </div>
              <div class="item form-group">
                <div class="col-md-3 col-sm-3 ">
                  <label >Provinsi</label>
                  <select id="ProvID" name="ProvID" class="form-control">
                    <option value="-1">Pilih Provinsi</option>
                    <?php 
                      foreach ($prov as $key) {
                        echo "<option value = '".$key->prov_id."' >".$key->prov_name."</option>";
                      }
                    ?>
                  </select>
                </div>
                <div class="col-md-3 col-sm-3 ">
                  <label>Kota</label>
                  <select id="KotaID" name="KotaID" class="form-control">
                    <option value="-1">Pilih Kota</option>
                  </select>
                </div>
                <div class="col-md-3 col-sm-3 ">
                  <label>Kecamatan</label>
                  <select id="KecID" name="KecID" class="form-control">
                    <option value="-1">Pilih Kecamatan</option>
                  </select>
                </div>
                <div class="col-md-3 col-sm-3 ">
                  <label>Kelurahan</label>
                  <select id="KelID" name="KelID" class="form-control">
                    <option value="-1">Pilih Kelurahan</option>
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <div class="col-md-12 col-sm-12 ">
                  <label>Cabang</label>
                  <select class="form-control col-md-12" id="CabangID" name="CabangID" >
                    <option value="0">Pilih Cabang</option>
                    
                  </select>
                </div>
              </div>
              <label></label>

              <div class="item form-group">
                <div class="col-md-6 col-sm-6 ">
                  <label>Divisi</label>
                  <select class="form-control col-md-12" id="DivisiID" name="DivisiID" >
                    <option value="0">Pilih Divisi</option>
                  </select>
                </div>
                <label></label>
                <div class="col-md-6 col-sm-6 ">
                  <label>Jabatan</label>
                  <select class="form-control col-md-12" id="JabatanID" name="JabatanID" disabled="">
                    <option value="0">Pilih Jabatan</option>
                  </select>
                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-12 col-sm-12 ">
                  <label>Posisi Pelayanan</label>
                  <select class="form-control col-md-12" id="PosisiPelayanan" name="PosisiPelayanan" >
                    <option value="0">Pilih Posisi Pelayanan</option>
                    <?php 
                      foreach ($PosisiPelayanan as $key) {
                        echo "<option value = '".$key->id."' >".$key->PosisiPelayanan."</option>";
                      }
                    ?>
                  </select>
                </div>
              </div>

              <div class="item form-group">
                <label class="col-form-label col-md-2 col-sm-2" for="TglLahir">Tanggal Lahir</label>
                <div class="col-md-4 col-sm-4 ">
                  <input type="text" name="TempatLahir" id="TempatLahir" required="" placeholder="Tempat Lahir" class="form-control ">
                </div>
                <label class="col-form-label col-md-2 col-sm-2" for="TglLahir">Tanggal Lahir</label>
                <div class="col-md-4 col-sm-4 ">
                  <input type="date" name="TglLahir" id="TglLahir" required="" placeholder="Tempat Lahir" class="form-control ">
                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-4 col-sm-4 ">
                  <label>Agama</label>
                  <select class="form-control col-md-12" id="Agama" name="Agama" >
                    <option value="">Pilih Agama</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Budha">Budha</option>
                    <option value="Islam">Islam</option>
                    <option value="Lain Lain">Lain Lain</option>
                  </select>
                </div>
                <label></label>
                <div class="col-md-4 col-sm-4 ">
                  <label>Jenis Kelamin</label>
                  <select class="form-control col-md-12" id="JenisKelamin" name="JenisKelamin" >
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L">Laki-Laki</option>
                    <option value="P">Perempuan</option>
                  </select>
                </div>
                <label></label>
                <div class="col-md-4 col-sm-4 ">
                  <label>Rate PK</label>
                  <select class="form-control col-md-12" id="RatePKCode" name="RatePKCode" disabled="">
                    <option value="">Pilih Rate PK</option>
                  </select>
                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-12 col-sm-12 ">
                  <label>Nomer Induk Pendudukan</label>
                  <input type="text" name="NomorKependudukan" id="NomorKependudukan" required="" placeholder="Nomor Induk Kependudukan (KTP / SIM / PASPOR)" class="form-control ">
                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-12 col-sm-12 ">
                  <label>Alamat</label>
                  <textarea id="Alamat" name="Alamat" class="resizable_textarea form-control" placeholder="Alamat"></textarea>
                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-6 col-sm-6 ">
                  <label>Email</label>
                  <input type="mail" name="Email" id="Email" required="" placeholder="Email" class="form-control ">
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label>Nomor HP</label>
                  <input type="number" name="NoHP" id="NoHP" required="" placeholder="6281325058258" class="form-control ">
                </div>
              </div>

              <div class="item" form-group>
                <label></label>
                <button class="btn btn-primary" id="btn_Save">Save</button>
              </div>
            </form>
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
    var _URL = window.URL || window.webkitURL;
    var _URLePub = window.URL || window.webkitURL;
    var CabangID = "<?php echo $CabangID; ?>"
    var NIKPersonel = "<?php echo $NIKPersonel; ?>"
    $(document).ready(function () {
      $('#CabangID').select2({
        width: '100%'
      });

      $('#ProvID').select2({
        width: '100%'
      });
      $('#KotaID').select2({
        width: '100%'
      });
      $('#KecID').select2({
        width: '100%'
      });
      $('#KelID').select2({
        width: '100%'
      });

      $('#image_result').html("<img src ='https://png.pngtree.com/png-vector/20220622/ourmid/pngtree-unknown-user-question-mark-about-png-image_5169297.png' width = '400'> ");

      if (CabangID != 0) {
        $('#CabangID').prop('disabled', true);
        $('#CabangID').val(CabangID).trigger('change');
      }

      if (NIKPersonel == "") {
        Swal.fire({
          type: 'error',
          title: 'Woops...',
          text: 'Personel Tidak ditemukan',
          // footer: '<a href>Why do I have this issue?</a>'
        }).then((result)=>{
          window.location.href = '<?=base_url()?>personel';
        });
      }
      else{
        GetData(NIKPersonel, CabangID)
      }
    });

    $('#ProvID').change(function () {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>DemografiController/ReadDemografi",
        data: {'demografilevel':'dem_kota', 'wherefield': 'prov_id', 'wherevalue': $('#ProvID').val() },
        dataType: "json",
        success: function (response) {
          $('#KotaID').empty();
          var newOption = $('<option>', {
            value: -1,
            text: "Pilih Kota"
          });

          $('#KotaID').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.city_id,
              text: v.city_name
            });

            $('#KotaID').append(newOption);
          });
        }
      });

      // Fill Cabang

      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>CabangController/Read",
        data: {'id':'', 'ProvID': $('#ProvID').val()},
        dataType: "json",
        success: function (response) {
          $('#CabangID').empty();
          var newOption = $('<option>', {
            value: 0,
            text: "Pilih Cabang"
          });

          $('#CabangID').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.id,
              text: v.CabangName
            });

            $('#CabangID').append(newOption);
          });

          // Fill Cabang

        }
      });
    });


    $('#KotaID').change(function () {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>DemografiController/ReadDemografi",
        data: {'demografilevel':'dem_kecamatan', 'wherefield': 'kota_id', 'wherevalue': $('#KotaID').val() },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response);
          $('#KecID').empty();
          var newOption = $('<option>', {
            value: -1,
            text: "Pilih Kecamatan"
          });

          $('#KecID').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.dis_id,
              text: v.dis_name
            });

            $('#KecID').append(newOption);
          });
        }
      });
    });

    $('#KecID').change(function () {
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>DemografiController/ReadDemografi",
        data: {'demografilevel':'dem_kelurahan', 'wherefield': 'kec_id', 'wherevalue': $('#KecID').val() },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response);
          $('#KelID').empty();
          var newOption = $('<option>', {
            value: -1,
            text: "Pilih Kelurahan"
          });

          $('#KelID').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.subdis_id,
              text: v.subdis_name
            });

            $('#KelID').append(newOption);
          });
        }
      });
    });

    $('#CabangID').change(function () {
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
      // Rate PK

      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>RatePKController/Read",
        data: {'id':'', 'CabangID': $('#CabangID').val() },
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          // console.log(response);
          $('#RatePKCode').empty();
          var newOption = $('<option>', {
            value: -1,
            text: "Pilih Rate PK"
          });

          $('#RatePKCode').append(newOption); 
          $.each(response.data,function (k,v) {
            var newOption = $('<option>', {
              value: v.id,
              text: v.NamaRate
            });

            $('#RatePKCode').append(newOption);
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

    $('#image_result').click(function(){
        $('#Attachment').click();
    });

    $('#post_').submit(function (e) {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);
      $(this).find(':input:disabled').prop('disabled', false);
      e.preventDefault();
      var me = $(this);
      $.ajax({
        async:false,
        type    :'post',
        url     : '<?=base_url()?>PersonelController/CRUD',
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
        async:false,
        type: "post",
        url: "<?=base_url()?>PersonelController/Find",
        data: {'NIK':id,'CabangID':CabangID},
        dataType: "json",
        success: function (response) {
          if (response.success == true) {
            $.each(response.data,function (k,v) {
              $('#formtype').val("edit");
              $('#NIK').attr('readonly',true);

              $('#NIK').val(v.NIK);
              $('#NamaLengkap').val(v.NamaLengkap);
              $('#GelarDepan').val(v.GelarDepan);
              $('#GelarBelakang').val(v.GelarBelakang);
              $('#ProvID').val(v.ProvID).trigger('change');
              $('#KotaID').val(v.KotaID).trigger('change');
              $('#KecID').val(v.KecID).trigger('change');
              $('#KelID').val(v.KelID).trigger('change');
              $('#CabangID').val(v.CabangID).trigger('change');
              $('#DivisiID').val(v.DivisiID).trigger('change');
              $('#JabatanID').val(v.JabatanID).trigger('change');
              $('#TempatLahir').val(v.TempatLahir);
              $('#TglLahir').val(v.TglLahir);
              $('#Agama').val(v.Agama);
              $('#JenisKelamin').val(v.JenisKelamin);
              $('#RatePKCode').val(v.RatePKCode);
              $('#NomorKependudukan').val(v.NomorKependudukan);
              $('#Alamat').val(v.Alamat);
              $('#image_base64').val(v.Foto);
              $('#Email').val(v.Email);
              $('#NoHP').val(v.NoHP);
              $('#PosisiPelayanan').val(v.PosisiPelayanan).change();

              $('#image_result').html("<img src ='"+v.Foto+"'> ");
              $('#modal_').modal('show');
            });
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

    $("#Attachment").change(function(){
      var file = $(this)[0].files[0];
      img = new Image();
      img.src = _URL.createObjectURL(file);
      var imgwidth = 0;
      var imgheight = 0;
      img.onload = function () {
        imgwidth = this.width;
        imgheight = this.height;
        $('#width').val(imgwidth);
        $('#height').val(imgheight);
      }
      readURL(this);
      encodeImagetoBase64(this);
      // alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
    });

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
          
        reader.onload = function (e) {
          console.log(e.target.result);
          $('#image_result').html("<img src ='"+e.target.result+"'> ");
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    function encodeImagetoBase64(element) {
      $('#image_base64').val('');
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
          // $(".link").attr("href",reader.result);
          // $(".link").text(reader.result);
          $('#image_base64').val(reader.result);
        }
        reader.readAsDataURL(file);
    }
  });
</script>