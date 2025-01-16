<div class="box">
  <div class="box-header">
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table id="r_receiving" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Transaction Number</th>
            <th>PO</th>
            <th>Name</th>
            <th>Action</th>
          </tr>
        </thead>
       <!--  <thead>
          <tr>
            <th>
              <select name="location_id" id="location_id" class="form-control select2">
                <?php foreach ($data->result() as $value) {?>
                  <option value="<?php echo $value->location_id; ?>"><?php echo $value->name; ?></option>
                <?php } ?>
              </select>
            </th>
            <th>Transaction Number</th>
            <th>PO</th>
            <th>Name</th>
            <th>Action</th>
          </tr>
        </thead> -->
        <tbody>
        <?php foreach ($query->result() as $row => $value) { ?>
          <tr>
            <td><?= $value->trx_timestamp ?></td>
            <td><?= $value->trx_code ?></td>
            <td><?= $value->ponum ?></td>
            <td><?= $value->enterby ?></td>
            <td>
              <!-- <a href="<?php echo base_url();?>report/reportreceiving/<?= $value->trx_id ?>" class="btn btn-success btn-sm">Transaction</a> -->
              <a href="<?php echo base_url();?>report/detail-report-receive/<?= $value->trx_id ?>" class="btn btn-success btn-sm"><i class="fa fa-download"></i></a>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box-body -->     
</div><!-- /.box -->

<!-- <script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
 -->
<!-- 
<script>
  $(document).ready(function() {
    var table = $('#r_receiving').DataTable({
      dom: 'Bfrtip',
        buttons: [
          'copyHtml5',
          'excelHtml5',
          'csvHtml5',
          'pdfHtml5'
        ]
    });
    $('#r_receiving tbody').on( 'click', 'tr', function () {
      if ( $(this).hasClass('selected') ) {
        $(this).removeClass('selected');
      } else {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
      }
    } );
       
    $('#button').click( function () {
      table.row('.selected').remove().draw( false );
    } );
  } );
</script>     -->


<script>
$(document).ready( function () {
    var table = $('#r_receiving').dataTable();


    $(function() {
        $("#date").datepicker();
        $("#date1").datepicker();
    });

  // ajax to query attendance
  $("#btnFind").click(function(){

      var from = $("#date").val();
      var to = $("#date1").val();

      $.ajax({
          url:"<?=base_url('report/getdata')?>",
          type:"POST",
          data:{date:from, date1:to},
          dataType: "html",
          success:function(msg){
            // console.log(msg);
            $("#r_issue").html(msg);
            table.ajax.reload();
      }
    })
  })

  // var findData = $("#btnFInd").click(function(){
    
  //     var from = $("#date").val();
  //     var to = $("#date1").val();

  //     $.ajax({
  //         type:"POST",
  //         url:"<?=base_url('report/getdata')?>"+findData+"",
  //         data:{date:from, date1:to},
  //         dataType:'json',
  //         success:function(msg){
  //           $("#r_issue").html(msg);
  //         },
  //         error:function(XMLHttpRequest){
  //           alert(XMLHttpRequest.responseText);
  //         }
  //     })
  //   })                                      

} );
</script>