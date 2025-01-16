<table width="100%" border="1">
  <tr>
    <td rowspan="3"><img src="<?php echo base_url();?>assets/dist/img/logo.png" /></td>
    <td width="100%"><strong>PT Sumber Segara Primadaya</strong></td>
  </tr>
  <tr>
    <td><strong>Sparepart Receipt Report (SSR)</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="100%" border="1">
  <tr>
    <td width="9%" align="center">Item</td>
    <td width="55%" align="center">Description</td>
    <td width="15%" align="center">PO Number</td>
    <td width="8%" align="center">Qty</td>
    <td width="12%" align="center">UOM</td>
    <td width="9%" align="center">Vendor</td>
    <td colspan="2" align="center" bgcolor="e3f019">Sebelum</td>
    <td colspan="2" align="center" bgcolor="32B7CD">Sesudah</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="7%" align="center" bgcolor="e3f019">Aktual</td>
    <td width="3%" align="center" bgcolor="e3f019">Maximo</td>
    <td width="3%" align="center" bgcolor="32B7CD">Aktual</td>
    <td width="3%" align="center" bgcolor="32B7CD">Maximo</td>
  </tr>
  <?php foreach ($dataItem as $key => $value) { ?>
  <tr>
  	<td  align="center"><?= $value->item_number ?></td>
	<td><?= $value->DESCRIPTION ?></td>
	<td align="center"><?= $value->ponum ?></td>
	<td align="center"><?= $value->orderqty ?></td>
	<td align="center"><?= $value->orderunit ?></td>
    <td><?= $value->shipper_id ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php } ?>
</table>