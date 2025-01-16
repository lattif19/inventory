<div class="box box-success">
    <div class="box-body">
    	<table id="example1" class="table table-bordered table-striped">
        	<thead>
              <tr>
                <th>Date</th>
                <th>Trx So Code</th>
                <th>Year</th>
                <th>Location</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($detailPeriode->result() as $row) : ?>
              <tr>
              	<td><?php echo $row->trx_so_date; ?></td>
                <td><?php echo $row->trx_so_code; ?></td>
                <td><?php echo $row->trx_so_year; ?></td>
                <td><?php echo $row->location_id; ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->