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
            <h2>Laporan Persembahan</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="Row">
              <div class="col-md-12 col-sm-12">
                <div id="ReportTitle">
                  <center>
                    <h2>
                      GEDUNG JOANG SESI 01 JAM 08:00
                    </h2>
                  </center>
                </div>
              </div>
              <div class="col-md-8 col-sm-8">
                <div class="table-responsive">
                  <table class="table table-striped jambo_table bulk_action" id="TableKas">
                    <thead>
                      <tr class="headings">
                        <th class="column-title">No </th>
                        <th class="column-title">Keterangan </th>
                        <th class="column-title">Divisi </th>
                        <th class="column-title">Nama </th>
                        <th class="column-title">Jumlah </th>
                        <th class="column-title">Debet </th>
                        <th class="column-title">Kredit </th>
                      </tr>
                    </thead>
                    <tbody id="myTbody">

                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-4 col-sm-4">
                <div class="table-responsive">
                  <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action" id="TablePersembahan">
                      <thead>
                        <tr class="headings">
                          <th class="column-title">Pecahan </th>
                          <th class="column-title">Jumlah Lembar </th>
                          <th class="column-title">Total </th>
                        </tr>
                      </thead>
                    </table>
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

<?php
  require_once(APPPATH."views/parts/Footer.php");
?>

<script type="text/javascript">
  $(function () {
    var NoTransaksi = "<?php echo $NoTransaksi; ?>";
    $(document).ready(function () {
      console.log(NoTransaksi)
      getDataKas();
      getPerhitunganPersembahan();
    })

    function getDataKas() {
      $.ajax({
          async:false,
          url: "<?=base_url()?>ReportController/loadrptPersembahan",
          type: 'POST',
          data: {'NoTransaksi' :NoTransaksi },
          success: function(response) {
            // Top Header
            var TotalDebit = 0;
            var TotalKredit = 0;
            // End
            var RowPenerimaan = 0;
            var table = document.getElementById('TableKas');
            var xrow = table.rows.length;
            
            $.each(response.data,function (k,v) {
              if (v.Kelompok == 'Penerimaan') {

                var newRow = document.createElement('tr');
                var tbody = document.getElementById('myTbody');
                // var colspanRow = table.insertRow();
                console.log(RowPenerimaan)
                if (RowPenerimaan == 0 ) {
                  var newCell;
                  for (var i = 0; i < 7; i++) {
                    newCell = document.createElement('td');
                    // newCell.textContent = i;
                    if (i == 2) {
                      newCell.id = "forColspan"
                      newCell.colSpan = 7
                      newCell.innerHTML = '<strong> '+v.Kelompok+' </strong>';
                      newRow.appendChild(newCell);
                      tbody.appendChild(newRow);
                    }
                    
                  }

                  var newRow = document.createElement('tr');

                  var cell1 = document.createElement('td');
                  cell1.innerHTML = '<center>'+(RowPenerimaan +1)+'</center>'
                  newRow.appendChild(cell1);

                  var cell2 = document.createElement('td');
                  cell2.textContent = v.NamaPenerimaan
                  newRow.appendChild(cell2);

                  var cell3 = document.createElement('td');
                  newRow.appendChild(cell3);

                  var cell4 = document.createElement('td');
                  newRow.appendChild(cell4);

                  var cell5 = document.createElement('td');
                  newRow.appendChild(cell5);

                  var cell6 = document.createElement('td');
                  cell6.textContent = parseFloat(v.Debit).toLocaleString('en-US')
                  newRow.appendChild(cell6);

                  var cell7 = document.createElement('td');
                  cell7.textContent = parseFloat(v.Kredit).toLocaleString('en-US')
                  newRow.appendChild(cell7);

                  tbody.appendChild(newRow);
                }
                // table.appendChild(colspanRow);
                RowPenerimaan += 1;
                TotalDebit += parseFloat(v.Debit);
                TotalKredit += parseFloat(v.Kredit)
              }
            })

            // Pengeluaran

            var RowPengeluaran = 0;
            var table = document.getElementById('TableKas');
            var xrow = table.rows.length;
            
            $.each(response.data,function (k,v) {
              if (v.Kelompok == 'Pengeluaran') {

                var newRow = document.createElement('tr');
                var tbody = document.getElementById('myTbody');
                // var colspanRow = table.insertRow();
                console.log(RowPengeluaran)
                if (RowPengeluaran == 0 ) {
                  var newCell;
                  for (var i = 0; i < 7; i++) {
                    newCell = document.createElement('td');
                    // newCell.textContent = i;
                    if (i == 2) {
                      newCell.id = "forColspan"
                      newCell.colSpan = 7
                      newCell.innerHTML = '<strong> '+v.Kelompok+' </strong>';
                      newRow.appendChild(newCell);
                      tbody.appendChild(newRow);
                    }
                    
                  }
                }
                else{
                  var newRow = document.createElement('tr');

                  var cell1 = document.createElement('td');
                  cell1.innerHTML = '<center>'+(RowPengeluaran +1)+'</center>'
                  newRow.appendChild(cell1);

                  var cell2 = document.createElement('td');
                  cell2.colSpan = 2
                  cell2.innerHTML =  '<center>'+v.NamaPenerimaan +'</center>'
                  newRow.appendChild(cell2);

                  var cell4 = document.createElement('td');
                  cell4.textContent = v.PIC
                  newRow.appendChild(cell4);

                  var cell5 = document.createElement('td');
                  cell5.textContent = parseFloat(v.Rate).toLocaleString('en-US')
                  newRow.appendChild(cell5);

                  var cell6 = document.createElement('td');
                  cell6.textContent = parseFloat(v.Debit).toLocaleString('en-US')
                  newRow.appendChild(cell6);

                  var cell7 = document.createElement('td');
                  cell7.textContent = parseFloat(v.Kredit).toLocaleString('en-US')
                  newRow.appendChild(cell7);

                  tbody.appendChild(newRow);
                }
                // table.appendChild(colspanRow);
                RowPengeluaran += 1;
                TotalDebit += parseFloat(v.Debit);
                TotalKredit += parseFloat(v.Kredit)
              }
            })


            console.log(TotalDebit + " - " + TotalKredit)
            // Generate Footer
            var newRow = document.createElement('tr');
            newRow.classList.add('headings');

            var cell5 = document.createElement('td');
            cell5.classList.add('column-title')
            cell5.colSpan = 5
            cell5.innerHTML = "<center><strong>TOTAL</strong></center>"
            newRow.appendChild(cell5);

            var cell6 = document.createElement('td');
            cell6.classList.add('column-title')
            cell6.textContent = parseFloat(TotalDebit).toLocaleString('en-US')
            newRow.appendChild(cell6);

            var cell7 = document.createElement('td');
            cell7.classList.add('column-title')
            cell7.textContent = parseFloat(TotalKredit).toLocaleString('en-US')
            newRow.appendChild(cell7);

            table.appendChild(newRow);

            // Saldo Akhir

            var newRow = document.createElement('tr');
            newRow.classList.add('headings');

            var cell5 = document.createElement('td');
            cell5.classList.add('column-title')
            cell5.colSpan = 5
            cell5.innerHTML = "<center><strong><h2>SALDO AKHIR</h2></strong></center>"
            newRow.appendChild(cell5);

            var cell6 = document.createElement('td');
            cell6.classList.add('column-title')
            cell6.colSpan = 2
            cell6.innerHTML = "<center><strong><h2>"+(parseFloat(TotalDebit) - parseFloat(TotalKredit)).toLocaleString('en-US')+"</h2></strong></center>"
            newRow.appendChild(cell6);

            table.appendChild(newRow);

          }
      });
    }

    function getPerhitunganPersembahan() {
      $.ajax({
        async:false,
        url: "<?=base_url()?>ReportController/loatrptPerhitunganPersembahan",
        type: 'POST',
        data: {'NoTransaksi' :NoTransaksi },
        success: function(response) {
          // console.log(response)
          var Total = 0;
          var table = document.getElementById('TablePersembahan');
          $.each(response.data,function (k,v) {
            var newRow = document.createElement('tr');

            var cell1 = document.createElement('td');
            cell1.textContent = parseFloat(v.KodeDenom).toLocaleString('en-US')
            newRow.appendChild(cell1);

            var cell2 = document.createElement('td');
            cell2.textContent = parseFloat(v.Qty).toLocaleString('en-US')
            newRow.appendChild(cell2);

            var cell3 = document.createElement('td');
            cell3.textContent = parseFloat(v.Jumlah).toLocaleString('en-US')
            newRow.appendChild(cell3);

            table.appendChild(newRow);

            Total += parseFloat(v.Jumlah);
          })

          // Total

          var newRow = document.createElement('tr');

          var cell1 = document.createElement('td');
          cell1.colSpan = 2;
          cell1.innerHTML = "<center><strong><h2>Total</h2></strong></center>"
          newRow.appendChild(cell1);

          var cell3 = document.createElement('td');
          cell3.innerHTML = "<center><strong><h2>"+parseFloat(Total).toLocaleString('en-US')+"</h2></strong></center>"
          newRow.appendChild(cell3);

          table.appendChild(newRow);
        }
      })
    }
  })
</script>