 <?php
 
 header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=$title.xls");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");
 
 ?>
 
 <table border="1" width="100%">
    <thead>
      <tr>
        <th>Date</th>
        <th>Transaction Number</th>
        <th>PO</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($query as $buku) { ?>
      <tr>
        <td><?php echo $buku->trx_timestamp; ?></td>
        <td><?php echo $buku->trx_code; ?></td>
        <td><?php echo $buku->ponum; ?></td>
      </tr>
    <?php } ?>
    </tbody>
 </table>