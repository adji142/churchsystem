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
            <!-- <h2>Akun Kas</h2> -->
            <div class="row">
              <h2>Transaksi Setor Tunai</h2>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 " for="first-name">Cabang <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 ">
                    <select class="form-control" id="CabangID" name="CabangID" >
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
                  <label class="col-form-label col-md-3 col-sm-3 " for="first-name">No. Transaksi <span class="required">*</span>
                  </label>
                  <div class="col-md-3 col-sm-3 ">
                    <input type="text" name="NoTransaksi" id="NoTransaksi" placeholder="<AUTO>" class="form-control " readonly>
                    <input type="hidden" name="formtype" id="formtype" value="add">
                    <input type="hidden" name="BaseType" id="BaseType" value="KAS">
                  </div>

                  <label class="col-form-label col-md-2 col-sm-2 " for="first-name">Tgl. Transaksi <span class="required">*</span>
                  </label>
                  <div class="col-md-3 col-sm-3 ">
                    <input type="date" name="TglTransaksi" id="TglTransaksi" placeholder="<AUTO>" class="form-control " >
                  </div>
                </div>

                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 " for="first-name">Bank Tujuan <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 ">
                    <select class="form-control" id="KodeBank" name="KoKodeBankdeAkunKas" >
                    </select>
                  </div>
                </div>

                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 " for="first-name">Total <span class="required">*</span>
                  </label>
                  <div class="col-md-3 col-sm-3 ">
                    <input type="number" name="Total" id="Total" required="" placeholder="Total" class="form-control " readonly="">
                  </div>

                  <label class="col-form-label col-md-2 col-sm-2" for="first-name">No Reff <span class="required">*</span>
                  </label>
                  <div class="col-md-3 col-sm-3 ">
                    <input type="text" name="NoReff" id="NoReff" required="" placeholder="No. Refrensi" class="form-control ">
                  </div>
                </div>

                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Keterangan <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 ">
                    <input type="text" name="Keterangan" id="Keterangan" required="" placeholder="Keterangan" class="form-control ">
                  </div>
                </div>

              </div>
              <div class="col-md-12 col-sm-12  ">
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
        <div class="col-md-12 col-sm-12  ">
          <div class="dx-viewport demo-container">
            <div id="data-grid-demo">
              <div id="gridLookupAkunKas">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-sm-12  ">
          <button class="btn btn-primary" id="btn_Select">Pilih</button>
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
    var CabangID = "<?php echo $CabangID; ?>";
    $(document).ready(function () {
      $('#CabangID').select2({
        width: '100%'
      });

      $('#KodeBank').select2({
        width: '100%'
      });

      var now = new Date();
      var day = ("0" + now.getDate()).slice(-2);
      var month = ("0" + (now.getMonth() + 1)).slice(-2);
      var today = now.getFullYear()+"-"+month+"-01";
      var lastDayofYear = now.getFullYear()+"-"+month+"-"+day;

      $('#TglTransaksi').val(lastDayofYear);
    });

    function bindGridLookup(data) {
      var dataGridInstance = $("#gridLookupAkunKas").dxDataGrid({
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
            allowUpdating: canEdit,
            allowDeleting: canDelete,
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
              dataField: "KodeAkun",
              caption: "KodeAkun",
              allowEditing:false
          },
          {
              dataField: "NamaAkun",
              caption: "NamaAkun",
              allowEditing:false
          },
          {
              dataField: "Saldo",
              caption: "Saldo",
              allowEditing:false
          },
          {
              dataField: "CabangID",
              caption: "CabangID",
              allowEditing:false,
              visible:false
          },

        ]
      })
    }
  })
</script>