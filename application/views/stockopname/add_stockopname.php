<div class="row" ng-controller="trxStockopname">
  <!-- TRX BARCODE -->
  <div class="col-md-8" ng-hide="companyList">
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
                  <th>Condition Code</th>
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
                  <select class="form-control" ng-model="dataItem[$index].conditioncode">
                    <option value="NEW-MATERIAL">NEW-MATERIAL</option>
                    <option value="EX-PROJECT">EX-PROJECT</option>
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





<!-- trx WO,SHIPPER -->
<div class="col-md-4">
  <!-- detail foto barang -->
  <div class="box box-default" ng-hide="dataItemImage==null">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <center><img src="https://almsaeedstudio.com/themes/AdminLTE/dist/img/user2-160x160.jpg" class="img-fluid" alt="Responsive image"></center><br>
        </div><!-- ./chart-responsive -->
        <center>{{dataItemImage}}</center>
        <center>{{dataItemName}}</center>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div>

  <div class="box box-default">
    <div class="box-body">
      <table width="100%" border="0" cellpadding="0">
        <tr>
        <label>Location</label>
            <select class="form-control" ng-model="dataLocation" ng-disabled="dataLocation">
            <?php foreach ($dataLocation as $location) {?>
              <option value="<?=$location->LOCATION;?>"><?=$location->LOCATION;?></option>
              <?php } ?>
            </select>
          </tr>

          <tr>
            <td><input type="text"  hidden name="enterby" id="enterby" value="<?php echo $this->session->userdata('nama'); ?>" placeholder=""></td>
          </tr>
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
            <button type="submit" class="btn btn-primary btn-block btn-sm" ng-click="saveData(dataItem,dataLocation)">Finish</button>
          </div><!-- ./chart-responsive -->
        </div><!-- /.col -->
      </div><!-- /.row -->
  </div><!-- /.box-body -->
</div><!-- /.box -->





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

