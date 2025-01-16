<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Monitoring Integrasi Barcode & Maximo</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">


  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>
<body style="margin-left: 20px; margin-right: 20px;">

<center><b><h1><?=$title;?></h1></b></center>
<br>
<div class="container">
  <div class="row">
  <div class="jumbotron">
    <h1 class="text-center">IMPORT DATA</h1> 
    <p class="text-center">Klik Button untuk mengimport data dari maximo ke barcode</p> 
    <ul class="list-group">
      <li class="list-group-item">BACKUP DATABASE</li>
      <li class="list-group-item">IMPORT ITEM BALANCE FOR SO</li>
      <li class="list-group-item">IMPORT ITEM BALANCE MONITORING WH 1 = > Mengganti <b>getFound</b> stock_opname.trx_so_detail.trx_so_id>(334) menjadi ambil trx_so_id terakhir</li>
      <li class="list-group-item">IMPORT ITEM BALANCE MONITORING WH 2 = > Mengganti <b>getFound2</b> stock_opname.trx_so_detail.trx_so_id>(334) menjadi ambil trx_so_id terakhir</li>
      <li class="list-group-item">IMPORT ITEM BALANCE MONITORING WH 3 = > Mengganti <b>getFound3</b> stock_opname.trx_so_detail.trx_so_id>(334) menjadi ambil trx_so_id terakhir</li>
      <li class="list-group-item">IMPORT ITEM BALANCE MONITORING CHEM = > Mengganti <b>getFoundChem</b> stock_opname.trx_so_detail.trx_so_id>(334) menjadi ambil trx_so_id terakhir</li>
      <li class="list-group-item">GET ALL untuk melakakukan update data ketika data CSV udah di upload</li>
    </ul>
<!-- 
    <ul class="list-group">
      <li class="list-group-item">HASIL DATA</li>
      <li class="list-group-item">IMPORT ITEM BALANCE FOR SO WH 1 : <?=$countWh1->jml?></li>
      <li class="list-group-item">IMPORT ITEM BALANCE FOR SO WH 2 : <?=$countWh2->jml?></li>
      <li class="list-group-item">IMPORT ITEM BALANCE FOR SO WH 3 : <?=$countWh3->jml?></li>
      <li class="list-group-item">IMPORT ITEM BALANCE FOR SO WH CHEM</li>
      <li class="list-group-item">IMPORT ITEM BALANCE MONITORING WH 1 = > Mengganti <b>getFound</b> stock_opname.trx_so_detail.trx_so_id>(334) menjadi ambil trx_so_id terakhir</li>
      <li class="list-group-item">IMPORT ITEM BALANCE MONITORING WH 2 = > Mengganti <b>getFound2</b> stock_opname.trx_so_detail.trx_so_id>(334) menjadi ambil trx_so_id terakhir</li>
      <li class="list-group-item">IMPORT ITEM BALANCE MONITORING WH 3 = > Mengganti <b>getFound3</b> stock_opname.trx_so_detail.trx_so_id>(334) menjadi ambil trx_so_id terakhir</li>
      <li class="list-group-item">IMPORT ITEM BALANCE MONITORING CHEM = > Mengganti <b>getFoundChem</b> stock_opname.trx_so_detail.trx_so_id>(334) menjadi ambil trx_so_id terakhir</li>
      <li class="list-group-item">GET ALL untuk melakakukan update data ketika data CSV udah di upload</li>
    </ul> -->

    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th class="text-center">Imoprt Balances ForSo</th>
          <th class="text-center">Import Balances Monitoring WH</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><a class="btn btn-primary btn-block">Imoprt Balances ForSo WH : <?=$countWh1->jml?></td>
          <td><a class="btn btn-primary btn-block">Import Balances Monitoring WH 1 : <?=$countBalancesMonitoringWh1->jml?></td>
          
        </tr>
        <tr>
          <td><a class="btn btn-info btn-block">Imoprt Balances ForSo WH2 : <?=$countWh2->jml?></td>
          <td><a class="btn btn-info btn-block">Import Balances Monitoring WH 2 : <?=$countBalancesMonitoringWh2->jml?></td>

        </tr>
        <tr>
          <td><a class="btn btn-success btn-block">Imoprt Balances ForSo WH3 : <?=$countWh3->jml?></td>
          <td><a class="btn btn-success btn-block">Import Balances Monitoring WH 3 : <?=$countBalancesMonitoringWh3->jml?></td>
        </tr>
        <tr>
          <td><a class="btn btn-default btn-block">Imoprt Balances ForSo CHEM : <?=$countChem->jml?></td>
          <td><a class="btn btn-default btn-block">Import Balances Monitoring CHEM : <?=$countBalancesMonitoringChem->jml?></td>
        </tr>
        <tr>
          <td><a class="btn btn-default btn-block">Imoprt Balances ForSo WHSP3 : <?=$countSP3->jml?></td>
          <td><a class="btn btn-default btn-block">Import Balances Monitoring WHSP3 : <?=$countBalancesMonitoringSP3->jml?></td>
        </tr>
        <tr>
          <td><a class="btn btn-default btn-block">Imoprt Balances ForSo WHSP3A : <?=$countSP3A->jml?></td>
          <td><a class="btn btn-default btn-block">Import Balances Monitoring WHSP3A : <?=$countBalancesMonitoringSP3A->jml?></td>
        </tr>

        <tr>
        </tr>
      </tbody>
    </table>
  </div>
  <h2></h2>
  <p></p>            
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Imoprt Balances ForSo</th>
        <th>Import Balances Monitoring WH</th>
        <!-- <th>Import Balances Monitoring WH 2</th>
        <th>Import Balances Monitoring WH 3</th>
        <th>Import Balances Monitoring CHEM</th> -->
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><a href="<?=base_url()?>/integration/import/importBalanceForSo" class="btn btn-primary btn-block">Imoprt Balances ForSo WH</td>
        <td><a href="<?=base_url()?>/integration/import/importBalanceForMonitoring1" class="btn btn-primary btn-block">Import Balances Monitoring WH 1</td>
        
      </tr>
      <tr>
        <td><a href="<?=base_url()?>/integration/import/importBalanceForSoWH2" class="btn btn-primary btn-block">Imoprt Balances ForSo WH2</td>
        <td><a href="<?=base_url()?>/integration/import/importBalanceForMonitoring2" class="btn btn-primary btn-block">Import Balances Monitoring WH 2</td>

      </tr>
      <tr>
        <td><a href="<?=base_url()?>/integration/import/importBalanceForSoWH3" class="btn btn-primary btn-block">Imoprt Balances ForSo WH3</td>
        <td><a href="<?=base_url()?>/integration/import/importBalanceForMonitoring3" class="btn btn-primary btn-block">Import Balances Monitoring WH 3</td>
        <!-- <td><a href="<?=base_url()?>/integration/import/importBalanceForMonitoringChem" class="btn btn-primary btn-block">Import Balances Monitoring CHEM</td> -->
      </tr>
      <tr>
        <td><a href="<?=base_url()?>/integration/import/importBalanceForSoWHSP3" class="btn btn-primary btn-block">Imoprt Balances ForSo WHSP3</td>
        <td><a href="<?=base_url()?>/integration/import/importBalanceForMonitoringSP3" class="btn btn-primary btn-block">Import Balances Monitoring WHSP3</td>
        <!-- <td><a href="<?=base_url()?>/integration/import/importBalanceForMonitoringChem" class="btn btn-primary btn-block">Import Balances Monitoring CHEM</td> -->
      </tr>
      <tr>
        <td><a href="<?=base_url()?>/integration/import/importBalanceForSoWHSP3A" class="btn btn-primary btn-block">Imoprt Balances ForSo WHSP3A</td>
        <td><a href="<?=base_url()?>/integration/import/importBalanceForMonitoringSP3A" class="btn btn-primary btn-block">Import Balances Monitoring WHSP3A</td>
        <!-- <td><a href="<?=base_url()?>/integration/import/importBalanceForMonitoringChem" class="btn btn-primary btn-block">Import Balances Monitoring CHEM</td> -->
      </tr>
      <tr>
        <td colspan="2"><a href="<?=base_url()?>/monitoring/monitoring/getAll" class="btn btn-primary btn-block">GET ALL</td>
        <!-- <td><a href="<?=base_url()?>/integration/import/importBalanceForMonitoringChem" class="btn btn-primary btn-block">Import Balances Monitoring CHEM</td> -->
      </tr>
      <tr>
        <td><a href="<?=base_url()?>/integration/import/importMonitoringChemToForSo" class="btn btn-primary btn-block">Imoprt Balances ForSo CHEM</td>
        <td><a href="<?=base_url()?>/integration/import/importBalanceForMonitoringChem" class="btn btn-primary btn-block">Import Balances Monitoring CHEM</td>
      </tr>
      <!-- <tr>
        <td colspan="3"><a href="<?=base_url()?>/integration/import/import_balances" class="btn btn-danger btn-block">IMPORT BALANCES</td>
        <td colspan="2"><a href="<?=base_url()?>/monitoring/monitoring/getAll" class="btn btn-danger btn-block">GET ALL</td>
      </tr> -->

      <tr>
      </tr>
    </tbody>
  </table>
    
  </div>
</div>  
</body>
</html>

