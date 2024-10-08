<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<style type="text/css">
	.dx-datagrid .dx-data-row {
	    white-space: normal !important;
	    word-wrap: break-word;  
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
            <!-- <h2>Jadwal Pelayanan</h2> -->
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
              <select class="form-control select2Selector" id="CabangIDFilter" name="CabangIDFilter" >
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
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <hr>
                <div class="dx-viewport demo-container">
                  <div id="data-grid-demo">
                    <div id="gridContainerHeader">
                    </div>
                  </div>
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

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
		    	<h4 class="modal-title" id="myModalLabel">Transaksi Biaya</h4>
		    	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
		    	</button>
		    </div>

		    <div class="modal-body">
		    	<form id="post_" data-parsley-validate class="form-horizontal form-label-left">
		    		<div class="item form-group">
			            <label class="col-form-label col-md-2 col-sm-2" for="first-name">NoTransaksi <span class="required">*</span>
			            </label>
			            <div class="col-md-4 col-sm-4 ">
			              <input type="text" name="NoTransaksi" id="NoTransaksi" readonly="" placeholder="<AUTO>" class="form-control ">
			              <input type="hidden" name="formtype" id="formtype" value="add">
			            </div>

			            <label class="col-form-label col-md-2 col-sm-2" for="first-name">Tanggal <span class="required">*</span>
			            </label>
			            <div class="col-md-4 col-sm-4 ">
			              <input type="date" name="TglTransaksi" id="TglTransaksi" required="" class="form-control ">
			            </div>
			        </div>

			        <div class="item form-group">
			            <label class="col-form-label col-md-2 col-sm-2" for="first-name">Cabang <span class="required">*</span>
			            </label>
			            <div class="col-md-10 col-sm-10 ">
			            	<select class="form-control select2Selector" id="CabangID" name="CabangID" >
			            		<option value="0">Pilih Cabang</option>
				                <?php

				                  foreach ($Cabang as $key) {
				                    echo "<option value = '".$key->id."'>".$key->CabangName."</option>";
				                  }
				                ?>
				            </select>
			            </div>
			        </div>

			        <div class="item form-group">
			            <label class="col-form-label col-md-2 col-sm-2" for="first-name">Akun Kas <span class="required">*</span>
			            </label>
			            <div class="col-md-10 col-sm-10 ">
			            	<select class="form-control select2Selector" id="KodeAkunKas" name="KodeAkunKas">
				            </select>
			            </div>
			        </div>

			        <div class="item form-group">
			            <label class="col-form-label col-md-2 col-sm-2" for="first-name">Jumlah <span class="required">*</span>
			            </label>
			            
			            <input type="text" name="Total" id="Total" required="" class="form-control " value="0" >
			        </div>

			        <div class="item form-group">
			            <label class="col-form-label col-md-2 col-sm-2" for="first-name">Keterangan <span class="required">*</span>
			            </label>
			            
			            <input type="text" name="Keterangan" id="Keterangan"  class="form-control " value="">
			        </div>

			        <div class="col-md-12 col-sm-12">
			        	<center>
			        		<button class="btn btn-danger" id="btn_Save">Simpan</button>
			        	</center>
		          	</div>
		    	</form>
		    </div>
		</div>
	</div>
</div>

<?php
  require_once(APPPATH."views/parts/Footer.php");
?>
<script type="text/javascript">
	$(function () {
		var CabangID = "<?php echo $CabangID; ?>"
		var ApprovalSelectedRow = [];
		var ColumnWidth = 0
		$(document).ready(function () {
			const userAgent = navigator.userAgent.toLowerCase();
			const isMobile = /mobile|android|iphone|ipad|ipod|blackberry|iemobile|opera mini/.test(userAgent);

			// console.log(userAgent)
			if (isMobile) {
				ColumnWidth = 150;
			}
			else{
				ColumnWidth = 450
			}

			$('.select2Selector').select2({
				width: '100%'
			})

		    if (CabangID != 0) {
		        $('#CabangID').prop('disabled', true);
		        $('#CabangID').val(CabangID).trigger('change');

		        $('#CabangIDFilter').prop('disabled', true);
		        $('#CabangIDFilter').val(CabangID).trigger('change');
		    }

		    var now = new Date();
		    var day = ("0" + now.getDate()).slice(-2);
		    var month = ("0" + (now.getMonth() + 1)).slice(-2);
		    var today = now.getFullYear()+"-"+month+"-01";
		    var lastDayofYear = now.getFullYear()+"-"+month+"-"+day;

		    $('#TglAwal').val(today);
		    $('#TglAkhir').val(lastDayofYear);
		    $('#TglTransaksi').val(lastDayofYear);

		    $('#btApprove').prop('disabled',true);

		    getHeader();
		});


		$('#btn_Add').click(function () {
			// $('#modal_').modal('show');
			$('#modal_').modal({backdrop: 'static', keyboard: false})
			$('#modal_').modal('show');
		});

		$('#CabangID').change(function () {
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

		        }
		      });
		});

		$('#Total').on('blur', function() {
	        formatCurrency($(this),$(this).val());
	    });

	    $('#Total').focus(function () {
	    	var originalvalue = $('#Total').attr("originalvalue")
	    	$('#Total').val(originalvalue);
	    })


	    $('#post_').submit(function (e) {
	      $('#btn_Save').text('Tunggu Sebentar.....');
	      $('#btn_Save').attr('disabled',true);
	      $('#Total').val($('#Total').attr("originalvalue"))

	      $(this).find(':input:disabled').prop('disabled', false);
	      e.preventDefault();
	      var me = $(this);

	      var formData = new FormData(this);
	      formData.append('TipeTransaksi', '2');
	      formData.append('BaseType', 'BY');
	      formData.append('NoReff', '-');
	      $.ajax({
	        type    :'post',
	        url     : '<?=base_url()?>TransaksiKasController/CRUD',
	        data    : formData,
	        processData: false,
           	contentType: false,
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

	    $('#btApprove').click(function () {
	    	GetData(ApprovalSelectedRow[0].NoTransaksi, ApprovalSelectedRow[0].CabangID);
	    })

	    // Bind Grid
	    function getHeader() {
	      $.ajax({
	        type: "post",
	        url: "<?=base_url()?>TransaksiKasController/Read",
	        data: {
	          'TglAwal':$('#TglAwal').val(),
	          'TglAkhir' : $('#TglAkhir').val(),
	          'Transaksi' : '',
	          'BaseType':'BY',
	          'CabangID' : $('#CabangID').val()
	      	},
	        dataType: "json",
	        success: function (response) {
	          bindGridHeader(response.data);
	        }
	      });
	    }

	    function getDetail(NoTransaksi, xCabangID) {
	      $.ajax({
	        type: "post",
	        url: "<?=base_url()?>TransaksiKasController/ReadDetail",
	        data: {NoTransaksi:NoTransaksi, CabangID:xCabangID},
	        dataType: "json",
	        success: function (response) {
	          bindGridDetail(response.data);
	        }
	      });
	    }

	    function GetData(NoTransaksi,CabangID) {
	      $.ajax({
	        type: "post",
	        url: "<?=base_url()?>TransaksiKasController/Find",
	        data: {'NoTransaksi':NoTransaksi, CabangID:CabangID},
	        dataType: "json",
	        success: function (response) {
	          $.each(response.data,function (k,v) {
	            $('#formtype').val("edit");
	            $('#CabangID').val(v.CabangID).trigger('change');
	            $('#KodeAkunAsal').val(v.KodeAkunAsal).trigger('change');
	            $('#KodeAkunTujuan').val(v.KodeAkunTujuan).trigger('change');
	            $('#Total').val(v.Total);
	            formatCurrency($('#Total'), v.Total)

	            $('#Keterangan').val(v.Keterangan);
	            $('#NoTransaksi').val(v.NoTransaksi);

	            $('#modal_').modal({backdrop: 'static', keyboard: false})
				$('#modal_').modal('show');
	          });
	        }
	      });
	    }

	    function bindGridHeader(data) {
	    	var canAdd = "<?php echo $canAdd; ?>";
		    var canEdit = "<?php echo $canEdit; ?>";
		    var canDelete = "<?php echo $canDelete; ?>";

	    	var dataGridInstance = $("#gridContainerHeader").dxDataGrid({
	    		allowColumnResizing: true,
		        dataSource: data,
		        // keyExpr: "NoTransaksi",
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
		            // allowUpdating: canEdit,
		            // allowDeleting: canDelete,
		            allowAdding:canAdd,
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
		            fileName: "Daftar Jadwal Pelayanan"
		        },
		        selection:{
		            mode: "single"
		        },
		        columns: [
		        	{
		              dataField: "NoTransaksi",
		              caption : "Nomor",
		              allowEditing: false,
		              visible:false
		            },
		            {
		              dataField: "Approved",
		              caption : "Approved",
		              allowEditing: false,
		              visible:false
		            },
		            // {
              //       dataField: "FileItem",
	             //        caption: "Action",
	             //        allowEditing:false,
	             //        cellTemplate: function(cellElement, cellInfo) {
	             //        	var isDisabled = (cellInfo.data.Approved == 1);
	             //          $("<div>")
	             //            .append(
	             //                $("<button>")
	             //                    .text("Approve")
	             //                    .addClass("dx-button")
	             //                    .prop("disabled", isDisabled)
	             //                    .on("click", function(e) {
	             //                        // Prevent the default action
	             //                        e.preventDefault();
	             //                        // Call the event handler
	             //                        GetData(cellInfo.data.NoTransaksi, cellInfo.data.CabangID);
	             //                    })
	             //            )
	             //            .appendTo(cellElement);
	             //      }
	             //    },
		            {
		              dataField: "NamaAkun",
		              caption : "Biaya",
		              allowEditing: false,
		              wordWrapEnabled:true,
		              width:ColumnWidth
		            },
		            {
		                dataField: "Total",
		                caption: "Total",
		                allowEditing:false,
		                dataType: 'number',
		                format: { type: 'fixedPoint', precision: 2 }
		            },
		            {
		                dataField: "Keterangan",
		                caption: "Keterangan",
		                allowEditing:false
		            },
		            {
		                dataField: "CabangID",
		                caption: "CabangID",
		                allowEditing:false,
		                visible:false
		            },
		        ],
		        onEditingStart: function(e) {
	                // GetData(e.data.NoTransaksi, e.data.CabangID);
	            },
	            onInitNewRow: function(e) {
	                // logEvent("InitNewRow");
	                $('#modal_').modal('show');
	            },
	    	}).dxDataGrid('instance');

	    	dataGridInstance.on('selectionChanged', function(e) {
		        var selectedRows = e.selectedRowsData;
		        var isDisabled = (selectedRows[0].Approved == 1);
		        if (selectedRows.length > 0) {
		          // getDetail(selectedRows[0].NoTransaksi,selectedRows[0].CabangID)
		          // GetData();
		          $('#btApprove').prop('disabled',isDisabled);
		          ApprovalSelectedRow = selectedRows;
		          // GetData(selectedRows[0].NoTransaksi, selectedRows[0].CabangID);
		        }
		        else{
		        	$('#btApprove').prop('disabled',isDisabled);
		        }
		    });
	    }
	})

	function formatCurrency(input, amount) {
		input.attr("originalvalue", amount);
        let formattedAmount = parseFloat(amount).toLocaleString('en-US');

        // Set the formatted value to the input field
        input.val(formattedAmount);
    }
</script>