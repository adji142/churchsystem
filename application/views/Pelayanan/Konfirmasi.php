<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GTI SYSTEM! | Management Gereja</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>Assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>Assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url();?>Assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo base_url();?>Assets/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>Assets/build/css/custom.min.css" rel="stylesheet">
    <script src="<?php echo base_url();?>Assets/js/jquery.min.js"> </script>

    <script src="<?php echo base_url();?>Assets/sweetalert2-8.8.0/package/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>Assets/sweetalert2-8.8.0/package/dist/sweetalert2.min.css">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form id="loginform">
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" id="username" name="username"/>
                <input type="hidden" name="androidid" id="androidid" value="admin">
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" id="password" name="password"/>
              </div>
              <div>
                <button class="btn btn-success" id="btn_login">Log in</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> GTI SYSTEM</h1>
                  <p>Sistem Administrasi Management Gereja</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>

      <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_konfirmasi">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Modal Konvirmasi</h4>
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Alasan Tidak Bisa Hadir <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 ">
                    <input type="text" name="KonfirmasiKeterangan" id="KonfirmasiKeterangan" required="" placeholder="Alasan Tidak Bisa Hadir" class="form-control ">
                    <input type="hidden" name="KonfirmasiID" id="KonfirmasiID">
                  </div>
                </div>
                <div class="item" form-group>
                  <button class="btn btn-primary" id="btn_tidakhadir">Save</button>
                </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </body>
</html>
<script type="text/javascript">
  $(function () {
    $(document).ready(function () {
      var Konvirmasi = "<?php echo $KonfirmasiID; ?>";
      console.log(Konvirmasi);
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
      });
      swalWithBootstrapButtons.fire({
        title: "Konfirmasi Kehadiran",
        text: "Apakah anda bersedia mengambil jadwal pelayanan ini ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Bisa Hadir!",
        cancelButtonText: "No, Tidak Bisa Hadir!",
        reverseButtons: true
      }).then((result) => {
        // console.log(result);
        if (result.value) {
          $.ajax({
            type    :'post',
            url     : '<?=base_url()?>JadwalPelayananController/KonfirmasiAction',
            data    : {'KonfirmasiID': Konvirmasi,'Konfirmasi':1},
            dataType: 'json',
            success : function (response) {
              if(response.success == true){
                swalWithBootstrapButtons.fire({
                  title: "Sukses!",
                  text: "Terimakasih Atas Tanggapan Anda.",
                  icon: "success"
                }).then((result)=>{
                  // location.reload();
                  // Close
                  window.close();
                });
              }
              else{
                swalWithBootstrapButtons.fire({
                  title: "Error!",
                  text: result.message,
                  icon: "error"
                }).then((result)=>{
                  // location.reload();
                  // Close
                  window.close();
                });
              }
            }
          });
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {

          // $('#modal_konfirmasi').modal('show');
          Swal.fire({
            title: "Alasan Ketidakhadiran",
            input: "text",
            inputAttributes: {
              autocapitalize: "on"
            },
            showCancelButton: true,
            confirmButtonText: "Konfirmasi",
            showLoaderOnConfirm: true,
            preConfirm: async (login) => {
              // console.log(login);
              $.ajax({
                type    :'post',
                url     : '<?=base_url()?>JadwalPelayananController/KonfirmasiAction',
                data    : {'KonfirmasiID': "<?php echo $KonfirmasiID; ?>",'Konfirmasi':2,'KonfirmasiKeterangan':login},
                dataType: 'json',
                success : function (response) {
                  if(response.success == true){
                    swalWithBootstrapButtons.fire({
                      title: "Sukses!",
                      text: "Terimakasih sudah memberi feedback.",
                      icon: "success"
                    }).then((result)=>{
                      // location.reload();
                      // Close
                      window.close();
                    });
                  }
                  else{
                    swalWithBootstrapButtons.fire({
                      title: "Error!",
                      text: response.message,
                      icon: "error"
                    }).then((result)=>{
                      // location.reload();
                      // Close
                      window.close();
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
              console.log("masuk")
              window.close();
            }
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
        url     : '<?=base_url()?>JabatanController/CRUD',
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
        type: "post",
        url: "<?=base_url()?>JabatanController/Read",
        data: {'id':id},
        dataType: "json",
        success: function (response) {
          $.each(response.data,function (k,v) {
            $('#formtype').val("edit");

            $('#id').val(v.id);
            $('#NamaJabatan').val(v.NamaJabatan);
            $('#Level').val(v.Level);
            $('#CabangID').val(v.CabangID).trigger('change');

            $('#modal_').modal('show');
          });
        }
      });
    }
  });
</script>