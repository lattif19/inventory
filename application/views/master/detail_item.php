<div class="box box-default">
  <div class="box-header with-border">
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered">
            <tr>
              <th class="col-md-3" >Item Number :</th>
              <th class="col-md-5" >: <?php echo $item_number; ?></th>
              <td class="col-md-4" rowspan="6" align="center"><img  src="<?php echo base_url(); ?>assets/uploads/items/<?php echo $photo; ?>" class="img-responsive" alt="">
              <form action="<?php echo base_url(); ?>master-data/upload-items" method="post" enctype="multipart/form-data">
              	<div class="box-body">
		              <input type="hidden" value="<?php echo $item_number; ?>" class="form-control" name="item_number" id="item_number">
		              <input type="file" name="filefoto" class="form-control">
			          <input type="submit" name="userSubmit" value="Upload Photo" class="btn btn-primary pull-right">
	        	</div><!-- /.box-body -->
	        </form>
              </td>
          	</tr>
            <tr>
              <th>Location </th>
              <td>: 
              <?php echo $location; ?>
              </td>
            </tr>
            <tr>
              <th>Condition Code</th>
              <td>: 
              <?php 
                if ($item_number) {
                  echo $condition_code;
                } else {
                  echo "string";
                }
              ?>
              </td>
            </tr>
            <tr>
              <th>Binnum </th>
              <td>: 
              <?php 
                if ($item_number) {
                  echo $binnum;
                } else {
                  echo "string";
                }
              ?>
              </td>
            </tr>
            <tr>
              <th>Site ID </th>
              <td>: 
              <?php 
                if ($item_number) {
                  echo $siteid;
                } else {
                  echo "string";
                }
              ?>
              </td>
            </tr>
            <tr>
              <th>Qty </th>
              <td>: 
              <?php 
                if ($item_number) {
                  echo $qty;
                } else {
                  echo "string";
                }
              ?>
              </td>
            </tr>
        </table>
      </div>
    </div><!-- /.row -->
  </div><!-- /.box-body -->
</div><!-- /.box -->

    <div class="box box-info">
      <div class="box-body">
       <a href="<?php echo base_url();?>master-data/export_excel/<?php echo $item_number; ?>/<?php echo $location_id; ?>/<?php echo $condition_code; ?>/<?php echo $binnum; ?>" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</a>
        <div class="table-responsive">
          <table class="table no-margin" id="detail_periode">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Saldo</th>
                <th>Transaksi</th>
                <th>Referensi</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($listTransaction as $row) { ?>
              <tr>
                <td><?php echo $row->timestamp; ?></td>
                <td>
                	<?php
                	if ($row->trx == "Dr") {
                		echo $row->qty;
                	} else {
                		echo "-";
                	}
                	?>
                </td>
                <td>
                	<?php 
                	if ($row->trx == "Kr") {
                		echo $row->qty;
                	} else {
                		echo "-";
                	}
                	?>
                </td>
                <td><?php echo $row->currentBalance; ?></td>
                <td><?php echo $row->trx_detail; ?></td>
                <td> 
                <?php
                  if ($row->trx_code == "1") {
                     echo '<a href="'.base_url().'transaction/receiving/detailByTrxCode/'.$row->trx_reff.'">#'.$row->trx_reff.'</a>';
                   } elseif ($row->trx_code == "2") {
                     echo '<a href="'.base_url().'transaction/issue/detailByTrxCode/'.$row->trx_reff.'">#'.$row->trx_reff.'</a>';
                   } elseif ($row->trx_code == "3") {
                     echo '<a href="'.base_url().'transaction/rtrn-vendor/detailByTrxCode/'.$row->trx_reff.'">#'.$row->trx_reff.'</a>';
                   } elseif ($row->trx_code == "4") {
                     echo '<a href="'.base_url().'transaction/rtrn-warehouse/detailByTrxCode/'.$row->trx_reff.'">#'.$row->trx_reff.'</a>';
                   }else{
                    echo $row->trx_reff;
                   }
                ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div><!-- /.table-responsive -->
        <div class="box-footer">
          <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-warning btn-sm pull-left"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
<script>
     $(document).ready(function() {
          var table = $('#detail_periode').DataTable({
            "stateSave": true, //simpan page teralhir
            dom: 'Bfrtip',
            buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
          });
       
          $('#detail_periode tbody').on( 'click', 'tr', function () {
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

<div class="modal fade hide modal-creator" id="myModal" style="display: none;" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Edit Gallery</h3>
    </div>
    <div class="modal-body"><?php echo form_open('url'); ?>

    <div class="row">
        <div class="span5">
            <?php print_r($galleryName); ?>
            <div class="control-group">
                <?php
                    $galleryName = array(
                        'id'            => 'galleryName',
                        'name'          => 'galleryName',
                        'placeholder'   => 'Gallery Name',
                        'required'      => 'required',
                    );
                    echo form_label('Gallery Name:', 'galleryName');
                    echo form_input($galleryName);
                ?>
            </div><!-- /control-group -->
       </div><!--/span5-->
   </div><!--/row-->
</div><!-- /modal-body -->

<div class="modal-footer">
    <!-- <p class="span3 resize">The following images are sized incorrectly. Click to edit</p> -->
    <a href="javascript:;" class="btn" data-dismiss="modal">Close</a>
    <a href="javascript:;" class="btn btn-primary">Next</a>
</div>