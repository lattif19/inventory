 <div  ng-controller="trxIssue_non_wo">
 <div class="box box-default" ng-init="detailWo.trx_detail_id='<?=(int)$dataTrx->trx_detail_id;?>'">
   <div class="box-header with-border">
   </div><!-- /.box-header -->
   <div class="box-body">
    <div class="row">

      <div class="col-md-12">

        <?php if($this->uri->segment(5)=="success"){?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i>Saved!</h4>
          Success save Transaction as Complete.
        </div>
        <?php } ?>


        <div class="col-md-12">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td><b>TRX Code</b></td>
                <td><b><?=$dataTrx->trx_code;?></b></td>
              </tr>
              <tr>
                <td><b>Shipper</b></td>
                <td><b><?=$dataTrx->shipper_barcode;?> - <?= $dataTrx->name_shipper ?></b></td>
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
                <td><b>Issued Qty</b></td>
                <td  ng-init="detailWo.issuedQty='<?=(int)$dataTrx->issuedqty;?>'"><?=$dataTrx->issuedqty;?> </td>
              </tr>
              <tr>
                <td><b>Location</b></td>
                <td><b><?=$dataTrx->name;?></b></td>
              </tr>
              <tr>
                <td><b>Condition Code</b></td>
                <td><b><?=$dataTrx->conditioncode;?></b></td>
              </tr>
              <tr>
                <td><b>Binnum</b></td>
                <td><b><?=$dataTrx->binnum;?></b></td>
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
  </div>
  
  <div class="box box-info">
    <div class="box-body">

      <table class="table table-bordered">
        <tbody>
          <tr>
            <td colspan="2"><b><center>Add Detail Mapping</center></b></td>

          </tr>
          <tr>
            <td><b>WO Number</b></td>
              <td>
                <div class="form-group has-feedback" ng-class="detailWo.orderQty != NULL ? 'has-success' : 'has-error'">
                  <input type="text" class="form-control" ng-model="detailWo.woNumber" ng-change="searchWO(<?=$dataTrx->item_number;?>,detailWo.woNumber)" ng-change="changeReceiveQty()">
                  <span class="glyphicon form-control-feedback" ng-class="detailWo.orderQty != NULL ? 'glyphicon-ok' : 'glyphicon-remove'" aria-hidden="true"></span>

                  <span id="inputSuccess2Status" class="sr-only">(success)</span>
                </div>
                <center><img ng-show="loading" src="http://192.168.7.14/assets/img/loader.gif" class="img-responsive" width="100" height="100"></center>


              </td>
          </tr>
          <tr>
            <td><b>Order Qty</b></td>
            <td>{{detailWo.orderQty}}</td>
          </tr>
          <tr>
            <td><b>Remaining Qty</b></td>
            <td>{{detailWo.remainingQty}}</td>
          </tr>
          <tr>
            <td><b>Receive Qty</b></td>
            <td><input class="form-control" ng-model="detailWo.issuedQty" ng-change="changeReceiveQty()"></td>
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