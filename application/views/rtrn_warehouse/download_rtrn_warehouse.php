<?php
 $title = "Report All Return To Warehouse - ".date("Y-m-d H:i:s");
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=$title.xls");
 header("Pragma: no-cache");
 header("Expires: 0");
?>
<table id="example" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
  <thead>
    <tr style="background-color:yellow;">
      <th>Timestamp</th>
      <th>Transaction Code</th>
      <th>WO Number</th>
      <th>item_number</th>
      <th>Description</th>
      <th>Location</th>
      <th>Qty</th>
      <th>Enter By</th>
      <th>Note</th>
    </tr>
  </thead>
  <tbody>
    <?php echo "Generate at ".date('Y-m-d H:i:s');foreach ($returnWHreport as $key) {?>
    <tr >
      <td><?php echo $key->trx_timestamp;?></td>
      <td><?php echo $key->trx_code;?></td>
      <td><?php echo $key->wonum;?></td>
      <td><?php echo $key->item_number;?></td>
      <td><?php echo $key->DESCRIPTION;?></td>
      <td><?php echo $key->name;?></td>
      <td><?php echo $key->returnqty."-".$key->returnunit;?> </td>
      <td><?php echo $key->enterby;?></td>
      <td><?php echo $key->note;?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
