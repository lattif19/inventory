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
        <?php foreach ($query as $row => $value) { ?>
          <tr>
            <td><?= $value->trx_timestamp ?></td>
            <td><?= $value->trx_code ?></td>
            <td><?= $value->wonum ?></td>
            <td><?= $value->enterby ?></td>
            <td><?= $value->issueto ?></td>
            <td>
              <a href="<?php echo base_url();?>report/reportissue/<?= $value->trx_id ?>" class="btn btn-success btn-sm"><i class="fa fa-download"></i>

              <a href="<?php echo base_url();?>report/detail-report-issue/<?= $value->trx_id ?>" class="btn btn-warning btn-sm"><i class="fa fa-print"></i>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>