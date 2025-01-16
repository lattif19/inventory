
  <!-- SELECT2 EXAMPLE -->
  <div class="box box-success">
    <div class="box-header with-border">
    <h3 class="box-title">Report Issue</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
      </div>
    </div><!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table id="r_issue" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Transaction Number</th>
            <th>WO</th>
            <th>Name</th>
            <th>Issue To</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($query->result() as $row => $value) { ?>
          <tr>
            <td><?= $value->trx_timestamp ?></td>
            <td><?= $value->trx_code ?></td>
            <td><?= $value->wonum ?></td>
            <td><?= $value->enterby ?></td>
            <td><?= $value->issueto ?></td>
            <td>
              <!-- <a href="<?php echo base_url();?>report/reportissue/<?= $value->trx_id ?>" class="btn btn-success btn-sm">Transaction</a> -->

              <a href="<?php echo base_url();?>report/detail-report-issue/<?= $value->trx_id ?>"  class="btn btn-success btn-sm"><i class="fa fa-download"></i></a>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div><!-- /.table-responsive -->
  </div><!-- /.box-body -->
  <div class="box-footer">
   <!--  Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about the plugin. -->
  </div>
</div><!-- /.box -->

<script>
$(document).ready( function () {
    var table = $('#r_issue').dataTable();


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
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<link src="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">