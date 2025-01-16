<?php
 $title = "Item Belum Terscan - ".date("Y-m-d H:i:s");
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=$title.xls");
 header("Pragma: no-cache");
 header("Expires: 0");


?>

<table id="example3" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>Item Number</th>
      <th>Name</th>
      <th>Location</th>
      <th>Condition Code</th>
      <th>Bin</th>
      <th>Maximo Balances</th>
    </tr>
  </thead>
  <!-- <tfoot>
    <tr>
      <th>Item Number</th>
      <th>Location</th>
      <th>Condition Code</th>
      <th>Bin</th>
      <th>Maximo Balances</th>
    </tr>
  </tfoot> -->
  <tbody>
    <?php echo "Generate at ".date('Y-m-d H:i:s');foreach ($result3 as $key) {?>
    <tr >
      <td><?php echo $key->item_number;?></td>
       <td><?php echo $key->description;?></td> 
      <td><?php echo $key->location;?></td>
      <td><?php echo $key->conditioncode;?></td>
      <td><?php echo $key->binnum;?></td>
      <td><?php echo $key->qty;?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>