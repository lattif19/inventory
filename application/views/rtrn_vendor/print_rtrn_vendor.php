
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>WAREHOUSE SYSTEM INVENTORY</title>
	<link rel="stylesheet" href="">

	<style type="text/css">
		@media print {  
		@page {
			size: 76.2mm, 96.2mm; /* landscape */
			/* you can also specify margins here: */
			margin: 0mm;
			margin-right: 0mm; /* for compatibility with both A4 and Letter */
			}
		}
		table, td, th {
		}

		table {
		}

		th, td, p {
			font-size: xx-small;
			font-family: "Lucida Console", Monaco, monospace;
		}
	</style>
	<script type="text/javascript">
        	setTimeout(function () { window.print();console.log('asdf');window.close(); }, 500);
        	window.onfocus = function () { setTimeout(function () { console.log('asd333f');window.close(); }, 500); }
        </script>
</head>
<body style="margin-left: 0px">
	<table style="padding-bottom: 5px;">
		<tbody><tr align="center">
			<th colspan="2">RETURN TO VENDOR</th>
		</tr>
		<tr align="center">
			<th colspan="2">PT. Sumber Segara Primadaya</th>
		</tr>
		<tr align="center">
			<th colspan="2">JL. Lingkar Timur Karang Andri</th>
		</tr>
		<tr align="center">
			<th colspan="2">Kecamatan Kesugihan</th>
		</tr>
		<tr align="center">
			<th colspan="2" style="padding-bottom: 10px;">Telp. 62 282 538 863 Fax 62 282 538 863</th>
		</tr>		
		<tr align="left">
			<th>PO Number : <?php echo $ponum; ?></th>
			<th><?php echo date('d-m-Y');?></th>
		</tr>
		<tr align="left">
			<th>ID Shipper : <?php echo $name_shipper; ?> (<?php echo $company_id; ?>)</th>
			<th> <?php date_default_timezone_set('Asia/Bangkok') ; echo date('H:i:s');?></th>
		</tr>
	</tbody>
	</table>
	<table>
		<tbody>
		<tr>
			<td>===============================================</td>
		</tr>
		<?php foreach ($dataItem as $value) { ?>
			<tr>
				<td><strong><?php echo $value->item_number; ?> <?php echo intval($value->returnqty); ?> <?php echo $value->returnunit;?>  <?php echo $value->conditioncode; ?> <?php echo $value->DESCRIPTION; ?><br><?php echo $value->timestamp; ?></strong></td>
			</tr>
		<?php } ?>
		<tr>
			<td>===============================================</td>
		</tr>
		</tbody>
	</table>
	<table>
		<tbody>
			<tr>
				<th><?php echo $trx_code; ?></th>
			</tr>
			<tr align="center">
				<th style="padding-bottom: 20px; padding-left: 0px;">Receiver Items</th>
				<th style="padding-bottom: 20px;padding-left: 80px;">Issuer Items</th>
			</tr>
			<tr align="center">
				<th><?php  echo $name_shipper; ?></th>
				<th style="padding-left: 80px;"><?php echo  $this->session->userdata('username'); ?></th>
			</tr>
		
		</tbody>
	</table>

</body></html> 