<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Monitoring PR</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

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
<a href="http://192.168.7.14/monitoring/monitoringpr/listData" type="button" class="btn btn-default btn-xs pull-left">Back</a>
          Purchase Detail Information</center>
          </div>

          <!-- Table -->
          <div class="panel-body">
          <table class="table table-bordered">
          <tr>
            <td colspan="2"><center><b>Detail Purchase</b></center></td>
          </tr>
          <tr>
            <td><b>PR Number</b></td>
            <td><?=$detailPr[0]->PRNUM;?></td>
          </tr>
          <tr>
            <td><b>Description</b></td>
            <td><?=$detailPr[0]->DESCRIPTIONPR;?></td>
          </tr>
          <tr>
            <td><b>Request By</b></td>
            <td><?=$detailPr[0]->REQUESTEDBY;?></td>
          </tr>
          <tr>
            <td><b>Enter Date</b></td>
            <td><?=$detailPr[0]->ENTERDATE;?></td>
          </tr>
          <tr>
            <td><b>Request Delivery Date</b></td>
            <td><?=$detailPr[0]->REQDELIVERYDATE;?></td>
          </tr>
          
          </table>

          <table class="table table-bordered">
          <tr>
            <td colspan="4"><center><b>Detail Item</b></center></td>
          </tr>
          <tr>
            <th>Item Number</th>
            <th>Desctription</th>
            <th>Order Qty</th>
            <th>Order Unit</th>
          </tr>
          <?php foreach ($detailPr as $key) {?>
          <tr>
            <td><?=$key->ITEMNUM;?></td>
            <td><?=$key->DESCRIPTION;?></td>
            <td><?=$key->ORDERQTY;?></td>
            <td><?=$key->ORDERUNIT;?></td>
          </tr>
          <?php } ?>
          </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>