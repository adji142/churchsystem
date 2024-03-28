<?php
    // $user_id = $this->session->userdata('UserID');
    // if($user_id != ''){
    //     echo "<script>location.replace('".base_url()."home');</script>";
    // }
    // else{
    //   delete_cookie('ci_session');
    //   $this->session->sess_destroy();
    //   // echo "<script>location.replace('".base_url()."');</script>";
    // }
?>
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

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </head>
  <style type="text/css">
    .login{
      background-color: rgba(9,60,115,0.8)!important;
    }
    .background-container {
      background-image: url('<?php echo base_url() ?>/Assets/images/loginlogo.jpeg');
      background-repeat: no-repeat;
      background-size: contain;
      background-position: center;
      width: 100%;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-form-container {
      width: 400px;
      padding: 24px;
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 4px;
      text-align: center;
    }

    @media screen and (min-width: 800px) {
      .login_content {
        margin: 0 auto;
        padding: 25px 0 0;
        position: relative;
        text-align: center;
        text-shadow: 0 1px 0 #fff;
        /*min-width: 0px !important; */
        width: fit-content !important;
      } 
    }
    @media screen and (min-width: 320px) and (max-width: 680px) {
      .login-form-container {
        width: 300px;
        padding: 24px;
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 4px;
        text-align: center;
      }
      .login_content {
        margin: 0 auto;
        padding: 25px 0 0;
        position: relative;
        text-align: center;
        text-shadow: 0 1px 0 #fff;
        min-width: 0px !important; 
        /*width: fit-content!important;*/
      } 
    }
  </style>
  <body class="login">
    <div class="background-container" id="background-container">
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login-form-container">
        <section class="login_content">
          <form id="loginform" class="form-horizontal">
            <h1>Login Form</h1>

            <input type="text" class="form-control" placeholder="Username" required="" id="username" name="username"/>
            <input type="hidden" name="androidid" id="androidid" value="admin">

            <input type="password" class="form-control" placeholder="Password" required="" id="password" name="password"/>

            <button class="btn btn-success" id="btn_login">Log in</button>
          </form>
        </section>
      </div>
      <!-- <div class="login_wrapper">
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
                  <h1>
                    <img src="<?php echo base_url() ?>Assets/images/logoblack.png" width = "20%">
                    <br><br>
                    GTI SYSTEM
                  </h1>
                  <p>Sistem Administrasi Management Gereja</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div> -->

    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Modal Reset Password</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kode User <span class="required">*</span>
                </label>
                <div class="col-md-9 col-sm-9 ">
                  <input type="text" name="KodeUser" id="KodeUser" required="" placeholder="Kode User" readonly="" class="form-control ">
                </div>
              </div>

              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"> Password Baru<span class="required">*</span>
                </label>
                <div class="col-md-9 col-sm-9 ">
                  <input type="password" name="NewPassword" id="NewPassword" required="" placeholder="New Password" class="form-control ">
                </div>
              </div>

              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"> Tulis Ulang Password <span class="required">*</span>
                </label>
                <div class="col-md-9 col-sm-9 ">
                  <input type="password" name="ReNewPassword" id="ReNewPassword" required="" placeholder="Tulis Ulang Password" class="form-control ">
                </div>
              </div>

              <div class="item" form-group>
                <button class="btn btn-primary" id="btn_resetPassword">Reset Password</button>
              </div>
            </form>
          </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div> -->
        </div>
      </div>
    </div>
  </body>
</html>
<script type="text/javascript">
    $(function () {
        // Handle CSRF token
        $.ajaxSetup({
            beforeSend:function(jqXHR, Obj){
                var value = "; " + document.cookie;
                var parts = value.split("; csrf_cookie_token=");
                if(parts.length == 2)
                Obj.data += '&csrf_token='+parts.pop().split(";").shift();
            }
        });
        $(document).ready(function () {
          // const blankArea = document.getElementById("background-container");
          // const imageUrl = "<?php echo base_url() ?>/Assets/images/loginlogo.jpeg";

          // console.log(blankArea)

          // getDominantColor(imageUrl)
          // .then((color) => {
          //   blankArea.style.backgroundColor = color;
          //   console.log(color)
          // })
          // .catch((error) => {
          //   console.error("Error getting dominant color:", error);
          // });
        });
        // end Handle CSRF token
        $('#loginform').submit(function (e) {
            $('#btn_login').text('Tunggu Sebentar...');
            $('#btn_login').attr('disabled',true);

            e.preventDefault();
            var me = $(this);
            // alert(me.serialize());
            $.ajax({
                type: "post",
                url: "<?=base_url()?>Auth/loginprocessing",
                data: me.serialize(),
                dataType: "json",
                success:function (response) {
                    if(response.success == true){
                      location.replace("<?=base_url()?>Home")
                    }
                    else{
                      if (response.ChangePassword =='Y') {
                        Swal.fire({
                          type: 'error',
                          title: 'Oops...',
                          text: "Silahkan Reset Password !!",
                          // footer: '<a href>Why do I have this issue?</a>'
                        }).then((result)=>{
                            $('#btn_login').text('Login');
                            $('#btn_login').attr('disabled',false);

                            // Modals
                            $('#KodeUser').val($('#username').val());
                            $('#modal_').modal('show');
                        });
                      }
                      else{
                        Swal.fire({
                          type: 'error',
                          title: 'Oops...',
                          text: response.message,
                          // footer: '<a href>Why do I have this issue?</a>'
                        }).then((result)=>{
                            $('#username').val('');
                            $('#password').val('');
                            $('#btn_login').text('Login');
                            $('#btn_login').attr('disabled',false);
                        });
                      }
                    }
                }
            });
        });

        $('#post_').submit(function (e) {
          $('#btn_resetPassword').text('Tunggu Sebentar.....');
          $('#btn_resetPassword').attr('disabled',true);
          $(this).find(':input:disabled').prop('disabled', false);
          e.preventDefault();
          var me = $(this);
          $.ajax({
            type    :'post',
            url     : '<?=base_url()?>Auth/changepass',
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
                  $('#btn_resetPassword').text('Save');
                  $('#btn_resetPassword').attr('disabled',false);
                });
              }
            }
          });
        });
    });

    function getDominantColor(imageUrl) {
      return new Promise((resolve, reject) => {
        const img = new Image();
        img.crossOrigin = "Anonymous";
        img.onload = function () {
          const canvas = document.createElement("canvas");
          canvas.width = this.width;
          canvas.height = this.height;
          const ctx = canvas.getContext("2d");
          ctx.drawImage(this, 0, 0);
          const imageData = ctx.getImageData(0, 0, this.width, this.height).data;
          let r = 0,
            g = 0,
            b = 0;
          for (let i = 0; i < imageData.length; i += 4) {
            r += imageData[i];
            g += imageData[i + 1];
            b += imageData[i + 2];
          }
          const pixelCount = imageData.length / 4;
          const avgR = Math.round(r / pixelCount);
          const avgG = Math.round(g / pixelCount);
          const avgB = Math.round(b / pixelCount);
          resolve(`rgb(${avgR}, ${avgG}, ${avgB})`);
        };
        img.onerror = function (error) {
          reject(error);
        };
        img.src = imageUrl;
      });
    }
</script>