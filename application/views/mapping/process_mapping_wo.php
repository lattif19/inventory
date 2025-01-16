<div class="row" ng-controller="trxIssue_mapping" ng-init="setTrxId(<?=$trxId;?>)">




            <span ng-if="woNumber!=null" ng-init="getDataWO(woNumber)"></span>
            <span ng-if="issueToId!=null" ng-init="setIssueTO(issueToId)"></span>
            <span ng-if="shipperId!=null" ng-init="getDataShipper(shipperId)"></span>
  <!-- TRX BARCODE -->
  <div class="col-md-8" ng-hide="companyList">
        <?php if($this->uri->segment(5)=="success"){?>
              <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-check"></i>Saved!</h4>
                  Success save Transaction as Mapping.
              </div>
      <?php } ?>
    <div class="box box-default">
      <div class="box-body">
       <div class="form-group">
        <form ng-submit="getItem(itemNumber)">
          <input id="show1" name="barcode" autocomplete="off" ng-model="itemNumber" type="text" placeholder="BARCODE" class="form-control input-lg" >
        </form>

        <!-- loading -->
        <div ng-show="loading">
          <center><h6>Loading...</h6></center>
          <div class="progress progress-sm active">
            <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
              <span class="sr-only">80% Complete</span>
            </div>
          </div>
        </div>
        <!-- warning -->
        <div ng-show="warning"><br>
          <div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Warning!</h4>
            {{warningMessage}}
          </div>
        </div>
        <!-- info -->
        <div ng-show="info"><br>
          <div class="alert alert-success alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Success!</h4>
            {{infoMessage}}
          </div>
        </div>
      </div><!-- /.form-group -->
    </div><!-- /.box-body -->
  </div><!-- /.box -->

  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-body">
          <div class="table-responsive">

            <table class="table table-hover no-margin">
              <thead>
                <tr>
                  <th>Item</th>
                  <th>Description</th>
                  <th>Qty</th>
                  <th>Order Unit</th>
                  <th>Location</th>
                  <th>Condition Code</th>
                  <th>Bin</th>
                  <th>Stock Balance</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-class="{info : activeItem === $index}" ng-repeat="itemList in dataItem" ng-click="showItemImage($index)">
                  <td>{{itemList.itemNumber}}</td>
                  <td>{{itemList.description}}</td>
                  <td>{{itemList.qty}}</td>
                  <td>{{itemList.orderunit}}</td>
                  <td>
                    <select class="form-control"  ng-change="checkStock(dataItem[$index].itemNumber,dataItem[$index].location_id,dataItem[$index].conditioncode,$index)" ng-init="dataItem[$index].location_id='1203'"  ng-model="dataItem[$index].location_id" ng-disabled="itemList.trx_status!=null">
                      <?php foreach ($dataLocation as $location) {?>
                      <option value="<?=$location->location_id;?>"><?=$location->name;?></option>
                      <?php } ?>
                    </select>
                  </td>
                  <td>
                    <select class="form-control" ng-change="checkStock(dataItem[$index].itemNumber,dataItem[$index].location_id,dataItem[$index].conditioncode,$index)" ng-init="dataItem[$index].conditioncode='NEW-MATERIAL'" ng-model="dataItem[$index].conditioncode" ng-disabled="itemList.trx_status!=null">
                      <option value="NEW-MATERIAL">NEW-MATERIAL</option>
                      <option value="EX-PROJECT">EX-PROJECT</option>
                    </select>
                  </td>

                   <td> 
                      {{dataItem[$index].binnum}}
                    </td>
                    
                  <td ng-hide="itemList.trx_status!=null"  ng-init="checkStock(dataItem[$index].itemNumber,dataItem[$index].location_id,dataItem[$index].conditioncode,$index)">

                  <a ng-show="itemList.qty>dataItem[$index].balance" href="#" data-skin="skin-red" class="btn btn-danger btn-xs"><i class="fa fa-close"></i> {{dataItem[$index].balance}}</a>

                  <a ng-show="itemList.qty<=dataItem[$index].balance" href="#" data-skin="skin-red" class="btn btn-success btn-xs"><i class="fa fa-check"></i> {{dataItem[$index].balance}}</a>


                  </td>
                  <td><a  ng-hide="itemList.trx_status!=null" class="btn btn-sm btn-social-icon btn-google" ng-click="removeItem($index)"><i class="fa fa-fw fa-trash"></i></a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div><!-- /.table-responsive -->
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col --> 
  </div><!-- /.col -->  
</div><!-- /.col -->     





<!-- trx WO,SHIPPER -->
<div class="col-md-4">
  <!-- detail foto barang -->
  <div class="box box-default" ng-hide="dataItemImage==null">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <center><img src="http://192.168.7.14/assets/uploads/item/{{dataItemImage}}" class="img-responsive" class="img-fluid" alt="Responsive image"></center><br>
        </div><!-- ./chart-responsive -->
        <center>{{dataItemName}}</center>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div>

  <div class="box box-default">
    <div class="box-body">
        <label>WO</label>
        <div class="input-group">
          <form ng-submit="getDataWO(woNumber)">
            <input type="text" class="form-control" ng-model="woNumber" ng-disabled="dataWO.woNumber">
          </form>
            <span class="input-group-btn">
              <button ng-show="dataWO.woNumber==null" type="button" class="btn btn-info btn-flat" ng-click="getDataWO(woNumber)">Search</button>
              <button ng-show="dataWO.woNumber!=null" type="button" class="btn btn-success btn-flat" ng-click="resetDataWO()"><i class="fa fa-check"></i></button>
            </span>
        </div>
        <br>
        <div class="alert alert-danger alert-dismissible" ng-show="dataWO.trasactionBefore!=null">
          <h4><i class="icon fa fa-ban"></i> Warning!</h4>
          This WO have similiar transaction with receive transaction at trasaction code {{dataWO.trasactionBefore}}. Please make sure that your transaction is not saved as double transaction.
        </div>

        <span ng-show="dataWO.description!=null">
          <label>Description</label>
          <div class="form-group">
            <input type="text" class="form-control" ng-model="dataWO.description" disabled>
          </div>
          <label>Status</label>
          <div class="form-group">
            <input type="text" class="form-control" ng-model="dataWO.status" disabled>
          </div>
          <label>Date</label>
          <div class="form-group">
            <input type="text" class="form-control" ng-model="dataWO.statusDate" disabled>
          </div>
        </span>

        <!-- loading -->
        <div ng-show="loadingWO">
          <center><h6>Loading...</h6></center>
          <div class="progress progress-sm active">
            <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
              <span class="sr-only">80% Complete</span>
            </div>
          </div>
        </div>
        <!-- warning -->
        <div ng-show="warningWO">
          <div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Warning!</h4>
            {{warningWOMessage}}
          </div>
        </div>

      <table width="100%" border="0" cellpadding="0">
        <tr>
          <td>Total Items</td>
          <td>{{countItem}}</td>
        </tr>
      </table>
    </div><!-- /.col -->
  </div><!-- /.row -->




  <div class="box box-default">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <label>Shipper ID</label>


          <!-- loading -->
          <div ng-show="loadingShipper">
            <center><h6>Loading...</h6></center>
            <div class="progress progress-sm active">
              <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                <span class="sr-only">80% Complete</span>
              </div>
            </div>
          </div>
          <!-- warning -->
          <div ng-show="warningShipper">
            <div class="alert alert-danger alert-dismissible">
              <h4><i class="icon fa fa-ban"></i> Warning!</h4>
              {{warningShipperMessage}}
            </div>
          </div>



          <span ng-show="dataShipper.shipperId!=null">
            <center><img src="http://192.168.7.14/assets/uploads/shipper/{{dataShipper.photo}}" class="img-responsive" class="img-fluid" alt="Responsive image"></center><br>
            <label>Name</label>
            <div class="form-group">
              <input type="text" class="form-control" ng-model="dataShipper.name" disabled>
            </div>
            <label>Devisi</label>
            <div class="form-group">
              <input type="text" class="form-control" ng-model="dataShipper.departement" disabled>
            </div>
          </span>

          <label>Shipper ID</label>

          <div class="input-group">
            <form ng-submit="getDataShipper(shipperId)">
              <input type="text" class="form-control" ng-model="shipperId" ng-disabled="dataShipper.shipperId!=null">
            </form>
            <span class="input-group-btn">
              <button ng-show="dataShipper.shipperId==null" type="button" class="btn btn-info btn-flat" ng-click="getDataShipper(shipperId)">Search</button>
              <button ng-show="dataShipper.shipperId!=null" type="button" class="btn btn-danger btn-flat" ng-click="resetDataShipper()">Reset</button>
            </span>
          </div>
        </div><!-- /.col -->
      </div>
    </div><!-- /.row -->
  </div>



  <div class="box box-default">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">

          <label>Issue To</label>

          <!-- loading -->
          <div ng-show="loadingIssueTo">
            <center><h6>Loading...</h6></center>
            <div class="progress progress-sm active">
              <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                <span class="sr-only">80% Complete</span>
              </div>
            </div>
          </div>
          <!-- warning -->
          <div ng-show="warningIssueTo">
            <div class="alert alert-danger alert-dismissible">
              <h4><i class="icon fa fa-ban"></i> Warning!</h4>
              {{warningIssueToMessage}}
            </div>
          </div>


          <span ng-show="dataIssueTo.issueToId!=null">
            <center><img src="http://192.168.7.14/assets/uploads/shipper/{{dataIssueTo.photo}}" class="img-responsive" class="img-fluid" alt="Responsive image"></center><br>
            <label>Name</label>
            <div class="form-group">
              <input type="text" class="form-control" ng-model="dataIssueTo.name" disabled>
            </div>
          </span>

          <div class="input-group input-group">
            <input type="text" class="form-control" ng-model="dataIssueTo.issueToId" ng-disabled="dataIssueTo.issueToId!=null">
            <span class="input-group-btn">
              <button type="button" class="btn btn-info btn-flat"  data-toggle="modal" data-target="#myModal">...</button>
            </span>
          </div>

        </div><!-- /.col -->
      </div>
    </div><!-- /.row -->
  </div>


  <div class="box box-default">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <!-- loading saveData-->
          <div ng-show="loadingFinish">
            <center><h6>Submiting data...</h6></center>
            <div class="progress progress-sm active">
              <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                <span class="sr-only">80% Complete</span>
              </div>
            </div>
          </div>
          <!-- warning saveData-->
          <div ng-show="warningFinish"><br>
            <div class="alert alert-danger alert-dismissible">
              <h4><i class="icon fa fa-ban"></i> Warning!</h4>
              {{warningFinishMessage}}
            </div>
          </div>
          <input type="submit" class="btn btn-primary btn-block btn-sm" ng-click="saveData(dataItem,dataWO,dataIssueTo,dataShipper)" ng-disabled="cekFinish()"/>
        </div><!-- ./chart-responsive -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </form>
</div><!-- /.box-body -->
</div><!-- /.box -->




<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Select Issue to</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Issue to List</h3>
              </div><!-- /.box-header -->
              <div class="box-body">
                <div class="table-responsive">
                  <table id="issueTo" class="table table-bordered table-hover table-striped">
                    <thead>
                      <tr>
                        <th>USERID</th>
                        <th>PERSONID</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($dataIssueTo as $issueTo ) {  ?>
                      <tr ng-click="setIssueTO('<?=$issueTo->USERID;?>' )" data-dismiss="modal">
                        <td><?php echo $issueTo->USERID; ?></td>
                        <td><?php echo $issueTo->PERSONID; ?></td>
                      </tr>
                      <?php } ?>

                    </tbody>
                  </table>  
                </div><!-- /.table-responsive -->
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </div><!-- /.col --> 
        </div><!-- /.col -->  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<script>
 $(document).ready(function() {
  var table = $('#issueTo').DataTable();

  $('issueTo tbody').on( 'click', 'tr', function () {
    if ( $(this).hasClass('selected') ) {
      $(this).removeClass('selected');
    }
    else {
      table.$('tr.selected').removeClass('selected');
      $(this).addClass('selected');
    }
  } );

  $('#button').click( function () {
    table.row('.selected').remove().draw( false );
  } );
} );
</script>

</div><!-- /.col --> 

