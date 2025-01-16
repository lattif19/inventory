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
          setTimeout(function () { window.open();window.print();console.log('asdf');window.close(); }, 500);
          window.onfocus = function () { setTimeout(function () { console.log('asd333f');window.close(); }, 500); }
        </script>
</head>
<body style ="font-size: smaller; font-family: 'Times New Rowman', sans-serif; margin-top: -5px; ">


<table>
 <tr>
    <td align= "center" style="padding-right: 45px; padding-left: 15px;"><strong><?= $name ?></strong></td>
    <td>    </td>
    <td align= "center" style=""><strong><?= $name ?></strong></td>
  </tr>
  <tr>
    <td style="padding-right: 45px; padding-left: 10px;"><img style="width: 190px; margin-top: 0px; margin-left: 0px";" src="http://192.168.7.14/admin/get_barcodee/<?=$shipper_barcode;?>"></td>
    <td>    </td>
    <td><img style="width: 190px; margin-top: -2px; margin-left: 0px";"  src="http://192.168.7.14/admin/get_barcodee/<?=$shipper_barcode;?>"></td>
  </tr>
</table>
</body>
</html>