<?php
 $title = "Item Terscan - $location - ".date("Y-m-d H:i:s");
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=$title.xls");
 header("Pragma: no-cache");
 header("Expires: 0");
?>
<table id="example" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>Item Number</th>
      <th>Name</th>
      <th>Location</th>
      <!-- <th>Condition Code</th> -->
      <th>Bin</th>
      <th>Barcode Balances</th>
      <th>Maximo Balances</th>
      <th>Selisih</th>
    </tr>
  </thead>
  <!-- <tfoot>
    <tr>
      <th>Item Number</th>
      <th>Location</th>
      <th>Condition Code</th>
      <th>Bin</th>
      <th>Barcode Balances</th>
      <th>Maximo Balances</th>
      <th>Selisih</th>
    </tr>
  </tfoot> -->
  <tbody>
    <!-- substr($a, 0, -3); -->
    <?php echo "Generate at ".date('Y-m-d H:i:s');foreach ($result as $key) {?>
    <tr >
      <td><?php echo $key->item_number;?></td>
      <td><?php echo $key->description;?></td>
      <td><?php echo $key->location;?></td>
      <!-- <td><?php echo $key->conditioncode;?></td> -->
      <td><?php echo $key->binnum;?></td>
      <td><?php echo substr($key->qtySo,0,-4);?></td>
      <td><?php echo substr($key->qty,0,-4);?></td>
      <td><?php echo $key->selisih; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
