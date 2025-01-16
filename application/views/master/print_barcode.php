<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
			@media print {  
			  @page {
			    size: 104mm 28mm; /* landscape */
			    /* you can also specify margins here: */
			    margin: 0mm;
			    margin-right: 0mm; /* for compatibility with both A4 and Letter */
			  }
			}
	</style>
        <script type="text/javascript">
        	// function printBarcode() {
			// 	setTimeout(function () { 
			// 		window.print(); 
			// 	}, 500);

			// 	setTimeout(function() {
			// 		window.close();
			// 	}, 3000);
			// }
        	// window.onfocus = function () {
			// 	printBarcode();
			// };
        </script>
</head>	
<body style ="font-size: x-small; font-family: 'Times New Rowman', sans-serif; margin-top: -10px; ">

<?php 
$qty=$this->uri->segment(4);
for ($i=0; $i < $qty; $i++) { 
	$count = explode(' ', $description);
	$count = count($count);
	if ($count >= 1) {
		$count = '';
	} else {
		$count = '<br>';
	}


	$itemNum=str_pad($item_number, 13, '0', STR_PAD_LEFT);
?>

<table style="margin-top: 7.35px">
<!-- 	<tr>
		<td><center><h6><?= $description; ?></center></td>
		<td><center><?= $description; ?></h6></center></td>
	</tr>
	 -->
	 <!-- 
	<tr>
		<td style="font-size : 50%; padding-right: 45px; padding-left: 10px;"><center><strong><?= $count; ?><?= $description; ?><?= $count; ?></strong></center></td>
		<td>    </td>
		<td style="font-size : 50%;"><center><strong><?= $count; ?><?= $description; ?><?= $count; ?></strong></center></td>
	</tr> -->
	<tr>
		<td style=" padding-right: 45px; padding-left: 0px;"><strong><?= $count; ?><?= substr($description, 0, 30); ?><?= $count; ?></strong></td>
		<td>    </td>
		<td style=""><strong><?= $count; ?><?= substr($description, 0, 30); ?><?= $count; ?></strong></td>
	</tr>
	<tr>
		<!-- <td style="padding-right: 45px; padding-left: 0px;"><img style="width: 200px; margin-top: -2px; margin-left: 0px";" src="http://192.168.7.14/barcode/get_barcodee/<$itemNum;?>"></td> -->
		<td style="padding-right: 45px; padding-left: 0px;">
			<img style="width: 200px; margin-top: -2px; margin-left: 0px;" 
				src="http://localhost/inventory/barcode/get_barcodee/<?=$itemNum;?>" alt="http://localhost/inventory/barcode/get_barcodee/<?=$itemNum;?>">
		</td>
		<td></td>
		<!-- <td><img style="width: 200px; margin-top: 0px; margin-left: 0px;"  src="http://192.168.7.14/barcode/get_barcodee/<$itemNum;?>"></td> -->
		<td>
			<img style="width: 200px; margin-top: 0px; margin-left: 0px;"  src="http://localhost/inventory/barcode/get_barcodee/<?=$itemNum;?>">
		</td>
	</tr>
<?php } ?>
</table>
</body>
</html>