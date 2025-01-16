<?php
 $title = 'Detail Stockopname';
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=$title.xls");
 header("Pragma: no-cache");
 header("Expires: 0");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Export Excel Data Stockopname</title>
</head>

<body>
<table width="100%" border="1">
  <tr>
    <th scope="col">Item Number</th>
    <th scope="col">Description</th>
    <th scope="col">Commodity</th>
    <th scope="col">Condition Code</th>
    <th scope="col">Qty</th>
    <th scope="col">Name</th>
  </tr>
  <tr>
  <?php foreach ($dataStockopname as $row) { ?>
    <td><?php echo $row->item_number; ?></td>
    <td><?php echo $row->DESCRIPTION; ?></td>
    <td><?php echo $row->COMMODITYGROUP; ?></td>
    <td><?php echo $row->condition_code; ?></td>
    <td><?php echo $row->qty; ?></td>
    <td><?php echo $row->trx_so_user; ?></td>
  </tr>
  <?php } ?>
  <!-- <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr> -->
</table>

</body>
</html>