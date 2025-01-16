<div class="row" ng-controller="trxReceiving">
  <!-- TRX BARCODE -->
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
       <div class="form-group">
        <form ng-submit="getItem(itemNumber)">
          <input id="show1" name="barcode" autocomplete="off" ng-model="itemNumber" type="text" placeholder="BARCODE" class="form-control input-lg">
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
                  <th>Received Unit</th>
                  <th>From Location</th>
                  <th>To Location</th>
                  <th>From Bin</th>
                  <th>To Bin</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-class="{info : activeItem === $index}" ng-repeat="itemList in dataItem" ng-click="showItemImage($index)">
                  <td>{{itemList.ITEMNUM}}</td>
                  <td>{{itemList.description}}</td>
                  <td>{{itemList.QUANTITY}}</td>
                  <td>{{itemList.RECEIVEDUNIT}}</td>
                  <td>{{itemList.FROMSTORELOC}}</td>
                  <td>{{itemList.TOSTORELOC}}</td>
                  <td>{{itemList.FROMBIN}}</td>
                  <td>{{itemList.TOBIN}}</td>
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

<!-- <script>
  myFunctionPrint=function(trxId){
    var qtyPrint = prompt('Please enter Qty','10');
    if (qtyPrint != null && qtyPrint != "") {
      var url = '<?php echo base_url(); ?>report/print_receiving/'+trxId;
      var W = window.open(url);
    }
  }
</script> -->


<script>
  var myVar;

  function myFunctionPrint() {
      myVar = setTimeout(alertFunc, 1000);
  }

  function alertFunc(trxId) {
    
    var url = '<?php echo base_url(); ?>report/print_receiving/'+trxId;
    var w = window.open(url);
  }
</script>


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