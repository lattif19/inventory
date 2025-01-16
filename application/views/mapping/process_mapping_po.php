<div class="row" ng-controller="trxReceiving_mapping" ng-init="setTrxId(<?=$trxId;?>)">


  <span ng-if="poNumber!=null" ng-init="getDataPO(poNumber)">
    <span ng-if="dataPO.companyId!=null&&shipperId!=null" ng-init="getDataShipper(shipperId)"></span>
  </span>

  <span ng-if="companyId!=null" ng-init="setCompany(companyId,companyName)">
    <span ng-if="dataPO.companyId!=null&&shipperId!=null" ng-init="getDataShipper(shipperId)"></span>
  </span>
  <!-- TRX BARCODE -->
  <div class="col-md-8">
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
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-class="{info : activeItem === $index}" ng-repeat="itemList in dataItem" ng-click="showItemImage($index)">
                  <td>{{itemList.itemNumber}}</td>
                  <td>{{itemList.description}}</td>
                  <td>{{itemList.qty}}</td>
                  <td>{{itemList.orderunit}}</td>
                  <td><a ng-hide="itemList.trx_status!=null" class="btn btn-sm btn-social-icon btn-google" ng-click="removeItem($index)"><i class="fa fa-fw fa-trash"></i></a>
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
          <center><img src="http://192.168.7.14/assets/uploads/items/{{dataItemImage}}" class="img-responsive" class="img-fluid" alt="Responsive image"></center><br>
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

        <div class="form-group" ng-hide="dataPO.poNumber!=null">
          <label for="varchar">Vendor</label>
          <div class="row">
            <div class="col-md-9">
              <input type="text" class="form-control" name="vendor" id="vendor" placeholder="Choose Vendor" readonly="" ng-model="dataCompany.companyId" ng-hide="true"/>
              <input type="text" class="form-control" name="vendor" id="vendor" placeholder="Choose Vendor" readonly="" ng-model="dataCompany.companyName"/>
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-primary" type="button" class="btn btn-info btn-flat"  data-toggle="modal" data-target="#myModal">. . .</button>
            </div>
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
            <span ng-if="poNumber!=null&&shipperId!=null" ng-init="getDataShipper(shipperId)"></span>
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

          <input type="submit" class="btn btn-primary btn-block btn-sm" ng-click="saveData(dataItem,dataPO,dataCompany,dataShipper)" ng-disabled="cekFinish()"/>

        </div><!-- ./chart-responsive -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.box-body -->
</div><!-- /.box -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Select Company</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Company List</h3>
              </div><!-- /.box-header -->
              <div class="box-body">
                <div class="table-responsive">
                  <table id="company" class="table table-bordered table-hover table-striped">
                    <thead>
                      <tr>
                        <th>Company ID</th>
                        <th>Name</th>
                        <th>Address</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($dataCompany->result() as $company ) {  ?>
                      <tr ng-click="setCompany(<?=$company->COMPANY;?>,'<?php echo $company->NAME; ?>')" data-dismiss="modal">
                        <td><?php echo $company->COMPANY; ?></td>
                        <td><?php echo $company->NAME; ?></td>
                        <td><?php echo $company->ADDRESS1." ".$company->ADDRESS2; ?></td>
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
  var table = $('#company').DataTable();

  $('company tbody').on( 'click', 'tr', function () {
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