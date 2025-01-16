	<style type="text/css" media="screen">
			
	</style>
	<table>
		<tr>
			<th colspan="2" style="font-size: 25px"><h1>ISSUE WO</h1></th>
		</tr>
		<tr align="center">
			<th colspan="2" style="margin-right: 100px"><h3>PT. Sumber Segara Primadaya</h3></th>
		</tr>
		<tr align="center">
			<th colspan="2">JL. Lingkar Timur Karang Andri</th>
		</tr>
		<tr align="center">
			<th colspan="2">Kecamatan Kesugihan</th>
		</tr>
		<tr align="center">
			<th colspan="2"  style="padding-bottom: 10px;">Telp. 62 282 538 863 Fax 62 282 538 863</th>
		</tr>
		<tr>
			<th>WO Number : <?php echo $wonum; ?></th>
			<th><?php echo date('Y-m-d');?></th>
		</tr>
		<tr>
			<th>ID Shipper : <?php echo $name_shipper; ?></th>
			<th> <?php echo date('H:i:s');?></th>
		</tr>
	</table>
	<table>
		<tr>
			<td>=================================================</td>
		</tr>
	<?php foreach ($issue as $value) { ?>
		<tr>
			<td><strong><?php echo $value->item_number; ?> <?php echo $value->issuedqty; ?> <?php echo $value->issuedunit;?> <?php echo $value->conditioncode; ?> <?php echo $value->DESCRIPTION; ?></strong>
			</td>
		</tr>
	<?php } ?>
		<tr>
			<td>=================================================</td>
		</tr>
	</table>
	<table>
		<tr>
			<th><?php echo $trx_code; ?></th>
		</tr>
		<tr align="center">
			<th style="padding-bottom: 30px; padding-left: 0px;">Receiver Items</th>
			<th style="padding-bottom: 30px;padding-left: 80px;">Issuer Items</th>
		</tr>
		<tr align="center">
			<th><?php echo $name_shipper; ?></th>
			<th style="padding-left: 80px;"><?php echo $issuer; ?></th>
		</tr>
	</table>

	<script type="text/javascript">
    	setTimeout(function () { window.print();console.log('asdf');window.close(); }, 500);
        .onfocus = function () { setTimeout(function () { console.log('asd333f');window.close(); }, 500); }
         // setTimeout(function(){ alert("Hello"); }, 5000); 
    </script>