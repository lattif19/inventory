<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Monitoring Integrasi Barcode & Maximo</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">


  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
<body style="
    margin-left: 20px;
    margin-right: 20px;
">
<center><h1><?=$title;?></h1></center>


      <a href="<?php echo base_url();?>monitoring/integrasi/getreportmonitoring" class="btn btn-primary">Export Excel</a>
      <!-- <a href="<?php echo base_url();?>monitoring/monitoring/export_not_compare/<?php echo  $location; ?>" class="btn btn-warning">Export Excel Tidak Tercompare</a> -->
      <div class="row">
        <div class="col-lg-12">
        <h6 style="font-size: 80%;">
          <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Item Number</th>
                <th>Location</th>
                <th>Bin</th>
                <th>Barcode Balances</th>
                <th>Maximo Balances</th>
                <th>Selisih</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Item Number</th>
                <th>Location</th>
                <th>Bin</th>
                <th>Barcode Balances</th>
                <th>Maximo Balances</th>
                <th>Selisih</th>
              </tr>
            </tfoot>
            <tbody>
            <?php echo "Generate at ".date('Y-m-d H:i:s');foreach ($result as $key) {?>
              <tr >
                <td><?php echo $key->item_number;?></td>
                <td><?php echo $key->location;?></td>
                <td><?php echo $key->binnum;?></td>
                <td><?php echo $key->qty;?></td>
                <td><?php echo $key->qtyMaximo;?></td>
                <td><?php if($key->selisih>0){echo "+";}?><?php echo $key->selisih;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          </h6>
        </div>
      </div>





      <script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script type="text/javascript">
        $(document).ready(function() {
          $('#example').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
          });
        } );
        $(document).ready(function() {
          $('#example2').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
          });
        } );
        $(document).ready(function() {
          $('#example3').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
          });
        } );
      </script>

    </body>
    </html>