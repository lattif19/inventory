<?php
 $title = "Report SO (Stock Opname) Harian - ".date("Y-m-d H:i:s");
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=$title.xls");
 header("Pragma: no-cache");
 header("Expires: 0");
?>
<table>
	<thead>
		<tr>
			<th>Date</th>
			<th>WO Number</th>
			<th>Item Number</th>
			<th>Description</th>
			<th>Condition Code</th>
			<th>Qty</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($so_day_report as $value) {?>
		<tr>
			<td><?php echo $value->trx_timestamp ?></td>
			<td><?php echo $value->wonum ?></td>
			<td><?php echo $value->item_number ?></td>
			<td><?php echo $value->description ?></td>
			<td><?php echo $value->conditioncode ?></td>
			<td><?php echo $value->issuedqty ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>