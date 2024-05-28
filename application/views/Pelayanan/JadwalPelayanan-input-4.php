<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>

<style>
    #loadingIndicator {
        display: none; /* Hidden by default */
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        border: 1px solid #ccc;
        padding: 20px;
        background-color: #fff;
        z-index: 1000; /* Ensure it's on top */
    }
</style>

<div class="right_col" role="main">
	<div class="">
		<div class="clearfix"></div>
		<div class="row"  style="display: block;">
			<div class="col-md-12 col-sm-12  ">
				<div class="x_panel">
					<div class="x_title">
			            <?php 
			              if ($penugasan) {
			                echo "<h2 id='formtitle'>Edit Jadwal Pelayanan</h2>";
			                echo "<input type='hidden' id='formtype' value = 'edit'>";
			                echo '<textarea  id="headerData" style ="display:none;">'.json_encode($penugasan).'</textarea>';
			              }
			              else{
			                echo "<h2 id='formtitle'>Tambah Jadwal Pelayanan</h2>";
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
			        				<label class="col-form-label col-md-2 col-sm-2" for="first-name">Tanggal <span class="required">*</span>
				                    </label>
				                    <div class="col-md-4 col-sm-4 ">
				                      <input type="date" name="TglTransaksi" id="TglTransaksi" required="" class="form-control " value = "<?php echo ($header) ? $header[0]->TglTransaksi : '' ?>">
				                    </div>

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

			        		<div class="col-md-12 col-sm-12">
			        			asdasd
			        			<div id="loadingIndicator">Loading...</div>
			        		</div>

			        		<div class="col-md-12 col-sm-12">
			        			<div class="dx-viewport demo-container">
				                  <div id="data-grid-demo">
				                    <div id="gridContainerPersonel">
				                    </div>
				                  </div>
				                </div>
			        		</div>
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
		let ajaxCount = 0;
		$(document).on({
		    ajaxStart: function(){
		    	console.log('Loading')
		        // $("body").addClass("loading"); 
		    },
		    ajaxStop: function(){ 
		    	console.log('Eding')
		        // $("body").removeClass("loading"); 
		    }    
		});
		$(document).ready(function () {
			

			var oData = [];
			// bindGridPersonel(oData);
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
	    	showDataEdit()
		});

		// Hari Change
		$('#TglTransaksi').change(function () {
			// console.log('Change Date')
	    	var timestamp = Date.parse($('#TglTransaksi').val());
	    	var dateObject = new Date(timestamp);
	    	var dayName = dateObject.toLocaleString('en-US', { weekday: 'long' });

	    	// console.log(dayName);
	    	$('#Hari').val(dayName).trigger('change');

	    	$.ajax({
		        async:false,
		        type: "post",
		        url: "<?=base_url()?>PenugasanController/ReadIfExist",
		        data: {
		        	'Tanggal':$('#TglTransaksi').val(),
		        	'Hari': $('#Hari').val(),
		        	'DivisiID': $('#DivisiID').val(),
		        },
		        dataType: "json",
		        success: function (response) {
		        	if (response.data.length > 0) {
		        		$('#formtitle').text('Edit Jadwal Pelayanan');
		        		$('#headerData').val(JSON.stringify(response.data));
		        		$('#formtype').val('edit');
		        		GenerateGridData();
		        	}
		        	else{
		        		$('#formtitle').text('Tambah Jadwal Pelayanan');
		        		GenerateGridData();
		        	}
		      	},
		    });
	    	// getJadwal();
	    	// getPersonel();
	    });

	    $('#DivisiID').change(function () {

	    	$.ajax({
		        async:false,
		        type: "post",
		        url: "<?=base_url()?>PenugasanController/ReadIfExist",
		        data: {
		        	'Tanggal':$('#TglTransaksi').val(),
		        	'Hari': $('#Hari').val(),
		        	'DivisiID': $('#DivisiID').val(),
		        },
		        dataType: "json",
		        success: function (response) {
		        	if (response.data.length > 0) {
		        		$('#formtitle').text('Edit Jadwal Pelayanan');
		        		$('#headerData').val(JSON.stringify(response.data));
		        		$('#formtype').val('edit');
		        	}
		        	else{
		        		$('#formtitle').text('Tambah Jadwal Pelayanan');
		        		$('#formtype').val('add');
		        	}
		      	},
		    });
	    	GenerateGridData();
	    	// GenerateObjectDetail();
	    });

	    $('#btSave').click(function () {
	    	var dataGridInstance = jQuery('#gridContainerPersonel').dxDataGrid('instance');
      		var allRowsData  = dataGridInstance.getDataSource().items();

      		var oDetail =[];
      		console.log(allRowsData)
      		$.each(allRowsData,function (k,v) {
      			if (v.items != null) {
      				$.each(v.items,function (k,y) {
      					if (y.items != null) {
      						$.each(y.items,function (k,z) {
      							if (z.NamaPersonel != "") {
      								// console.log(z)
      								var item = {
					    				'NoTransaksi'	: ($('#formtype').val() == 'add') ? '' : $('#NoTransaksi').val(),
					    				'DivisiID'		: $('#DivisiID').val(),
					    				'Tanggal'		: $('#TglTransaksi').val(),
					    				'Hari'			: $('#Hari').val(),
					    				'CabangID'		: z.CabangID,
					    				'JadwalIbadahID': z.JadwalIbadahID,
					    				'PIC'			: z.NamaPersonel,
					    				'Keterangan' 	: $('#Keterangan').val()
					    			}

					    			oDetail.push(item);
      							}
      						})
      					}
      				})
      			}
      		})
	   //  	$('#btSave').text('Tunggu Sebentar.....');
  		// 	$('#btSave').attr('disabled',true);

	    	var json_object = {
	    		formtype : $('#formtype').val(),
	    		detail : oDetail
	    	};

	    	console.log(json_object);

	   //  	for (var i = 0; i < idObject.length; i++) {
	   //  		for (var x = 0; x < idObject[i]['personel'].length; x++) {
	   //  			console.log($('#prs'+idObject[i]['personel'][x]['ID']).val())
	   //  			if ($('#prs'+idObject[i]['personel'][x]['ID']).val() != "") {
	    				// var item = {
		    			// 	'NoTransaksi'	: ($('#formtype').val() == 'add') ? '' : $('#NoTransaksi').val(),
		    			// 	'DivisiID'		: $('#DivisiID').val(),
		    			// 	'Tanggal'		: $('#TglTransaksi').val(),
		    			// 	'Hari'			: $('#Hari').val(),
		    			// 	'CabangID'		: $('#cabang'+idObject[i]['ParentID']).val(),
		    			// 	'JadwalIbadahID': $('#ibd'+idObject[i]['Detail']).val(),
		    			// 	'PIC'			: $('#prs'+idObject[i]['personel'][x]['ID']).val(),
		    			// 	'Keterangan' 	: $('#Keterangan').val()
		    			// }

		    			// json_object['detail'].push(item);
	   //  			}
	   //  		}
	   //  	}

  			$.ajax({
	        	async:false,
	        	url: "<?=base_url()?>PenugasanController/CRUD",
	        	type: 'POST',
	        	contentType: 'application/json',
	        	data: JSON.stringify(json_object),
	        	beforeSend: function( xhr ) {
					showLoadingAlert("Saving Data");
		        },
	        	success: function(response) {
	        	    // Handle the response from the controller
	        	    // console.log('Response from controller:', response);
	        	    Swal.close();
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
	        	},
	        	complete:function(res){
					Swal.close();
				}
		    });
	    })

	    // $('#btAdd').click(function () {
	    // 	addPenugasanObject();
	    // })

	     function showDataEdit(data) {
	    	if ($('#headerData').val() != "") {
	    		var headerData = $.parseJSON($('#headerData').val());

	    		if (headerData.length > 0) {
	    			for (var i = 0; i < headerData.length; i++) {
	    				// Things[i]
	    				// console.log(i + " - " + headerData.length)
	    				if (i+1 == headerData.length) {
	    					$('#NoTransaksi').val(headerData[i]['NoTransaksi']);
	    					$('#TglTransaksi').val(headerData[i]['Tanggal']);
	    					$('#Hari').val(headerData[i]['Hari']).trigger('change');
	    					$('#DivisiID').val(headerData[i]['DivisiID']).trigger('change');
	    					$('#Keterangan').val(headerData[i]['Keterangan']);
	    				}
	    			}
	    		}
	    	}
	    }

	    function GenerateGridData() {
	    	var xData = [];
	    	var editedRowData = [];
	    	$.ajax({
	        	async:false,
	        	url: "<?=base_url()?>PenugasanController/ReadDetail",
	        	type: 'POST',
	        	data: {'NoTransaksi':$('#NoTransaksi').val()},
	        	success: function(response) {
	        		editedRowData = response.data;
	        	},
	        	error: function(xhr, status, error) {
	        	    // Handle errors
	        	    console.error('Error:', error);
	        	},
		    });

		    console.log("Wilayah : " + Wilayah);
		    console.log("Provinsi : " + Provinsi);
		    console.log("Kota : " + Kota);

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
	        		var id = 0;
	        		$.each(response.data,function (k,v) {
	        			$.ajax({
				    		async:false,
				        	url: "<?=base_url()?>JadwalIbadahController/ReadIbadahTemplate",
				        	type: 'POST',
				        	data: {
				        		'CabangID' : v.id,
				        		'Hari' : $('#Hari').val(),
				        		'DivisiID' : $('#DivisiID').val()
				        	},
				        	dataType: "json",
				        	success: function(jadwalResponse) {
				        		$.each(jadwalResponse.data,function (y,x) {
				        			var Nomor = 1;
				        			$.ajax({
								        async:false,
								        type: "post",
								        url: "<?=base_url()?>PersonelController/Read",
								        data: {'NIK':'','CabangID': v.id,'Wilayah': Wilayah,'Provinsi' : Provinsi,'Kota': Kota,'DivisiID':$('#DivisiID').val(),'JabatanID':'','NIKIn': ''},
								        dataType: "json",
								        success: function (responsePersonel) {
								          	$.each(responsePersonel.data,function (z,a) {
								          		var item = {
								          			'id' : id,
								          			'CabangID'	 : v.id,
													'CabangName' : v.CabangNameFormated,
													'JadwalIbadahID' : x.id,
													'NamaIbadah' : x.NamaIbadahFormated,
													'Nomor' : Nomor,
													'NIK' : '',
													'Nama' : '',
													'NamaPersonel' : ''
												}

												let exist = PersonelFill.find(personel => personel.NIK === a.NIK);
									        	if (!exist) {
									        		var temp = {
									        			'NIK' : a.NIK,
									        			'Nama' : a.Nama
									        		}
									        		PersonelFill.push(temp);
									        	};

									        	xData.push(item);
												Nomor += 1;
												id +=1;
								          	})
								        },
								    });
				        		});
				        	}
				        });
	        		});
	        	},
	        });


	        let filterdData = [];

	        for (var i = 0; i < xData.length; i++) {
	        	$.each(editedRowData,function (z,b) {
        			if (xData[i]['CabangID'] == b.CabangID && xData[i]["JadwalIbadahID"] == b.JadwalIbadahID) {
        				let exist = xData.find(hasExist => hasExist.NamaPersonel === b.PIC);
        				if (!exist) {
        					xData[i]['NamaPersonel'] = b.PIC
        				}
        			}
        		})
	        }
	        
	        bindGridPersonel(xData)
	    }
	    function bindGridPersonel(data) {
	    	var dataGridInstance = $("#gridContainerPersonel").dxDataGrid({
		        allowColumnResizing: true,
		        dataSource: data,
		        keyExpr: "id",
		        showBorders: true,
		        allowColumnReordering: true,
		        allowColumnResizing: true,
		        columnAutoWidth: true,
		        showBorders: true,
		        paging: {
		            enabled: false
		        },
		        searchPanel: {
		            visible: true,
		            width: 240,
		            placeholder: "Search..."
		        },
		        grouping: {
		            // ...
		            autoExpandAll: false, 
		        },
		        editing: {
	                mode: "row",
	                allowUpdating: true,
	                texts: {
	                    confirmDeleteMessage: ''  
	                }
	            },
		        columns: [
		            {
		                dataField: "CabangName",
		                caption: "",
		                allowEditing:false,
		                groupIndex : 0
		            },
		            {
		                dataField: "CabangID",
		                caption: "CabangID",
		                allowEditing:false,
		                // groupIndex : 0,
		                visible:false
		            },
		            {
		                dataField: "NamaIbadah",
		                caption: "",
		                allowEditing:false,
		                groupIndex : 1
		            },
		            {
		                dataField: "JadwalIbadahID",
		                caption: "",
		                allowEditing:false,
		                // groupIndex : 1,
		                visible:false
		            },
		            {
		                dataField: "Nomor",
		                caption: "#",
		                allowEditing:false,
		                width:30
		            },
		            {
		                dataField: "NamaPersonel",
		                caption: "Personel",
		                allowEditing:true,
		                lookup: {
						    dataSource: PersonelFill,
						    valueExpr: 'NIK',
						    displayExpr: 'Nama',
					    },
		            }
		        ],
		        onContentReady: function(e) {
		            // Trigger edit mode for the first row (index 0) when the grid content is ready
		            // console.log(dataGridInstance.option("dataSource"))
		            var rowData = dataGridInstance.option("dataSource");
		            if (rowData.length == 1) {
		            	dataGridInstance.editRow(0)	
		            }
		            // dataGridInstance.editRow(0)
		            // dataGridInstance.editRow(0);
		        },
		        onCellClick:function (e) {
		        	// console.log(dataGridInstance.option("dataSource"))
		            var rowData = dataGridInstance.option("dataSource");
		            var columnIndex = e.columnIndex;
		        	if (columnIndex >= 1 && columnIndex <= 5) {
		                dataGridInstance.editRow(e.rowIndex)	
		            }
		            dataGridInstance.option("focusedColumnIndex", columnIndex);	
		        },
		    }).dxDataGrid('instance');

	    	dataGridInstance.on('editorPreparing',function (e) {
	        	if (e.parentType === "dataRow" && e.dataField === "NamaPersonel") {
	        		e.editorOptions.onFocusOut = (x) => {
	        			// dataGridInstance.refresh()
	        			dataGridInstance.saveEditData();
	        		}
	        	}
	        });

	        dataGridInstance.on('rowUpdated', function(e) {
        		console.log(e)
        		var allRowsData  = dataGridInstance.getVisibleRows();
        		console.log(allRowsData)
        	})
	    }

	    function showLoadingAlert(LoadingTitle) {
		  Swal.fire({
		    title: 'Loading',
		    text: 'Please wait, Loading ' + LoadingTitle,
		    allowOutsideClick: false,
		    showConfirmButton: false,
		    onBeforeOpen: () => {
		      Swal.showLoading();
		    }
		  });
		}
	})
</script>