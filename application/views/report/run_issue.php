<?php
 $title = "Report Issue - ".date("Y-m-d H:i:s");
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=$title.xls");
 header("Pragma: no-cache");
 header("Expires: 0");
?>
<table>
	<thead>
		<tr>
			<th>Item Number</th>
			<th>Location</th>
			<th>Qty</th>
			<th>Maximo</th>
			<th>Selisih</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($issuereport as $value) {?>
		<tr>
			<td><?php echo $value->item_number ?></td>
			<td><?php echo $value->location ?></td>
			<td><?php echo $value->qtyBarcode ?></td>
			<td><?php echo $value->qtyMaximo ?></td>
			<td><?php echo $value->selisih ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>