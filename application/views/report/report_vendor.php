<?php

$filename = "Report Return To Vendor - ".$trx_timestamp;
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$filename.xls");
header("Pragma: no-cache");
header("Expires: 0");
 
?>

<table width="100%" border="1">
<!--   <tr>
    <td rowspan="3"><img src="<?php echo base_url();?>assets/dist/img/logo.png" /></td>
    <td width="100%"><strong>PT Sumber Segara Primadaya</strong></td>
  </tr> -->
  <tr>
    <td colspan="2"><strong>Report Return To Vendor</strong></td>
  </tr>
  <tr>
    <th>Transaction Number</th>
    <td><?php echo $trx_code; ?></td>
  </tr>
  <tr>
    <th>Date &amp; Time</th>
    <td><?php echo $trx_timestamp; ?></td>
  </tr>
  <tr>
    <th>Shipper</th>
    <td><?php echo $name; echo "-"; echo $shipper_barcode; ?></td>
  </tr>
</table>
<br>
<table width="100%" border="1">
  <tr>
    <td width="9%" align="center">Item</td>
    <td width="55%" align="center">Description</td>
    <td width="15%" align="center">PO Number</td>
    <td width="8%" align="center">Qty</td>
    <td width="12%" align="center">UOM</td>
    <td width="9%" align="center">Note</td>
  </tr>
  <?php foreach ($dataItem as $key => $value) { ?>
  <tr>
    <td  align="center"><?= $value->item_number ?></td>
    <td><?= $value->DESCRIPTION ?></td>
    <td align="center"><?= $value->ponum ?></td>
    <td align="center"><?= $value->returnqty ?></td>
    <td align="center"><?= $value->returnunit ?></td>
    <td><?= $value->note ?></td>
  </tr>
  <?php } ?>
</table>