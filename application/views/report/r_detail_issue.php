<?php
 
$filename = 'Report Issue (WO)-'.$trx_timestamp;
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$filename.xls");
header("Pragma: no-cache");
header("Expires: 0");
 
?>
<table border='1' width="100%">
  <thead>
    <tr>
      <th colspan="5">Detail Issue Report</th>
    </tr>
    <tr>
      <th>Date</th>
      <td colspan="4"><?php echo $trx_timestamp; ?></td>
    </tr>
    <tr>
      <th>Transaction Number</th>
      <td colspan="4"><?php echo $trx_code; ?></td>
    </tr>
    <tr>
      <th>Shipper</th>
      <td colspan="4"><?php echo $name; echo "-"; echo $shipper_barcode; ?></td>
    </tr>
   </thead>
</table>
<br>
 <table border="1" width="100%">
    <thead>
      <tr>
        <th>Item</th>
        <th>Description</th>
        <th>Issue Qty</th>
        <th>Issue Unit</th>
        <th>WO</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($query as $row) { ?>
      <tr>
        <td><?php echo $row->item_number; ?></td>
        <td><?php echo $row->DESCRIPTION; ?></td>
        <td><?php echo $row->issuedqty; ?></td>
        <td><?php echo $row->issuedunit; ?></td>
        <td><?php echo $row->wonum; ?></td>
      </tr>
    <?php } ?>
    </tbody>
 </table>