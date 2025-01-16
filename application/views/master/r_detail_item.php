<?php 
$filename = 'Report Rekening Book - '.date("d-m-Y H:i:s");
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=$filename.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Report Rekening Koran</title>
  <link rel="stylesheet" href="">
</head>
<body>
<!-- <table width="100%" border="1">
  <tr>
    <td rowspan="4"><img  src="<?php echo base_url(); ?>assets/uploads/logo2.png" alt="" class="img-responsive"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><srong>
    <strong>PT. Sumber Segara Primadaya</strong></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Jl. Lingkar Timur Karang Kandri<br></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Kecamatan Kesugihan - Cilacap - Indonesia</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Tel. 62.282. 538 863 Fax. 62.282. 538 863<br></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  
</table>
<br>
<br> -->
<table border="1">
  <tr>
    <td colspan="6" align="center"><p><strong>Report Rekening Book</strong></p></td>
  </tr>
  <tr>
    <td>Item Number</td>
    <td colspan="5" align="left"><?php echo $item_number; ?></td>
   <!--  <td rowspan="6" align="center"><img  src="<?php echo base_url(); ?>assets/uploads/items/<?php echo $photo; ?>" class="img-responsive" alt=""></td> -->
  </tr>
  <tr>
    <td>Location</td>
    <td colspan="5"><?php echo $name; ?></td>
  </tr>
  <tr>
    <td>Condition Code</td>
    <td colspan="5"><?php echo $conditioncode; ?></td>
  </tr>
  <tr>
    <td>Binnum</td>
    <td colspan="5"><?php echo $binnum; ?></td>
  </tr>
  <tr>
    <td>Site Id</td>
    <td colspan="5"><?php echo $site_id; ?></td>
  </tr>
  <tr>
    <td>Qty</td>
    <td colspan="5" align="left"><?php echo $qty; ?></td>
  </tr>
  <tr>
    <td colspan="6"><?php echo date("d-m-Y"); date_default_timezone_set('Asia/Bangkok'); echo date('H:i:s');?></td>
  </tr>
  <br>
  <tr>
    <td bgcolor="3ebf40">Date</td>
    <td bgcolor="3ebf40">Debet</td>
    <td bgcolor="3ebf40">Credit</td>
    <td bgcolor="3ebf40">Saldo</td>
    <td bgcolor="3ebf40">Transaksi</td>
    <td bgcolor="3ebf40">Referensi</td>
  </tr>
  <tr>
  <?php foreach ($detailItemBook as $row) { ?>
   
   	<td><?php echo $row->timestamp ; ?></td>
    <td>
     <?php
     if ($row->trx == "Dr") {
      echo $row->qty;
     } else {
      echo "-";
     }
     ?>
    </td>
    <td>
     <?php 
     if ($row->trx == "Kr") {
      echo $row->qty;
     } else {
      echo "-";
     }
     ?>
    </td>
    <td><?php echo $row->currentBalance; ?></td>
    <td><?php echo $row->trx_detail ; ?></td>
    <td><?php echo $row->trx_reff; ?></td>
   
  </tr>
  <?php } ?>
</table>

</body>
</html>
