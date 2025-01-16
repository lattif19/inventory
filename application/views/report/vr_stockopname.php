 <?php
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$title.'".xls'); //tell browser what's the file name

header('Cache-Control: max-age=0'); //no cache
 ?>
 
<table border="1">
  <tbody>
    <tr>
      <td colspan="2" rowspan="2"><img src="<?php echo base_url();?>assets/dist/img/logo.png" width="120" height="75"></img></td>
      <td>PT Sumber Segara Primadaya</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>Jl. Lingkar Timur Karang Kandri</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td>Kecamatan Kesugihan - Cilacap - Indonesia</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td>Tel. 62.282. 538 863 Fax. 62.282. 538 863</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <th bgcolor="aeaeae">Date</th>
      <th bgcolor="aeaeae">:</th>
      <th bgcolor="aeaeae"><?php echo $trx_so_date; ?></th>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <th bgcolor="aeaeae">Transaction Number</th>
      <th bgcolor="aeaeae">:</th>
      <th bgcolor="aeaeae"><?php echo $trx_so_code; ?></th>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <th bgcolor="aeaeae">No</th>
      <th bgcolor="aeaeae">Item Number</th>
      <th bgcolor="aeaeae">Issue Unit</th>
      <th bgcolor="aeaeae">Location Id</th>
      <th bgcolor="aeaeae">Condition Code</th>
      <th bgcolor="aeaeae">Qty</th>
    </tr>
    <?php $no = 1; foreach($query->result() as $buku) { ?>
      <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $buku->item_number; ?></td>
        <td><?php echo $buku->issue_unit; ?></td>
        <td><?php echo $buku->location_id; ?></td>
        <td><?php echo $buku->condition_code; ?></td>
        <td><?php echo $buku->qty; ?></td>
      </tr>
    <?php } ?>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
</table>