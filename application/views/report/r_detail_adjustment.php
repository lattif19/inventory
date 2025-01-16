<?php
 
$filename = 'Report Adjustment -'.$trx_timestamp;
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$filename.xls");
header("Pragma: no-cache");
header("Expires: 0");
 
?>
<table border='1' width="100%">
  <thead>
    <tr>
      <th colspan="5">Report Adjustment</th>
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
      <th>Location</th>
      <td colspan="4"><?php echo $name; ?></td>
    </tr>
   </thead>
</table>
<br>
 <table border="1" width="100%">
    <thead>
      <tr>
        <th>Item</th>
        <th>Description</th>
        <th>System Qty</th>
        <th>Actual Qty</th>
        <th>Adjustment Qty</th>
        <th>UOM</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($dataItem as $row) { ?>
      <tr>
        <td><?php echo $row->item_number; ?></td>
        <td><?php echo $row->DESCRIPTION; ?></td>
        <td><?php echo $row->system_qty; ?></td>
        <td><?php echo $row->actual_qty; ?></td>
        <td><?php echo $row->adjustment_qty; ?></td>
        <td><?php echo $row->issueunit; ?></td>
      </tr>
    <?php } ?>
    </tbody>
 </table>