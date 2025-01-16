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



<select name="forma" class="form-control input-lg" onchange="location = this.value;">
  <option value="" selected>Pick a Location</option>
  <option <?php if($this->uri->segment(4)=="WH"){echo "selected";}?> value="http://192.168.7.14/monitoring/admin/index/WH">WH</option>
  <option <?php if($this->uri->segment(4)=="WH2"){echo "selected";}?> value="http://192.168.7.14/monitoring/admin/index/WH2">WH #2</option>
  <option <?php if($this->uri->segment(4)=="WH3"){echo "selected";}?> value="http://192.168.7.14/monitoring/admin/index/WH3">WH #3</option>
  <option <?php if($this->uri->segment(4)=="CHEM"){echo "selected";}?> value="http://192.168.7.14/monitoring/admin/index/CHEM">CHEM UNIT 1 & 2</option>
  <option <?php if($this->uri->segment(4)=="WHSP3"){echo "selected";}?> value="http://192.168.7.14/monitoring/admin/index/WHSP3">WHSP3</option>
  <option <?php if($this->uri->segment(4)=="WHSP3A"){echo "selected";}?> value="http://192.168.7.14/monitoring/admin/index/WHSP3A">WHSP3A</option>
</select>
      <h2> Sudah Terscan</h2>
      <div class="row">
        <div class="col-lg-12">
          <?php if ($this->session->flashdata('message')) { ?>
            <div class="alert alert-success">
              <strong>Success!</strong> <?=$this->session->flashdata('message')?>.
            </div>
          <?php } ?>
        <h6 style="font-size: 80%;">
          <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Item Number</th>
                <th>Location</th>
                <th>Bin</th>
                <th>Maximo Balances</th>
                <th>SO Balances</th>
                <th>Selisih</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Item Number</th>
                <th>Location</th>
                <th>Bin</th>
                <th>Maximo Balances</th>
                <th>SO Balances</th>
                <th>Selisih</th>
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
            <?php echo "Generate at ".date('Y-m-d H:i:s');foreach ($result as $key) {?>
              <tr >
                <td><?php echo $key->item_number;?></td>
                <td><?php echo $key->location;?></td>
                <td><?php echo $key->binnum;?></td>
                <td><?php echo substr($key->qty,0,-4);?></td>
                <td><?php echo substr($key->qtySo,0,-4);?></td>
                <td><?php if($key->selisih>0){echo "+";}?><?php echo $key->selisih;?></td>
                <td><a href="<?=base_url()?>monitoring/admin/view/<?=$key->item_number?>/<?=$key->location?>" class="btn btn-primary btn-sm"> Edit</a></td>
                <!-- <td><a href="#" onclick="edit_data('<?=$key->item_number?>','<?=$key->location?>')" class="btn btn-primary btn-sm"> Edit</a></td> -->
              </tr>
              <?php } ?>
            </tbody>
          </table>
          </h6>
        </div>
      </div>


      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->




      <script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script type="text/javascript">
        $(document).ready(function() {
          $('#example').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
          });
        } );
        $(document).ready(function() {
          $('#example2').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
          });
        } );
        $(document).ready(function() {
          $('#example3').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
          });
        } );

        function edit_data(item_number,location)
        {
            if (location=='WH') {
              location_id = 1203;
            } else if (location=='WH2') {
              location_id = 2201;
            } else if (location=='WH3') {
              location_id = 2301;
            }
            save_method = 'update';
         
            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('monitoring/admin/ajax_edit/')?>/" + item_number+'/'+location_id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    console.log(data)
                    // $('[name="id"]').val(data.id);
                    // $('[name="firstName"]').val(data.firstName);
                    // $('[name="lastName"]').val(data.lastName);
                    // $('[name="gender"]').val(data.gender);
                    // $('[name="address"]').val(data.address);
                    // $('[name="dob"]').datepicker('update',data.dob);
                    // $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    // $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title
         
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
        }
      </script>

    </body>
    </html>