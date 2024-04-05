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
			              if ($penugasan) {
			                echo "<h2>Edit Jadwal Pelayanan</h2>";
			                echo "<input type='hidden' id='formtype' value = 'edit'>";
			                echo '<textarea  id="headerData" style ="display:none;">'.json_encode($penugasan).'</textarea>';
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
			        		</div>
			        		<div class="col-md-12 col-sm-12">
			        			<div class="item form-group">
			        				<label class="col-form-label col-md-2 col-sm-2" for="first-name">Hari <span class="required">*</span>
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

				                    <label class="col-form-label col-md-2 col-sm-2" for="first-name">Divisi <span class="required">*</span>
				                    </label>
				                    <div class="col-md-4 col-sm-4 ">
					                    <select class="form-control" id="DivisiID" name="DivisiID">
					                    	<option value="">Pilih Divisi</option>
					                    	<?php

						                        foreach ($divisi as $key) {
						                          echo "<option value = '".$key->id."'>".$key->NamaDivisi."</option>";
						                        }
						                    ?>
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
			</div>

			<div class="col-md-12 col-sm-12  ">
				<div class="x_panel">
					<div class="x_title">
			            <h2>Personel</h2>
			        	<div class="clearfix"></div>
			        </div>
			        <div class="x_content">
						<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
							<!-- test -->
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12 col-sm-12  ">
				<button class="btn btn-success" id="btSave">Simpan data</button>
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
      		<input type="text" name="objectID" id="objectID">
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
		var DivisiID = "<?php echo $this->session->userdata('DivisiID'); ?>";
		var Provinsi = "<?php echo $this->session->userdata('Provinsi'); ?>";
		var Kota = "<?php echo $this->session->userdata('Kota'); ?>";
		var Wilayah = "<?php echo $this->session->userdata('Wilayah'); ?>";

		var idObject = [];
		var idObjectDetail = [];
		var PersonelFill = [];

		var rowCount = 1;
		$(document).ready(function () {
			$('#Hari').select2({
		        width: '100%'
		    });

		    $('#DivisiID').select2({
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
	    	$('#DivisiID').val(DivisiID).trigger('change');
	    	// Trigger Click
	    	// $('#headingOne').trigger('click');

	    	if ($('#headerData').val() != "") {
	    		var headerData = $.parseJSON($('#headerData').val());

	    		if (headerData.length > 0) {
	    			for (var i = 0; i < headerData.length; i++) {
	    				// Things[i]
	    				// console.log(i + " - " + headerData.length)
	    				if (i+1 == headerData.length) {
	    					$('#TglTransaksi').val(headerData[i]['Tanggal']);
	    					$('#Hari').val(headerData[i]['Hari']).trigger('change');
	    					$('#DivisiID').val(headerData[i]['DivisiID']).trigger('change');
	    					$('#Keterangan').val(headerData[i]['Keterangan']);
	    				}
	    			}
	    			// Show Data

	    			for (var i = 0; i < headerData.length; i++) {
	    				
	    			}
	    		}
	    	}
		});

		// Hari Change
		$('#TglTransaksi').change(function () {
			// console.log('Change Date')
	    	var timestamp = Date.parse($('#TglTransaksi').val());
	    	var dateObject = new Date(timestamp);
	    	var dayName = dateObject.toLocaleString('en-US', { weekday: 'long' });

	    	// console.log(dayName);
	    	$('#Hari').val(dayName).trigger('change');

	    	GenerateObject();
	    	// getJadwal();
	    	// getPersonel();
	    });

	    $('#DivisiID').change(function () {
	    	GenerateObject();
	    	// GenerateObjectDetail();
	    });

	    $('#btSelect').click(function () {
	    	var dataGridInstance = $('#gridPersonelLookup').dxDataGrid('instance');
        	var selectedRowsData = dataGridInstance.getSelectedRowsData();

        	// console.log(idObject.length);
        	for (var i = 0; i < idObject.length; i++) {

        		for (var x = 0; x < idObject[i]['personel'].length; x++) {
        			// Things[i]
        			// console.log(idObject[i]['personel'][x])

        			var idofObject = idObject[i]['personel'][x]['ID'];
        			// console.log(idofObject)

        			if (idofObject == $('#objectID').val()) {
        				if (cekDuplicate(selectedRowsData[0]['NIK'])) {
		        			alert('Personel Sudah dipakai');
		        			break;
		        		}

		        		var newArray = PersonelFill.filter(function(item) {
						    return item['NIK'] === selectedRowsData[0]['NIK'];
						});

						if (newArray.length ==0) {
							var newOption = $('<option>', {
					            value: selectedRowsData[0]['NIK'],
					            text: selectedRowsData[0]['Nama'] + " - " + selectedRowsData[0]['NamaDivisi']
					        });
					        $('#prs'+idofObject).append(newOption);
					        $('#prs'+idofObject).val(selectedRowsData[0]['NIK']).trigger('change');

					        $('#modal_').modal('toggle');
						}
						else{
							$('#prs'+idofObject).val(selectedRowsData[0]['NIK']).trigger('change');

							$('#modal_').modal('toggle');
						}
        			}

        		}
        	}
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
	    });

	    $('#btSave').click(function () {
	    	var json_object = {
	    		formtype : $('#formtype').val(),
	    		detail : []
	    	};

	    	for (var i = 0; i < idObject.length; i++) {
	    		for (var x = 0; x < idObject[i]['personel'].length; x++) {
	    			if ($('#prs'+idObject[i]['personel'][x]['ID']).val() != "") {
	    				var item = {
		    				'NoTransaksi'	: '',
		    				'DivisiID'		: $('#DivisiID').val(),
		    				'Tanggal'		: $('#TglTransaksi').val(),
		    				'Hari'			: $('#Hari').val(),
		    				'CabangID'		: $('#cabang'+idObject[i]['ParentID']).val(),
		    				'JadwalIbadahID': $('#ibd'+idObject[i]['Detail']).val(),
		    				'PIC'			: $('#prs'+idObject[i]['personel'][x]['ID']).val(),
		    				'Keterangan' 	: $('#Keterangan').val()
		    			}

		    			json_object['detail'].push(item);
	    			}
	    		}
	    	}

	    	// console.log(json_object);
	    	$('#btSave').click(function () {
	    		$('#btSave').text('Tunggu Sebentar.....');
      			$('#btSave').attr('disabled',true);

      			$.ajax({
		        	async:false,
		        	url: "<?=base_url()?>PenugasanController/CRUD",
		        	type: 'POST',
		        	contentType: 'application/json',
		        	data: JSON.stringify(json_object),
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

	    	})
	    })

	    // $('#btAdd').click(function () {
	    // 	addPenugasanObject();
	    // })

	    function cekDuplicate(newValue) {
		    var itemCount = 0;
		    var duplicate = false;
		        
	       	for (var i = 0; i < idObject.length; i++) {
	    		for (var x = 0; x < idObject[i]['personel'].length; x++) {
	    			var idofObject = idObject[i]['personel'][x]['ID'];

	    			if ($('#prs'+idofObject).val() == newValue) {
	    				itemCount += 1;
	    			}
	    		}
	       	}

	        if (itemCount > 0) {
	            duplicate = true;
	        }
	        return duplicate;
	    }

	    function getPersonelLookup() {
	    	$.ajax({
		        async:false,
		        type: "post",
		        url: "<?=base_url()?>PersonelController/ReadRaw",
		        data: {
		        	'NIK':'',
		        	'CabangID': $('#CabangIDLookup').val(),
		        	'Wilayah': $('#WilayahLookup').val(),
		        	'Provinsi' : $('#ProvIDLookup').val(),
		        	'Kota': $('#KotaIDLookup').val(),
		        	'DivisiID':$('#DivisiID').val(),
		        	'JabatanID':''
		        },
		        dataType: "json",
		        success: function (response) {
		          // PIC Kegiatan
		          // console.log(response.data)
		          bindGridLookup(response.data)
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
	                    caption: "Nama Divisi",
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

	    function GenerateObject() {
	    	$.ajax({
	        	async:false,
	        	url: "<?=base_url()?>CabangController/Read",
	        	type: 'POST',
	        	data: {
	        		'id' : '',
	        		'Area' : Wilayah,
	        		'ProvID' : Provinsi,
	        		'KotaID' : Kota
	        	},
	        	dataType: "json",
	        	success: function(response) {
	        	    // console.log(response.data)
	        	    var parentElement = document.querySelector('.accordion');
	        	    parentElement.innerHTML = "";
	        	    idObject.length = 0;
	        	    $.each(response.data,function (k,v) {
	        	    	// GenerateObjectName
	        	    	var IDText = generateRandomText(5);
	        	    // 	var item = {
			           //  	ID : IDText,
			           //  	Detail : []
			          	// }
			          	// idObject.push(item);
			          	// End Generate Object Name

	        	    	var newDiv = document.createElement('div');
	        	    	newDiv.classList.add('panel');
	        	    	newDiv.id = 'panel'+IDText;
	        	    	var xHTML = "";
	        	    	// Add Link Access Collaps;	
	        	    	xHTML += "<a class='panel-heading' role='tab' id='heading"+IDText+"' data-toggle='collapse' data-parent='#accordion' href='#collapse"+IDText+"' aria-expanded='true' aria-controls='collapseOne'>";
	        	    	xHTML += "<h4 class='panel-title'>"+v.CabangName+"</h4>";
	        	    	xHTML += "</a>"

	        	    	xHTML += "<div id='collapse"+IDText+"' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading"+IDText+"'>";
	        	    	xHTML += "<div class='panel-body'> ";
	        	    	xHTML += "<input type = 'hidden' value = '"+v.id+"' id='cabang"+IDText+"'>"

	        	    	// do inside this body
	        	    	xHTML +="<div class='table-responsive'>";
	        	    	xHTML +="<table class='table table-striped jambo_table bulk_action' id='PenugasanTable"+IDText+"'>";
	        	    	xHTML +="<thead><tr class='headings'>";
	        	    	xHTML += "<th class='column-title'>Ibadah </th>";
	        	    	xHTML += "<th class='column-title'>Personel </th>";
	        	    	xHTML += "<th class='column-title'>Action </th>";
	        	    	xHTML +="</tr> </thead>";

	        	    	xHTML +="<tbody> <tr class='even pointer'>";
	        	    	xHTML += "<td class=' '> </td>";
	        	    	xHTML += "<td class=' '> </td>";
	        	    	xHTML += "<td class=' '> </td>";
	        	    	xHTML += "</tr></tbody>";

	        	    	xHTML += "</table>";
	        	    	xHTML +="</div>";
	        	    	// do inside this body

	        	    	xHTML +="</div>"
	        	    	xHTML +="</div>"

	        	    	newDiv.innerHTML = xHTML;
						// Add Link Access Collaps;	        	    	


						parentElement.appendChild(newDiv);
						newGenerateDetail(IDText);
						deleteRow(IDText);
						GeneratePersonel(IDText);
						Autocollapse(IDText)
	        	    })
	        	},
	        	error: function(xhr, status, error) {
	        	    // Handle errors
	        	    console.log(error)
	        	    console.error('Error:', error);
	        	}
		    });
	    }

	    function newGenerateDetail(parentID) {
	    	// console.log('Generating Detail')
	    	$.ajax({
	    		async:false,
	        	url: "<?=base_url()?>JadwalIbadahController/ReadIbadahTemplate",
	        	type: 'POST',
	        	data: {
	        		'CabangID' : $('#cabang'+parentID).val(),
	        		'Hari' : $('#Hari').val(),
	        		'DivisiID' : $('#DivisiID').val()
	        	},
	        	dataType: "json",
	        	success: function(jadwalResponse) {
	        		// console.log(jadwalResponse)
	        		var table = document.getElementById('PenugasanTable'+parentID);
	        		var xrow = table.rows.length - 1;

	        		// console.log("Row Count " + xrow)
	        		var iliterateRow = 1;
	        		var xRowCount = 0;
	        		var totalRow = 0;
	        		rowCount = 1;

	        		$.each(jadwalResponse.data,function (k,v) {
	        			// console.log(xrow + " - " + iliterateRow)

	        			if (parseInt(iliterateRow) > parseInt(xrow)) {
	        				var newRow = document.createElement('tr');

				          	var cell1 = document.createElement('td');
				          	newRow.appendChild(cell1);

				          	var cell2 = document.createElement('td');
				          	newRow.appendChild(cell2);

				          	var cell3 = document.createElement('td');
				          	newRow.appendChild(cell3);

				          	table.appendChild(newRow);
	        			}

	        			var idText = generateRandomText(5)

	        			var item = {
	        				ParentID : parentID,
	        				Detail : idText,
	        				iliterateCount : parseInt(v.JumlahPelayan),
	        				personel : []
	        			}

	        			idObject.push(item)
	        			// Add Ibadah
	        			GenerateIbdah(parentID, idText, iliterateRow, v.id, v.NamaIbadah,parseInt(v.JumlahPelayan))

	        			iliterateRow += 1;
	        		});
	        		// console.log("_________________________________")
	        	}
	    	})
	    }

	    function GenerateIbdah(ParentID,ObjectID, Index, id, Nama, iliterateCount) {
	    	var table = document.getElementById('PenugasanTable'+ParentID);
	    	if (Index > 0) {
	    		// console.log(Index)
	    		for (var i = 0; i < iliterateCount; i++) {
	    			var newRow = document.createElement('tr');

		          	var cell1 = document.createElement('td');
		          	newRow.appendChild(cell1);

		          	var cell2 = document.createElement('td');
		          	newRow.appendChild(cell2);

		          	var cell3 = document.createElement('td');
		          	newRow.appendChild(cell3);

		          	table.appendChild(newRow);
	    		}
	    	}

	    	var selectIbadah = document.createElement('select');

	    	selectIbadah.id = 'ibd'+ObjectID;

	    	var option = document.createElement('option');
          	option.value = ""
            option.text = "Pilih Ibadah"
            selectIbadah.appendChild(option);

            var option = document.createElement('option');
            option.value = id;
            option.text = Nama;
            selectIbadah.appendChild(option);

            // console.log(Index + " + " + iliterateCount + " = " + rowCount )
            if (Index == 1) {
            	var row = table.rows[Index];
	          	var cell = row.cells[0];
	          	cell.appendChild(selectIbadah);
            }
            else{
            	var row = table.rows[rowCount];
	          	var cell = row.cells[0];
	          	cell.appendChild(selectIbadah);
            }

          	$('#ibd'+ObjectID).val(id).trigger('change');
          	$('#ibd'+ObjectID).select2({
            	width: '100%'
          	});

          	// console.log()

          	rowCount = rowCount + iliterateCount ;
	    }

	    function GeneratePersonel(ParentID) {
	    	// console.log('Generating Personel ' + ParentID)
	    	var table = document.getElementById('PenugasanTable'+ParentID);
	    	var tableRowCount = table.rows.length - 1;

	    	$.ajax({
		        async:false,
		        type: "post",
		        url: "<?=base_url()?>PersonelController/Read",
		        data: {'NIK':'','CabangID': $('#cabang'+ParentID).val(),'Wilayah': Wilayah,'Provinsi' : Provinsi,'Kota': Kota,'DivisiID':$('#DivisiID').val(),'JabatanID':'','NIKIn': ''},
		        dataType: "json",
		        success: function (responsePersonel) {
		          	// PIC Kegiata
		          	PersonelFill = responsePersonel.data
		        }
		    });

	    	var RowData = 1;
		    for (var i = 0; i < idObject.length; i++) {
		    	if (idObject[i]['ParentID'] == ParentID) {
		    		var tempItem = [];
			    	var iliterateCount = idObject[i].iliterateCount

			    	// console.log('ID ' + idObject[i]['Detail'] + ' iliterate : ' + RowData)
			    	for (var x = 0; x < iliterateCount; x++) {
			    		// Save IDData
			    		// console.log(idObject)
			    		var idText = generateRandomText(5)
			    		var item = {
			    			ID : idText
			    		}
			    		tempItem.push(item)

			    		// Generate Object

			    		var selectPersonil = document.createElement('select');
			    		selectPersonil.id = 'prs'+idText;

			    		var option = document.createElement('option');
			          	option.value = ""
		                option.text = "Pilih Pelayan"
		                selectPersonil.appendChild(option);

			          	$.each(PersonelFill,function (k,z) {
			          		var option = document.createElement('option');
			                option.value = z.NIK; // Set option value
			                option.text = z.Nama + ' - ' + z.NamaDivisi; // Set option text
			                selectPersonil.appendChild(option);
			          	});

			          	var row = table.rows[RowData];
			          	var cell = row.cells[1];
			          	cell.appendChild(selectPersonil);

			          	// $('#prs'+idText).val(NIK).trigger('change');
			          	$('#prs'+idText).select2({
			            	width: '100%'
			          	});

			          	var btDelete = document.createElement('button');
			          	var btAdd = document.createElement('button');
			          	var btSearch = document.createElement('button');


			          	// btDelete
			          	btDelete.id = 'btDel'+idText;
			          	btDelete.className = 'btn btn-danger';
			          	var icon = document.createElement('i');
			          	icon.className = 'success fa fa-trash';
			          	btDelete.appendChild(icon);
			          	btDelete.name = RowData;
			          	btDelete.customData = {
						    rowIndex: RowData
						};
			          	if (iliterateCount == 1) {
			          		btDelete.disabled = true
			          	}
			          	else{
			          		btDelete.disabled = false	
			          	}

			          	// btAdd
			          	btAdd.id = 'btAdd'+idText;
			          	btAdd.className = 'btn btn-success';
			          	btAdd.textContent = '+';
			          	btAdd.customData = {
						    rowIndex: RowData
						};
			          	// btSearch
			          	btSearch.id = 'btSec'+idText;
			          	btSearch.className = 'btn btn-warning';
			          	btSearch.textContent = 'Cari Data';
			          	btSearch.Name = RowData;
			          	btSearch.customData = {
						    rowIndex: RowData
						};

			          	btDelete.addEventListener('click', function() {
			          		var buttonID = this.id;
						    handleButtonClick(buttonID, ParentID);
						});

						btAdd.addEventListener('click', function() {
			          		var buttonID = this.id;
						    handleButtonClick(buttonID, ParentID);
						});

						btSearch.addEventListener('click', function() {
			          		var buttonID = this.id;
						    handleButtonClick(buttonID, ParentID);
						});

			          	var row = table.rows[RowData];
			          	var cell = row.cells[2];
			          	cell.appendChild(btDelete);
			          	cell.appendChild(btAdd);
			          	cell.appendChild(btSearch);

			          	// btDelete.onclick = function () {
			          	// 	handleButtonClick(btDelete,ParentID,idText);
			          	// }

			    		RowData += 1;
			    	}
			    	idObject[i]['personel'] = tempItem;
		    	}
		    }

		    // console.log(idObject)
	    }

	    function deleteRow(ParentID) {
	    	// console.log('Deleting Row Detail')
	    	var table = document.getElementById('PenugasanTable'+ParentID);
	    	var tableRowCount = table.rows.length - 1;
	    	// console.log(rowCount + " - " + tableRowCount)

	    	for (var i = 0; i < tableRowCount - rowCount; i++) {
	    		table.deleteRow(tableRowCount - (i +1));
	    	}

	    	// console.log(idObject)
	    }

	    function Autocollapse(ID) {
	    	$('#heading'+ID).trigger('click');
	    }

	    function generateNewObject(ParentID, IbadahID, PersonelID) {
	    	var table = document.getElementById('PenugasanTable'+ParentID);
	    	var tableRowCount = table.rows.length - 1;

          	var rowIndex = -1;

          	for (var i = 0; i < idObject.length; i++) {
          		// Things[i]
          		// console.log('List : ' + idObject[i]['Detail'] + " - " + IbadahID)
          		if (idObject[i]['Detail'] == PersonelID) {
          			rowIndex = i;
          			break;
          		}
          	}

          	// console.log()
          	var LastID = "";
          	for (var i = 0; i < tableRowCount; i++) {
          		var tdElement = table.rows[i+1].cells[1];
	    		var selectElement = tdElement.querySelector('select')

	    		if (selectElement !== null) {
	    			// console.log(selectElement.id + " => " + PersonelID)
	    			if (selectElement.id.substring(3, selectElement.id.length) == PersonelID){
	    				LastID = selectElement.id
	    				rowIndex = i
	    				break;
	    			}
	    			// console.log();
	    		}

          	}

          	var newRow = table.insertRow(rowIndex + 2);
          	var cell1 = newRow.insertCell(0);
			var cell2 = newRow.insertCell(1);
			var cell3 = newRow.insertCell(2);

          	var idText = generateRandomText(5)
    		var item = {
    			ID : idText
    		}

    		for (var i = 0; i < idObject.length; i++) {
    			// Things[i]
    			// console.log(idObject[i]['Detail'] + " == " + IbadahID)
    			if (idObject[i]['Detail'] == IbadahID) {
					idObject[i]['personel'].push(item);    				
					break
    			}
    		}

    		// idObject[rowIndex]['personel'].push(item);
    		// console.log(idObject[rowIndex])

    		var selectPersonil = document.createElement('select');
    		selectPersonil.id = 'prs'+idText;

    		var option = document.createElement('option');
          	option.value = ""
            option.text = "Pilih Pelayan"
            selectPersonil.appendChild(option);

          	$.each(PersonelFill,function (k,z) {
          		var option = document.createElement('option');
                option.value = z.NIK; // Set option value
                option.text = z.Nama + ' - ' + z.NamaDivisi; // Set option text
                selectPersonil.appendChild(option);
          	});

          	var row = table.rows[rowIndex + 2];
          	var cell = row.cells[1];
          	cell.appendChild(selectPersonil);

          	// $('#prs'+idText).val(NIK).trigger('change');
          	$('#prs'+idText).select2({
            	width: '100%'
          	});

          	var btDelete = document.createElement('button');
          	var btAdd = document.createElement('button');
          	var btSearch = document.createElement('button');


          	// btDelete
          	btDelete.id = 'btDel'+idText;
          	btDelete.className = 'btn btn-danger';
          	var icon = document.createElement('i');
          	icon.className = 'success fa fa-trash';
          	btDelete.appendChild(icon);
          	btDelete.name = rowIndex + 2;
          	btDelete.customData = {
			    rowIndex: rowIndex + 2
			};

          	// btAdd
          	btAdd.id = 'btAdd'+idText;
          	btAdd.className = 'btn btn-success';
          	btAdd.textContent = '+';

          	// btSearch
          	btSearch.id = 'btSec'+idText;
          	btSearch.className = 'btn btn-warning';
          	btSearch.textContent = 'Cari Data';
          	btSearch.Name = rowIndex + 2;

          	btAdd.addEventListener('click', function() {
          		var buttonID = this.id;
          		// console.log(buttonID)
			    handleButtonClick(buttonID, ParentID);
			});

          	btDelete.addEventListener('click', function() {
          		var buttonID = this.id;
          		// console.log(buttonID)
			    handleButtonClick(buttonID, ParentID);
			});



          	var row = table.rows[rowIndex + 2];
          	var cell = row.cells[2];
          	cell.appendChild(btDelete);
          	cell.appendChild(btAdd);
          	cell.appendChild(btSearch);


          	// Updateing DataIndex

          	table = document.getElementById('PenugasanTable'+ParentID);
	    	tableRowCount = table.rows.length - 1;

          	for (var i = 0; i< idObject; i++) {
          		var add = document.getElementById('btAdd'+idText);
          		var del = document.getElementById('btDel'+idText);
          		var search = document.getElementById('btSec'+idText);

          		btAdd.customData = {
				    rowIndex: i
				};

				btDelete.customData = {
				    rowIndex: i
				};

				btSearch.customData = {
				    rowIndex: i
				};
          	}

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

	    function handleButtonClick(button, TableID) {
		    // var buttonId = button.id;
		    var randomID = button.substring(5,button.length);
		    var btnName = button.substring(0,5);
		    var idText = generateRandomText(5)

		    var table = document.getElementById('PenugasanTable'+TableID);
	    	var xrow = table.rows.length - 1;

		    if (btnName == 'btAdd') {
		    	// console.log(button)
		    	var RowData = document.getElementById(button);
		    	var customData = RowData.customData;

		    	// console.log(customData)
		    	var LastID = "";
		    	for (var i = 0; i < customData.rowIndex; i++) {
		    		// Things[i]
		    		var tdElement = table.rows[i+1].cells[0];
		    		var selectElement = tdElement.querySelector('select')

		    		if (selectElement !== null) {
		    			// console.log();
		    			LastID = selectElement.id
		    		}
		    	}

		    	// LastID.substring(3, LastID.length)
		    	generateNewObject(TableID,LastID.substring(3, LastID.length),randomID);
		    }
		    else if (btnName == "btDel") {
		    	var RowData = document.getElementById(button);
		    	var customData = RowData.customData;
		    	
		    	table.deleteRow(customData.rowIndex)

		    	for (var x = 0; x < idObject.length; x++) {
		    		var removedIndex = -1;
		    		for (var i = 0; i < idObject['personel']; i++) {
						// Things[i]
						if (idObject['personel'][i]['ID'] == randomID) {
							removedIndex +=1;
							break;
						}
					}

					// Remove Object
					idObject[x]['personel'].splice(removedIndex, 1);
		    	}

				// idObject = newArray;

				for (var i = 0; i < idObject.length; i++) {
					if (idObject[i]['personel'].length == 1) {
						$('#btDel'+idObject[i]['personel'][0]['ID']).prop('disabled', true);
					}
				}
		    }
		    else if (btnName == "btSec") {
		    	$('#modal_').modal('show');
		    	$('#objectID').val(randomID);
		    	// console.log(button)
		    }

		    // console.log(idObject)
		}
	})
</script>