<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Monitoring PR</title>
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">


</head>
<body>
  <br>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <!-- Default panel contents -->
          <div class="panel-heading">
          <center>
<a href="http://192.168.7.14/monitoring/monitoringpr/" type="button" class="btn btn-default btn-xs pull-left">Back</a>
          Purchase Request Monitoring</center>
          </div>

          <!-- Table -->
          <div class="panel-body">
            <table id="example" class="table table-bordered">
    <thead>
              <tr>
                <th class="col-md-1">PR Number</th>
                <th class="col-md-5">Description</th>
                <th class="col-md-2">Date</th>
                <th class="col-md-3">Requested By</th>
                <th class="col-md-1">Detail</th>
              </tr>
              </thead>
    <tbody>
              <?php foreach ($dataList as $data) {?>
              <tr>
                <td><?php echo $data->PRNUM ;?></td>
                <td><?php echo $data->DESCRIPTION ;?></td>
                <td><?php echo $data->ISSUEDATE ;?></td>
                <td><?php echo $data->REQUESTEDBY ;?></td>
                <td><a class="btn btn-primary" href="http://192.168.7.14/monitoring/monitoringpr/detail/<?php echo $data->PRNUM ;?>">Detail</a></td>

              </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
</html>