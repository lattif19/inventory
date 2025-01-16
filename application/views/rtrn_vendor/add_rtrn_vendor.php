<div class="row" ng-controller="trxRtrnVendor">
  <!-- TRX BARCODE -->
  <div class="col-md-8">
    <div class="box box-default">
      <div class="box-body">
       <div class="form-group">
        <form ng-submit="getItem(itemNumber)">
          <input id="show1" name="barcode" autocomplete="off" ng-model="itemNumber" type="text" placeholder="BARCODE" class="form-control input-lg" ng-disabled="dataPO.poNumber==null">
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
                    <select class="form-control"  ng-init="dataItem[$index].location_id='1203'" ng-model="dataItem[$index].location_id" ng-disabled="dataLocation">
                      <?php foreach ($dataLocation as $location) {?>
                      <option value="<?=$location->location_id;?>"><?=$location->name;?></option>
                      <?php } ?>
                    </select>
                  </td>
                  <td><a class="btn btn-sm btn-social-icon btn-google" ng-click="removeItem($index)"><i class="fa fa-fw fa-trash"></i></a>
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
      <table width="100%" border="0" cellpadding="0">


        <label>PO</label>
        <div class="input-group">
          <form ng-submit="getDataPO(poNumber)">
            <input type="text" class="form-control" ng-model="poNumber" ng-disabled="dataPO.poNumber!=null">
            <span class="input-group-btn">
              <button ng-show="dataPO.poNumber==null" type="button" class="btn btn-info btn-flat" ng-click="getDataPO(poNumber)">Search</button>
              <button ng-show="dataPO.poNumber!=null" type="button" class="btn btn-danger btn-flat" ng-click="resetDataPO()">Reset</button>
            </span>
          </form>
        </div>
        <br>
        <div class="alert alert-danger alert-dismissible" ng-show="dataPO.trasactionBefore!=null">
          <h4><i class="icon fa fa-ban"></i> Warning!</h4>
          This PO have similiar transaction with receive transaction at trasaction code {{dataPO.trasactionBefore}}. Please make sure that your transaction is not saved as double transaction.
        </div>

        <span ng-show="dataPO.poNumber!=null">
          <label>Description</label>
          <div class="form-group">
            <input type="text" class="form-control" ng-model="dataPO.description" disabled>
          </div>
          <label>Vendor</label>
          <div class="form-group">
            <input type="text" class="form-control" ng-model="dataPO.companyName" disabled>
            <input type="text" class="form-control" ng-model="dataPO.companyId" ng-hide="true">
          </div>
          <label>Date</label>
          <div class="form-group">
            <input type="text" class="form-control" ng-model="dataPO.date" disabled>
          </div>
        </span>

        <!-- loading -->
        <div ng-show="loadingPO">
          <center><h6>Loading...</h6></center>
          <div class="progress progress-sm active">
            <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
              <span class="sr-only">80% Complete</span>
            </div>
          </div>
        </div>
        <!-- warning -->
        <div ng-show="warningPO">
          <div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Warning!</h4>
            {{warningPOMessage}}
          </div>
        </div>

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
          <label>Note </label>
          <div class="input-group">
              <textarea class="form-control" rows="5" ng-model="dataNote"></textarea>
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
                {{warningFinish}}
              </div>
            </div>

          <button class="btn btn-primary btn-block btn-sm"  ng-click="saveData(dataItem,dataPO,dataShipper,dataNote)" ng-disabled="loadingFinish" ng-disabled="cekFinish()">Finish</button>

          <!-- <button class="btn btn-primary btn-block btn-sm" onclick="myFunctionPrint('<?= $autoPrint+1 ?>')"  ng-click="saveData(dataItem,dataPO,dataShipper,dataNote)" ng-disabled="loadingFinish" ng-disabled="cekFinish()">Finish</button> -->

        </div><!-- ./chart-responsive -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.box-body -->
</div><!-- /.box -->




</div><!-- /.col --> 

<script>
    myFunctionPrint=function(trxId){
        // var qtyPrint = prompt('Please enter Qty','10');
        // if (qtyPrint != null && qtyPrint != "") {
          var url = '<?php echo base_url(); ?>report/print_rtrn_vendor/'+trxId;
          // var W = window.open(url); 
          var W = setTimeout(function(){ window.open(url);  }, 1000); 
    }
   </script>