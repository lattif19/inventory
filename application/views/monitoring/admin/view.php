<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Monitoring Integrasi Barcode & Maximo</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
<body style="
    margin-left: 20px;
    margin-right: 20px;
">
<center><h1><?=$title;?> <?=$this->uri->segment(4);?></h1></center>


      <h2> History</h2>
      <div class="row">
        <div class="col-lg-12">
        <h6 style="font-size: 80%;">
          <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Trx So Id Detail</th>
                <th>Trx So Id</th>
                <th>Item Number</th>
                <th>Location</th>
                <th>Qty</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Trx So Id Detail</th>
                <th>Trx So Id</th>
                <th>Item Number</th>
                <th>Location</th>
                <th>Qty</th>
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
            <?php foreach ($result as $key) {?>
              <tr >
                <!-- <td><input type="text" value="<?php echo $key->trx_so_id_detail;?>" class="form-control" readonly id="trx_so_id_detail" name="trx_so_id_detail"></td>
                <td><input type="text" value="<?php echo $key->trx_so_id;?>" class="form-control" readonly id="trx_so_id" name="trx_so_id"></td>
                <td><input type="text" value="<?php echo $key->item_number;?>" class="form-control" readonly id="item_number" name="item_number"> </td>
                <td><input type="text" value="<?php echo $key->location_id;?>" class="form-control" readonly id="location_id" name="location_id"></td>
                <td><input type="text" value="<?php echo substr($key->qty,0,-4);?>" class="form-control" readonly id="qty" name="qty"></td> -->
                <!-- <td><a href="#" id ="btnEdit" onclick="changeState(this);" class="btn btn-primary btn-sm"> Update</a> <a href="#" id ="btnDelete" class="btn btn-danger btn-sm"> Delete</a></td> -->
                
                <td><?php echo $key->trx_so_id_detail;?> </td>
                <td><?php echo $key->trx_so_id;?> </td>
                <td><?php echo $key->item_number;?> </td>
                <td><?php echo $key->location_id;?> </td>
                <td><?php echo substr($key->qty,0,-4);?></td>
                <td><a href="#" onclick="edit_data('<?=$key->trx_so_id_detail?>','<?=$key->location_id?>')" class="btn btn-primary btn-sm"> Update</a> <a href="#" onclick="delete_dt('<?=$key->trx_so_id_detail?>')" class="btn btn-danger btn-sm"> Delete</a></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          </h6>
        </div>
      </div>


      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->



      <script type="text/javascript">
        function changeState(n){
          var st = $(n).html().trim()=='Update';
          if(st){
            $(n).html('Disable');
            $('#qty').prop('disabled',false);
          }else{
            $(n).html('Enable');
            $('#qty').prop('disabled',true);
          }
        }


        function edit_data(trx_so_id_detail,location_id)
        {
            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('monitoring/admin/ajax_edit/')?>/" + trx_so_id_detail+'/'+location_id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    console.log(data)
                    $('[name="trx_so_id_detail"]').val(data.trx_so_id_detail);
                    $('[name="location_id"]').val(data.location_id);
                    $('[name="item_number"]').val(data.item_number);
                    $('[name="qty"]').val(data.qty);
                    $('[name="note"]').val(data.note);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Data '+data.item_number); // Set title to Bootstrap modal title
         
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
        }


        function save()
        {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 
            var url;
            url = "<?php echo site_url('monitoring/admin/ajax_update')?>";
         
            var location = '<?=$this->uri->segment(5)?>';
            console.log('http://192.168.7.14/monitoring/monitoring/getAll/'+location)
            // ajax adding data to database
            $.ajax({
                url : url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data)
                {
                    console.log(data)

                    if(data.status) //if success close modal and reload ajax table
                    {
                        $('#modal_form').modal('hide');
                        // reload_table();
                        alert('success to update data stockopname');

                        window.location.href = "http://192.168.7.14/monitoring/monitoring/getAll/"+location;
                        // window.location.href = "http://192.168.7.14/monitoring/admin";


                    }
         
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
         
         
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error adding / update data');
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
         
                }
            });
        }
         
        function delete_dt(id)
        {

            var location = '<?=$this->uri->segment(5)?>';
            if(confirm('Are you sure delete this data?'))
            {
                // ajax delete data to database
                $.ajax({
                    url : "<?php echo site_url('monitoring/admin/ajax_delete')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        //if success reload ajax table
                        console.log(data)

                        window.location.href = "http://192.168.7.14/monitoring/monitoring/getAll/"+location;
                        // $('#modal_form').modal('hide');
                        // reload_table();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });
         }}
           
      </script>



        <!-- Bootstrap modal -->
        <div class="modal fade" id="modal_form" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Person Form</h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form">

                          <input type="hidden" value="" name="trx_so_id_detail"/> 
                          <input type="hidden" value="" name="location_id"/> 
                          <input type="hidden" value="" name="item_number"/> 
                          <div class="form-group">
                            <label for="email">Qty:</label>
                            <input type="text" class="form-control" id="qty" placeholder="Enter qty" name="qty">
                          </div>
                          <div class="form-group">
                            <label for="pwd">Note:</label>
                            <input type="text" class="form-control" id="note" placeholder="Enter note" name="note">
                          </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- End Bootstrap modal -->

    </body>
    </html>