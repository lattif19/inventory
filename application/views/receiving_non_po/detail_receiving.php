<div ng-controller="trxReceiving_non_po">
<div class="box box-default"  ng-init="detailPo.trx_detail_id='<?=$dataTrx->trx_detail_id;?>'">
  <div class="box-header with-border">
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
      

        <table class="table table-bordered">
          <tbody>
            <tr>
              <td><b>TRX Code</b></td>
              <td><b><?=$dataTrx->trx_code;?></b></td>
            </tr>
            <tr>
              <td><b>Company</b></td>
              <td><b><?=$dataTrx->company_id;?></b></td>
            </tr>
            <tr>
              <td><b>Shipper</b></td>
              <td><b><?=$dataTrx->shipper_id;?> -- <?=$dataTrx->name;?></b></td>
            </tr>
            <tr>
              <td><b>Item Number</b></td>
              <td><?=$dataTrx->item_number;?></td>
            </tr>
            <tr>
              <td><b>Description</b></td>
              <td><?=$dataTrx->description;?></td>
            </tr>
            <tr>
              <td><b>Received Qty</b></td>
              <td  ng-init="detailPo.receiveQty='<?=(int)$dataTrx->receivedqty;?>'"><?=$dataTrx->receivedqty;?></td>
            </tr>
            <tr>
              <td><b>Timestamp</b></td>
              <td><?=$dataTrx->trx_timestamp;?></td>
            </tr>            
          </tbody>
        </table>
      </div>
    </div><!-- /.row -->
  </div><!-- /.box-body -->
</div><!-- /.box -->

    <div class="box box-info">
      <div class="box-body">

        <table class="table table-bordered">
          <tbody>
            <tr>
              <td colspan="2"><b><center>Add Po Number</center></b></td>
            </tr>
            <tr>
              <td><b>Po Number</b></td>
              <td>

                <div class="form-group has-feedback" ng-class="detailPo.orderQty != NULL ? 'has-success' : 'has-error'">
                  <input type="text" class="form-control" ng-model="detailPo.poNumber" ng-change="searchPO(<?=$dataTrx->item_number;?>,detailPo.poNumber)" ng-change="changeReceiveQty()">
                  <span class="glyphicon form-control-feedback" ng-class="detailPo.orderQty != NULL ? 'glyphicon-ok' : 'glyphicon-remove'" aria-hidden="true"></span>
                  <span id="inputSuccess2Status" class="sr-only">(success)</span>
                </div>
                <center><img ng-show="loading" src="http://192.168.7.14/assets/img/loader.gif" class="img-responsive" width="100" height="100"></center>



              </td>
            </tr>
            <tr>
              <td><b>Order Qty</b></td>
              <td>{{detailPo.orderQty}}</td>
            </tr>
            <tr>
              <td><b>Remaining Qty</b></td>
              <td>{{detailPo.remainingQty}}</td>
            </tr>
            <tr>
              <td><b>Receive Qty</b></td>
              <td><input class="form-control" ng-model="detailPo.receiveQty" ng-change="changeReceiveQty()"></td>
            </tr>
          </tbody>
        </table>


      </div><!-- /.box-body -->
    <div class="box-footer">
    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-warning btn-sm pull-left"><i class="fa fa-arrow-left"></i> Back</a>
    <a ng-click="saveTrx()" class="btn btn-primary btn-sm pull-right">Submit <i class="fa fa-arrow-right "></i></a>
  </div>
    </div><!-- /.box -->
    </div>