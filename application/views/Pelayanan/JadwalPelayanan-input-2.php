<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<div class="right_col" role="main">
	<div class="">
		<div class="clearfix"></div>
		<div class="row"  style="display: block;">
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
		                	<label class="col-form-label col-md-2 col-sm-2" for="first-name">Hari <span class="required">*</span>
		                    </label>
		                    <div class="col-md-4 col-sm-4 ">
		                     	<select class="form-control col-md-6" id="Hari" name="Hari" disabled="">
			                      <option value="">Pilih Hari</option>
			                      <?php

			                        foreach ($Hari as $key) {
			                          echo "<option value = '".$key->KodeHari."'>".$key->NamaHari."</option>";
			                        }
			                      ?>
			                    </select>
		                    </div>

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
		                </div>

		                <div class="item form-group">
		                    <label class="col-form-label col-md-2 col-sm-2" for="first-name">Jadwal Ibadah <span class="required">*</span>
		                    </label>
		                    <div class="col-md-10 col-sm-10 ">
		                      <select class="form-control" id="JadwalIbadahID" name="JadwalIbadahID">
		                        <option value="">Pilih Jadwal</option>
		                      </select>
		                    </div>
		                </div>

		                <div class="item form-group">
		                    <label class="col-form-label col-md-2 col-sm-2" for="first-name">PIC Kegiatan <span class="required">*</span>
		                    </label>
		                    <div class="col-md-10 col-sm-10 ">
		                      <select class="form-control" id="PICKegiatan" name="PICKegiatan" >
		                        <option value="0">Pilih PIC Kegiatan</option>
		                      </select>
		                    </div>
		                </div>

		                <div class="item form-group">
		                    <label class="col-form-label col-md-2 col-sm-2" for="first-name">Catatan <span class="required">*</span>
		                    </label>
		                    <div class="col-md-10 col-sm-10 ">
		                    	<input type="text" class="form-control" name="DeskripsiJadwal" id="DeskripsiJadwal" placeholder="Tambah Catatan">
		                    </div>
		                </div>

		          	</div>
		          </div>
				</div>
			</div>

			<div class="col-md-12 col-sm-12  ">
				<div class="x_panel">
					<div class="x_title">
						<h2>Personel Ibadah</h2>
		            	<div class="clearfix"></div>
		        	</div>
		        	<div class="x_content">
		        		<!-- <div class="col-md-12 col-sm-12">
		        			<div class="item form-group">
			                    <div class="col-md-6 col-sm-6 ">
				                    Personel
				                    <select class="form-control" id="Personel" name="Personel" >
				                    	<option value="0">Pilih Personel</option>
				                    </select>
			                    </div>
			                    <div class="col-md-6 col-sm-6 ">
				                    <br>
				                    <button class="btn btn-success">Pilih</button>
				                    <button class="btn btn-warning" id="btLookupPersonel">Look Up</button>
			                    </div>
			                </div>
		        		</div> -->
		        		<!-- <div class="col-md-12 col-sm-12">
		        			<div class="dx-viewport demo-container">
				                <div id="data-grid-demo">
				                  <div id="gridPersonel">
				                  </div>
				                </div>
				            </div>
		        		</div> -->
		        		<div class="col-md-12 col-sm-12">
		        			<div class="table-responsive">
		        				<table class="table table-striped jambo_table bulk_action" id="PenugasanTable">
		        					<thead>
		        						<tr class="headings">
		        							<th class="column-title">Personel </th>
				                            <th class="column-title">Cabang </th>
				                            <th class="column-title">Penugasan </th>
				                            <th class="column-title">Action </th>
		        						</tr>
		        					</thead>
		        					<tbody>
		        						<tr class="even pointer">
		        							<td class=" ">
		        								<!-- <select id="SelectPersonel">
		        									<option value="">Pilih Personel</option>
		        								</select> -->
		        							</td>
				                            <td class=" ">
				                            	<!-- <select id="SelectCabang">
		        									<option value="">Pilih Cabang</option>
		        								</select> -->
				                            </td>
				                            <td class=" ">
				                            	<!-- <select id="SelectPenugasan">
		        									<option value="">Penugasan Sebagai</option>
		        								</select> -->
				                            </td>
				                            <td class=" ">
				                            	<!-- <button class="btn btn-danger" id="btDelete">
				                            		<i class="success fa fa-trash"></i>
				                            	</button>
				                            	<button class="btn btn-success" id="btAdd">+</button>
				                            	<button class="btn btn-warning" id="btSearch">Cari Data</button> -->
				                            </td>
		        						</tr>
		        					</tbody>
		        				</table>
		        			</div>
		        		</div>

		        		<div class="col-md-12 col-sm-12">
		        			<button class="btn btn-success" id="btSave">Simpan data</button>
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
        <h4 class="modal-title" id="myModalLabel">Modal Personel</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-md-12 col-sm-12">
      			Wilayah <br>
	        	<select id="WilayahLookup" name="WilayahLookup" class="form-control">
		            <option value="">Pilih Wilayah</option>
		            <?php 
		              foreach ($Wilayah as $key) {
		                echo "<option value = '".$key->id."' >".$key->NamaArea."</option>";
		              }
		            ?>
		        </select>
		        <hr>
	        </div>
      		<div class="col-md-6 col-sm-6">
      			Provinsi <br>
	        	<select id="ProvIDLookup" name="ProvIDLookup" class="form-control">
		            <option value="-1">Pilih Provinsi</option>
		            <?php 
		              foreach ($prov as $key) {
		                echo "<option value = '".$key->prov_id."' >".$key->prov_name."</option>";
		              }
		            ?>
		        </select>
		        <hr>
	        </div>
	        <div class="col-md-6 col-sm-6">
	        	Kota <br>
		        <select id="KotaIDLookup" name="KotaIDLookup" class="form-control">
		            <option value="">Pilih Kota</option>
		        </select>
		        <hr>
	        </div>

	        <div class="col-md-12 col-sm-12">
	        	Cabang <br>
		        <select id="CabangIDLookup" name="CabangIDLookup" class="form-control">
		            <option value="0">Pilih Cabang</option>
		        </select>
		        <hr>
	        </div>

	        <div class="col-md-12 col-sm-12">
	        	<div class="dx-viewport demo-container">
	                <div id="data-grid-demo">
	                  <div id="gridPersonelLookup">
	                  </div>
	                </div>
	            </div>
	        </div>
      	</div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" id="btSelect">Pilih Personel</button>
      </div>
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
	    var detailObject = [];
	    var idObject = [];

	    var CabangFill = [];
	    var DepartementFill = [];
	    var JabatanFill = [];
	    var PersonelFill = [];

	    var hakUbahCabang = false;
	    var ProvID = -1;

	    var deffProvID = "<?php echo $this->session->userdata('Provinsi'); ?>";
	    var deffKotaID = "<?php echo $this->session->userdata('Kota'); ?>";
	    var deffWilayah = "<?php echo $this->session->userdata('Wilayah'); ?>";
	    var deffDivisiID = "<?php echo $this->session->userdata('DivisiID'); ?>";
	    $(document).ready(function () {
	    	$('#CabangID').select2({
		    	width: '100%'
		    });

		    $('#JadwalIbadahID').select2({
		        width: '100%'
		    });

		    $('#PICKegiatan').select2({
		        width: '100%'
		    });

		    $('#Hari').select2({
		        width: '100%'
		    });

		    $('#Personel').select2({
		    	width: '100%'
		    });

		    $('#WilayahLookup').select2({
		    	width: '100%'
		    });

		    $('#ProvIDLookup').select2({
		    	width: '100%'
		    });

		    $('#KotaIDLookup').select2({
		    	width: '100%'
		    });

		    $('#CabangIDLookup').select2({
		    	width: '100%'
		    });

		    // $('#SelectPenugasan').select2({
		    // 	width: '100%'
		    // });

		    // $('#SelectCabang').select2({
		    // 	width: '100%'
		    // });

		    // $('#SelectPersonel').select2({
		    // 	width: '100%'
		    // });

          	addPenugasanObject();


		    if (CabangID != 0) {
		        $('#CabangID').val(CabangID).trigger('change');
		    }

		    var now = new Date();
		    var day = ("0" + now.getDate()).slice(-2);
		    var month = ("0" + (now.getMonth() + 1)).slice(-2);
		    var today = now.getFullYear()+"-"+month+"-01";
		    var lastDayofYear = now.getFullYear()+"-"+month+"-"+day;

		    $('#TglTransaksi').val(lastDayofYear);
		    var timestamp = Date.parse(lastDayofYear);
	    	var dateObject = new Date(timestamp);
	    	var dayName = dateObject.toLocaleString('en-US', { weekday: 'long' });

	    	// console.log(dayName);
	    	$('#Hari').val(dayName).trigger('change');
	    	bindGrid(detailObject);
	    	getPersonelLookup();
	    });

	    $('#TglTransaksi').change(function () {
	    	var timestamp = Date.parse($('#TglTransaksi').val());
	    	var dateObject = new Date(timestamp);
	    	var dayName = dateObject.toLocaleString('en-US', { weekday: 'long' });

	    	// console.log(dayName);
	    	$('#Hari').val(dayName).trigger('change');
	    	getJadwal();
	    	getPersonel();
	    });
	    $('#btLookupPersonel').click(function () {
	    	$('#modal_').modal('show');
	    });

	    $('#btSelect').click(function () {
	    	var dataGridInstance = $('#gridPersonelLookup').dxDataGrid('instance');
        	var selectedRowsData = dataGridInstance.getSelectedRowsData();

        	console.log(idObject.length);
        	for (var i = 0; i < idObject.length; i++) {
        		if ($('#prs'+idObject[i]['ID']).val() == selectedRowsData[0]['NIK']) {
        			alert('Personel Sudah dipakai');
        		}


        		var newArray = PersonelFill.filter(function(item) {
				    return item['NIK'] === selectedRowsData[0]['NIK'];
				});

				if (newArray.length ==0) {
					var newOption = $('<option>', {
			            value: selectedRowsData[0]['NIK'],
			            text: selectedRowsData[0]['Nama'] + " - " + selectedRowsData[0]['CabangName']
			        });
			        $('#prs'+idObject[i]['ID']).append(newOption);
			        $('#prs'+idObject[i]['ID']).val(selectedRowsData[0]['NIK']).trigger('change');

			        // Cabang
			        var newOption = $('<option>', {
			            value: selectedRowsData[0]['CabangID'],
			            text: selectedRowsData[0]['CabangName']
			        });
			        $('#cab'+idObject[i]['ID']).append(newOption);
			        $('#cab'+idObject[i]['ID']).val(selectedRowsData[0]['CabangID']).trigger('change');

			        $('#modal_').modal('toggle');
				}
				else{
					$('#prs'+idObject[i]['ID']).val(selectedRowsData[0]['NIK']).trigger('change');
					$('#cab'+idObject[i]['ID']).val(selectedRowsData[0]['CabangID']).trigger('change');

					$('#modal_').modal('toggle');
				}
        	}
	    });

	    $('#btSave').click(function () {
	    	$('#btSave').text('Tunggu Sebentar.....');
      		$('#btSave').attr('disabled',true);

      		for (var i = 0; i < idObject.length; i++) {
      			// var selectPersonel = document.getElementById('prs'+idObject[i]['ID']);
		       //  var selectCabang = document.getElementById('cab'+idObject[i]['ID']);
		       //  var selectJabatan = document.getElementById('jab'+idObject[i]['ID']);
		        var selectJadwal = document.getElementById('JadwalIbadahID');

		       //  var personelOption = selectPersonel.options[selectPersonel.selectedIndex];
		       //  var cabangOption = selectCabang.options[selectCabang.selectedIndex];
		       //  var jabatanOption = selectJabatan.options[selectJabatan.selectedIndex];
		        var jadwalOption = selectJadwal.options[selectJadwal.selectedIndex];

		       //  var personelText = personelOption.text;
		       //  var cabangText = cabangOption.text;
		        // var jabatanText = jabatanOption.text;

		        var item = {
		        	NIK : $('#prs'+idObject[i]['ID']).val(),
		        	Nama : "",
		        	CabangID : $('#cab'+idObject[i]['ID']).val(),
		        	JabatanID : -1,
		        	PosisiPelayananID : $('#jab'+idObject[i]['ID']).val(),
		        	NamaJabatan : "",
		        	DivisiID : deffDivisiID,
		        	NoHP : '',
		        	Email : ''
		        }
		        if ($('#prs'+idObject[i]['ID']).val() !== "") {
		        	jsonObject.push(item)
		        }
      		}

      		var dataParam = {
		        'NoTransaksi' : $('#NoTransaksi').val(),
		        'TglTransaksi' : $('#TglTransaksi').val(),
		        'CabangID' : $('#CabangID').val(),
		        'JenisTransaksi' : 1,
		        'JadwalIbadahID' : $('#JadwalIbadahID').val(),
		        'EventID' : -1,
		        'NamaJadwal' : jadwalOption.text,
		        'DeskripsiJadwal' : $('#DeskripsiJadwal').val(),
		        'PICKegiatan' : $('#PICKegiatan').val(),
		        'formtype' : $('#formtype').val(),
		        'detail' : jsonObject
		    };

		    // console.log(dataParam);
		    $.ajax({
	        	async:false,
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
	        	        $('#btSave').text('Save');
	        	        $('#btSave').attr('disabled',false);
	        	    }
	        	},
	        	error: function(xhr, status, error) {
	        	    // Handle errors
	        	    console.error('Error:', error);
	        	}
		    });
	    });

	    $('#JadwalIbadahID').change(function () {
	    	// Load Existing Data

		    $.ajax({
		        async:false,
		        type: "post",
		        url: "<?=base_url()?>JadwalPelayananController/FindHeader",
		        data: {
		        	'TglTransaksi': $('#TglTransaksi').val(),
		        	'Hari': $('#Hari').val(),
		        	'JadwalIbadahID' : $('#JadwalIbadahID').val()
		        },
		        dataType: "json",
		        success: function (response) {
		          if (response.data.length > 0) {
		          	$('#NoTransaksi').val(response.data[0]['NoTransaksi']);
		          	$('#PICKegiatan').val(response.data[0]['PICKegiatan']).trigger('change');
		          	$('#DeskripsiJadwal').val(response.data[0]['DeskripsiJadwal']);

		          	$('#formtype').val('edit');
		          }
		        }
		    });

		    $.ajax({
		        async:false,
		        type: "post",
		        url: "<?=base_url()?>JadwalPelayananController/FindDetail",
		        data: {
		        	'NoTransaksi': $('#NoTransaksi').val(),
		        	'DivisiID' : deffDivisiID
		        },
		        dataType: "json",
		        success: function (response) {
		          if (response.data.length > 0) {
		          	var table = document.getElementById('PenugasanTable');
		          	table.deleteRow(1)

		          	// Delete From Array
			    	var newArray = idObject.filter(function(item) {
					    return item['ID'] !== idObject[0]['ID'];
					});

					idObject = newArray;
		          	$.each(response.data,function (k,v) {
		          		addPenugasanObject(v.PIC, v.CabangID, v.PosisiPelayananID);
		          	});

		          	
		          }
		        }
		    });
	    })

	    function getJadwal() {
	    	$.ajax({
		        async:false,
		        type: "post",
		        url: "<?=base_url()?>JadwalIbadahController/Read",
		        data: {'CabangID': $('#CabangID').val(),'Hari': $('#Hari').val()},
		        dataType: "json",
		        success: function (response) {
		          // bindGrid(response.data);
		          // console.log(response);
		          $('#JadwalIbadahID').empty();
		          var newOption = $('<option>', {
		            value: "",
		            text: "Pilih Ibadah / Event"
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
	    }

	    function getPersonel() {

	    	$.ajax({
		        async:false,
		        type: "post",
		        url: "<?=base_url()?>PersonelController/Read",
		        data: {'NIK':'','CabangID': $('#CabangID').val(),'Wilayah': deffWilayah,'Provinsi' : deffProvID,'Kota': deffKotaID,'DivisiID':deffDivisiID,'JabatanID':''},
		        dataType: "json",
		        success: function (response) {

		          // Personel Ibdah

		          $('#Personel').empty();
		          var newOption = $('<option>', {
		            value: "",
		            text: "Pilih Personel"
		          });

		          $('#Personel').append(newOption); 
		          $.each(response.data,function (k,v) {
		            var newOption = $('<option>', {
		              value: v.NIK,
		              text: v.Nama + " - " + v.CabangName
		            });

		            $('#Personel').append(newOption);
		          });
		        }
		    });
	    }

	    function getPIC() {

	    	$.ajax({
		        async:false,
		        type: "post",
		        url: "<?=base_url()?>PersonelController/Read",
		        data: {'NIK':'','CabangID': $('#CabangID').val(),'Wilayah': deffWilayah,'Provinsi' : "-1",'Kota': "",'DivisiID':"",'JabatanID':''},
		        dataType: "json",
		        success: function (response) {
		          // PIC Kegiatan
		          $('#PICKegiatan').empty();
		          var newOption = $('<option>', {
		            value: "",
		            text: "Pilih PIC Kegiatan"
		          });

		          $('#PICKegiatan').append(newOption); 
		          $.each(response.data,function (k,v) {
		            var newOption = $('<option>', {
		              value: v.NIK,
		              text: v.Nama + " - " + v.CabangName
		            });

		            $('#PICKegiatan').append(newOption);
		          });
		        }
		    });
	    }

	    function getKota() {
	    	$.ajax({
		        async:false,
		        type: "post",
		        url: "<?=base_url()?>DemografiController/ReadDemografi",
		        data: {'demografilevel':'dem_kota', 'wherefield': 'prov_id', 'wherevalue': $('#ProvIDLookup').val() },
		        dataType: "json",
		        success: function (response) {
		          $('#KotaIDLookup').empty();
		          var newOption = $('<option>', {
		            value: "",
		            text: "Pilih Kota"
		          });

		          $('#KotaIDLookup').append(newOption); 
		          $.each(response.data,function (k,v) {
		            var newOption = $('<option>', {
		              value: v.city_id,
		              text: v.city_name
		            });

		            $('#KotaIDLookup').append(newOption);
		          });
		        }
		    });
	    }

	    function getCabang() {
	    	$.ajax({
		        async:false,
		        type: "post",
		        url: "<?=base_url()?>CabangController/Read",
		        data: {'Area':$('#WilayahLookup').val(), 'ProvID': $('#ProvIDLookup').val(), 'KotaID': $('#KotaIDLookup').val() },
		        dataType: "json",
		        success: function (response) {
		        	// bindGridLookup(response.data);
		        	$('#CabangIdLookup').empty();
			          var newOption = $('<option>', {
			            value: "0",
			            text: "Pilih Cabang"
			          });

			          $('#CabangIdLookup').append(newOption); 
			          $.each(response.data,function (k,v) {
			            var newOption = $('<option>', {
			              value: v.id,
			              text: v.CabangName
			            });

			            $('#CabangIdLookup').append(newOption);
			        });
		        }
		    });
	    }

	    function getPersonelLookup() {
	    	$.ajax({
		        async:false,
		        type: "post",
		        url: "<?=base_url()?>PersonelController/ReadRaw",
		        data: {'NIK':'','CabangID': $('#CabangIDLookup').val(),'Wilayah': $('#WilayahLookup').val(),'Provinsi' : $('#ProvIDLookup').val(),'Kota': $('#KotaIDLookup').val(),'DivisiID':'','JabatanID':''},
		        dataType: "json",
		        success: function (response) {
		          // PIC Kegiatan
		          // console.log(response.data)
		          bindGridLookup(response.data)
		      	}
		    });
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

	    function addPenugasanObject(NIK, Cabang,Penugasan) {
	    	if (NIK === undefined || NIK === null) {
		        NIK = ''; // Default value for name
		    }
		    if (Cabang === undefined || Cabang === null) {
		        Cabang = ''; // Default value for name
		    }
		    if (Penugasan === undefined || Penugasan === null) {
		        Penugasan = ''; // Default value for name
		    }
	    	// PenugasanTable
	    	var table = document.getElementById('PenugasanTable');
	    	var xrow = table.rows.length -1;
            var idText = generateRandomText(5)
            // console.log(table.rows.length)

            // Adding Row

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

          	var selectPersonil = document.createElement('select');
          	var selectCabang = document.createElement('select');
          	var selectJabatan = document.createElement('select');

          	selectPersonil.id = 'prs'+idText;
          	selectCabang.id = 'cab'+idText;
          	selectJabatan.id = 'jab'+idText;

          	var item = {
            	ID : idText,
            	Index : xrow
          	}

          	idObject.push(item);

          	//region Fill Personel
          	// 		- Get Selected Personel
          	var NikIN = '';
          	// console.log(idObject)
          	if (idObject.length > 0) {
          		for (var i = 0; i < idObject.length; i++) {
	          		// Things[i]
	          		if ($('#prs'+idObject[i]['ID']).val() === undefined) {
	          			console.log('');
	          		}
	          		else{
	          			NikIN += $('#prs'+idObject[i]['ID']).val()+",";
	          		}
	          	}
          	}

          	// console.log(NikIN)
          	// getPersonelPenugasan(idText, NikIN);
          	$.ajax({
		        async:false,
		        type: "post",
		        url: "<?=base_url()?>PersonelController/Read",
		        data: {'NIK':'','CabangID': $('#CabangID').val(),'Wilayah': deffWilayah,'Provinsi' : deffProvID,'Kota': deffKotaID,'DivisiID':deffDivisiID,'JabatanID':'','NIKIn': NikIN.substring(0,NikIN.length -1)},
		        dataType: "json",
		        success: function (response) {
		          	// PIC Kegiata
		          	PersonelFill = response.data;

		          	var option = document.createElement('option');
		          	option.value = ""
	                option.text = "Pilih Pelayan"
	                selectPersonil.appendChild(option);

		          	$.each(response.data,function (k,v) {
		          		var option = document.createElement('option');
		                option.value = v.NIK; // Set option value
		                option.text = v.Nama + " - " + v.CabangName; // Set option text
		                selectPersonil.appendChild(option);
		          	});
		        }
		    });

          	var row = table.rows[xrow];
          	var cell = row.cells[0];
          	cell.appendChild(selectPersonil);

          	$('#prs'+idText).val(NIK).trigger('change');
          	$('#prs'+idText).select2({
            	width: '100%'
          	});
          	selectPersonil.onchange = function () {
          		handleSelectedComboChange(this);
          	}
          	// selectPersonil.addEventListener('change',handleSelectedComboChange);
          	//endregion End Personel

          	//region Fill Cabang
          	var dataCabang = '<?php echo json_encode($Cabang); ?>';
          	$.each(JSON.parse(dataCabang),function (k,v) {
          		var option = document.createElement('option');
                option.value = v.id; // Set option value
                option.text = v.CabangName; // Set option text
                selectCabang.appendChild(option);
          	});

          	var row = table.rows[xrow];
          	var cell = row.cells[1];
          	cell.appendChild(selectCabang);

          	$('#cab'+idText).val(Cabang).trigger('change');
          	$('#cab'+idText).select2({
            	width: '100%'
          	});
          	//endregion End Cabang

          	//region Fill Penugasan
          	$.ajax({
		        async:false,
		        type: "post",
		        url: "<?=base_url()?>PosisiPelayananController/Read",
		        data: {'CabangID': "0"},
		        dataType: "json",
		        success: function (response) {
		          	// PIC Kegiata
		          	var option = document.createElement('option');
		          	option.value = ""
	                option.text = "Pilih Penugasan"
	                selectJabatan.appendChild(option);

		          	$.each(response.data,function (k,v) {
		          		var option = document.createElement('option');
		                option.value = v.id; // Set option value
		                option.text = v.PosisiPelayanan
		                selectJabatan.appendChild(option);
		          	});
		        }
		    });
		    var row = table.rows[xrow];
          	var cell = row.cells[2];
          	cell.appendChild(selectJabatan);

          	$('#jab'+idText).val(Penugasan).trigger('change');
          	$('#jab'+idText).select2({
            	width: '100%'
          	});
          	//endregion End Penugasan

          	/*
				<button class="btn btn-danger" id="btDelete">
				    <i class="success fa fa-trash"></i>
            	</button>
            	<button class="btn btn-success" id="btAdd">+</button>
            	<button class="btn btn-warning" id="btSearch">Cari Data</button>
          	*/
          	if (xrow >= 1) {
          		var btDelete = document.createElement('button');
	          	var btAdd = document.createElement('button');
	          	var btSearch = document.createElement('button');

	          	// btDelete
	          	btDelete.id = 'btDel'+idText;
	          	btDelete.className = 'btn btn-danger';
	          	var icon = document.createElement('i');
	          	icon.className = 'success fa fa-trash';
	          	btDelete.appendChild(icon);

	          	// btAdd
	          	btAdd.id = 'btAdd'+idText;
	          	btAdd.className = 'btn btn-success';
	          	btAdd.textContent = '+';

	          	// btSearch
	          	btSearch.id = 'btSec'+idText;
	          	btSearch.className = 'btn btn-warning';
	          	btSearch.textContent = 'Cari Data';

	          	var row = table.rows[xrow];
	          	var cell = row.cells[3];
	          	cell.appendChild(btDelete);
	          	cell.appendChild(btAdd);
	          	cell.appendChild(btSearch);

	          	btDelete.onclick = function () {
	          		handleButtonClick(btDelete);
	          	}

	          	btAdd.onclick = function () {
	          		handleButtonClick(btAdd);
	          	}

	          	btSearch.onclick = function () {
	          		handleButtonClick(btSearch);
	          	}
          	}
	    }

	    function handleButtonClick(button) {
		    var buttonId = button.id;
		    var randomID = buttonId.substring(5,buttonId.length);
		    var btnName = buttonId.substring(0,5);
		    var idText = generateRandomText(5)

		    var table = document.getElementById('PenugasanTable');
	    	var xrow = table.rows.length - 1;
		    // addPenugasanObject();
		    // console.log(buttonId);
		    if (btnName == 'btAdd') {
		    	if ($('#prs'+randomID).val() == "") {
		    		alert('Isi Personel Terlebih dahulu');
		    	}
		    	else{
		    		addPenugasanObject();
		    	}
		    }
		    else if (btnName == 'btDel') {
		    	console.log(button.parentNode)
		    	var row = button.parentNode.parentNode;
		    	row.remove();

		    	// Delete From Array
		    	var newArray = idObject.filter(function(item) {
				    return item['ID'] !== randomID;
				});

				idObject = newArray;

				console.log(idObject);


	    		if (xrow ==2) {
	    			addPenugasanObject();
	    			// button.deleteRow(xrow);
	    			// table.deleteRow(1);
	    			// var btDelete = document.createElement('button');
		      //     	var btAdd = document.createElement('button');
		      //     	var btSearch = document.createElement('button');

	    			// var newRow = document.createElement('tr');

		      //     	var cell1 = document.createElement('td');
		      //     	newRow.appendChild(cell1);

		      //     	var cell2 = document.createElement('td');
		      //     	newRow.appendChild(cell2);

		      //     	var cell3 = document.createElement('td');
		      //     	newRow.appendChild(cell3);

		      //     	var cell4 = document.createElement('td');
		      //     	newRow.appendChild(cell4);

		      //     	table.appendChild(newRow);
		      //       // console.log(xrow)

		      //     	var item = {
		      //       	ID : idText
		      //     	}

		      //     	idObject.push(item);

		      //     	// btDelete
		      //     	btDelete.id = 'btDel'+idText;
		      //     	btDelete.className = 'btn btn-danger';
		      //     	var icon = document.createElement('i');
		      //     	icon.className = 'success fa fa-trash';
		      //     	btDelete.appendChild(icon);

		      //     	// btAdd
		      //     	btAdd.id = 'btAdd'+idText;
		      //     	btAdd.className = 'btn btn-success';
		      //     	btAdd.textContent = '+';

		      //     	// btSearch
		      //     	btSearch.id = 'btSec'+idText;
		      //     	btSearch.className = 'btn btn-warning';
		      //     	btSearch.textContent = 'Cari Data';

		      //     	var row = table.rows[xrow-1];
		      //     	var cell = row.cells[3];
		      //     	cell.appendChild(btDelete);
		      //     	cell.appendChild(btAdd);
		      //     	cell.appendChild(btSearch);

		      //     	btDelete.onclick = function () {
		      //     		handleButtonClick(btDelete);
		      //     	}

		      //     	btAdd.onclick = function () {
		      //     		handleButtonClick(btAdd);
		      //     	}

		      //     	btSearch.onclick = function () {
		      //     		handleButtonClick(btSearch);
		      //     	}
	    		}
		    }
		    else if (btnName == "btSec") {
		    	$('#modal_').modal('show');
		    }
		}

		function handleSelectedComboChange(event) {
			var objectID = event.id;
		    var randomID = objectID.substring(3,objectID.length);
		    var cboName = objectID.substring(0,3);

		    // console.log(cboName);
		    if (cboName =="prs") {
		    	$.ajax({
			        async:false,
			        type: "post",
			        url: "<?=base_url()?>PersonelController/Read",
			        data: {'NIK':$('#'+objectID).val(), 'CabangID':'0', 'Provinsi':'-1'},
			        dataType: "json",
			        success: function (response) {
			          	// PIC Kegiata
			          	console.log(response);
			          	$.each(response.data,function (k,v) {
			          		$('#cab'+randomID).val(v.CabangID).trigger('change');
			          		$('#jab'+randomID).val("").trigger('change');
			          	})
			        }
			    });	
		    }

		}

	    $('#CabangID').change(function () {
	    	getJadwal();
	    	getPersonel();
	    	getPIC();
	    });

	    $('#Personel').on('select2:select', function(e) {
	        var selectedOption = e.params.data;
	        var dataGridInstance = $('#gridPersonel').dxDataGrid('instance');
        	var allRowsData  = dataGridInstance.getDataSource().items();

        	$.ajax({
		        async:false,
		        type: "post",
		        url: "<?=base_url()?>PersonelController/Read",
		        data: {'NIK':selectedOption.id ,'CabangID': '','Wilayah': '','Provinsi' : '','Kota': '','DivisiID':'','JabatanID':''},
		        dataType: "json",
		        success: function (response) {
		        	var CabangID = -1;
		          	$.each(response.data,function (k,v) {
		            	CabangID = v.CabangID
		          	});

		          	var arr = selectedOption.text.split('-');

		          	var item = {
		        		'NIK' : selectedOption.id,
		        		'NamaKaryawan' : arr[0],
		        		'CabangID' : CabangID,
		        		'CabangName' : arr[1]
		        	}

		        	if (cekDuplicate(allRowsData, selectedOption.id)) {
		                alert('Data Sudah ada di baris lain');
		            }
		            else{
		            	detailObject.push(item);
		            }
		            bindGrid(detailObject);
		            // $('#Personel').val("").trigger('change');
		        }
		    });
	    });

	    $('#WilayahLookup').on('select2:select', function(e) {
	    	getPersonelLookup()
	    	// getPersonelLookup()
	    })

	    $('#ProvIDLookup').on('select2:select', function(e) {
	    	getPersonelLookup()
	    	getKota()
	    })

	    $('#KotaIDLookup').on('select2:select', function(e) {
	    	getPersonelLookup();
	    })

	    $('#CabangIDLookup').on('select2:select', function(e) {
	    	getPersonelLookup()
	    })

	    // $('#btAdd').click(function () {
	    // 	addPenugasanObject();
	    // })

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
	    function bindGrid(data) {
	    	$("#gridPersonel").dxDataGrid({
	    		allowColumnResizing: true,
	            dataSource: data,
	            keyExpr: "NIK",
	            showBorders: true,
	            allowColumnReordering: true,
	            allowColumnResizing: true,
	            columnAutoWidth: true,
	            showBorders: true,
	            paging: {
	                enabled: true
	            },
	            editing: {
	                mode: "row",
	                allowDeleting: true,
	                texts: {
	                    confirmDeleteMessage: ''  
	                }
	            },
	            searchPanel: {
	                visible: true,
	                width: 240,
	                placeholder: "Search..."
	            },
	            columns: [
	                {
	                    dataField: "NIK",
	                    caption: "Kode Karyawan",
	                    allowEditing:false
	                },
	                {
	                    dataField: "NamaKaryawan",
	                    caption: "Nama Karyawan",
	                    allowEditing:false,
	                },
	                {
	                    dataField: "CabangID",
	                    caption: "CabangID",
	                    allowEditing:false,
	                    visible:false
	                },
	                {
	                    dataField: "CabangName",
	                    caption: "Nama Cabang",
	                    allowEditing:false,
	                },
	            ],
	    	})
	    }

	    function bindGridLookup(data) {
	    	var dataGridInstance = $("#gridPersonelLookup").dxDataGrid({
	    		allowColumnResizing: true,
	            dataSource: data,
	            keyExpr: "NIK",
	            showBorders: true,
	            allowColumnReordering: true,
	            allowColumnResizing: true,
	            columnAutoWidth: true,
	            showBorders: true,
	            paging: {
	                enabled: true
	            },
	            editing: {
	                mode: "row",
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
	                    dataField: "NIK",
	                    caption: "Kode Karyawan",
	                    allowEditing:false
	                },
	                {
	                    dataField: "Nama",
	                    caption: "Nama Karyawan",
	                    allowEditing:false,
	                },
	                {
	                    dataField: "CabangID",
	                    caption: "CabangID",
	                    allowEditing:false,
	                    visible:false
	                },
	                {
	                    dataField: "CabangName",
	                    caption: "Nama Cabang",
	                    allowEditing:false,
	                },
	                {
	                    dataField: "NamaDivisi",
	                    caption: "Nama Cabang",
	                    allowEditing:false,
	                },
	                {
	                    dataField: "NamaJabatan",
	                    caption: "Nama Cabang",
	                    allowEditing:false,
	                },
	            ],
	    	}).dxDataGrid('instance');
	    }
	})
</script>