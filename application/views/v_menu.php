<ul class="sidebar-menu">
  <li class="header">Sub Menu Navigation  </li>
    <li <?php if ($this->uri->segment(1) == 'master-data') {echo 'class="active"'; }?> >
      <ul class="treeview-menu" id="master">
        <li <?php if ($this->uri->segment(2) == 'barcode') {echo 'class="active"';} ?>><a href="<?php echo base_url(); ?>master-data/barcode"><i class="fa fa-barcode"></i> Barcode</a></li>
        <li <?php if ($this->uri->segment(2) == 'items') {echo 'class="active"';} ?>><a href="<?php echo base_url(); ?>master-data/items"><i class="fa fa-list"></i> Item</a></li>
        <!-- <li <?php if ($this->uri->segment(2) == 'barcode') {echo 'class="active"';} ?>><a href="<?php echo base_url(); ?>master-data/commodity"><i class="fa fa-reorder"></i> Commodity</a></li>-->
		<li <?php if ($this->uri->segment(2) == 'location') {echo 'class="active"';} ?>><a href="<?php echo base_url(); ?>master-data/location"><i class="fa fa-location-arrow"></i> Location</a></li>
        <li <?php if ($this->uri->segment(2) == 'measureunit') {echo 'class="active"';} ?>><a href="<?php echo base_url(); ?>master-data/measureunit"><i class="fa fa-file-text-o"></i> Measureunit</a></li>
        <li <?php if ($this->uri->segment(2) == 'companies') {echo 'class="active"';} ?>><a href="<?php echo base_url(); ?>master-data/companies"><i class="fa fa-circle-o"></i> Companies</a></li>
      </ul>
    </li>
    <li <?php if ($this->uri->segment(1) == 'transaction') {echo 'class="active"'; }?>>
        <ul class="treeview-menu" id="transaction">
          <li <?php if ($this->uri->segment(2) == 'receiving') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>transaction/receiving"><i class="fa fa-book"></i> Receiving</a></li>
          <li <?php if ($this->uri->segment(2) == 'issue') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>transaction/issue"><i class="fa fa-book"></i> Issue</a></li>


          <li <?php if ($this->uri->segment(2) == 'receiving_non_po') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>transaction/receiving_non_po"><i class="fa fa-book"></i> Mapping Receiving</a></li>
          <li <?php if ($this->uri->segment(2) == 'issue_non_wo') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>transaction/issue_non_wo"><i class="fa fa-book"></i> Mapping Issue</a></li>

          <li <?php if ($this->uri->segment(2) == 'rtrn_vendor') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>transaction/rtrn_vendor"><i class="fa fa-book"></i> Return To Vendor</a></li>
          <li <?php if ($this->uri->segment(2) == 'rtrn_warehouse') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>transaction/rtrn_warehouse"><i class="fa fa-book"></i> Return To Warehouse</a></li>
<!--           <li <?php if ($this->uri->segment(2) == 'mapping-po') {echo 'class="active treeview"'; } elseif ($this->uri->segment(2) == 'mapping-wo') { echo 'class="active"'; }?>>
              <a href="#"><i class="fa fa-outdent"></i> Mapping <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li <?php if ($this->uri->segment(3) == 'mapping-po') {echo 'class="active"';} ?>><a href="<?php echo base_url(); ?>transaction/mapping-po/mapping-po"><i class="fa fa-book"></i> Receiving (PO)</a></li>
                <li <?php if ($this->uri->segment(3) == 'mapping-wo') {echo 'class="active"';} ?>><a href="<?php echo base_url(); ?>transaction/mapping-wo/mapping-wo"><i class="fa fa-book"></i> Issue (WO)</a></li>
              </ul>
          </li> -->
          <li <?php if ($this->uri->segment(2) == 'stockopname') {echo 'class="active"'; }?>>
            <a href="#"><i class="fa fa-outdent"></i> Stock Opname <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li <?php if ($this->uri->segment(3) == 'periode') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>transaction/stockopname/periode"><i class="fa fa-book"></i> Periode</a></li>
              <li <?php if ($this->uri->segment(3) == 'list-stockopname') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>transaction/stockopname/list-stockopname"><i class="fa fa-book"></i> Stock Opname</a></li>
            </ul>
          </li>
          <li <?php if ($this->uri->segment(2) == 'adjustment') {echo 'class="active"'; }?>>
            <a href="#"><i class="fa fa-outdent"></i> Adjustment <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li <?php if ($this->uri->segment(2) == 'adjustment') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>transaction/adjustment"><i class="fa fa-book"></i> Adjustment</a></li>
              <li <?php if ($this->uri->segment(3) == 'list-adjustment') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>transaction/adjustment/list-adjustment"><i class="fa fa-book"></i> List Adjustment</a></li>
            </ul>
          </li>
         <!-- <li <?php if ($this->uri->segment(2) == 'adjustment') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>transaction/adjustment"><i class="fa fa-book"></i> Adjusment Stock</a></li> -->
          <!-- <li >
            <a href="#">
              <i class="fa fa-share"></i> <span>Borrow</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li <?php if ($this->uri->segment(2) == 'borrow') {echo 'class="active"'; }?>>
                <a href="#"><i class="fa fa-circle-o"></i> Borrow <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li <?php if ($this->uri->segment(3) == 'tools') {echo 'class="active"'; }?>><a href="<?php echo base_url();?>transaction/borrow/tools"><i class="fa fa-circle-o"></i> Tools</a></li>
                  <li <?php if ($this->uri->segment(3) == 'items') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>transaction/borrow/items"><i class="fa fa-circle-o"></i> Items</a></li>
                  <li <?php if ($this->uri->segment(3) == 'services') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>transaction/borrow/services"><i class="fa fa-circle-o"></i> Service</a></li>
                </ul>
              </li>
              <li <?php if ($this->uri->segment(2) == 'borrow') {echo 'class="active"'; }?>>
                <a href="#"><i class="fa fa-circle-o"></i> Return <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li <?php if ($this->uri->segment(3) == 'return-tools') {echo 'class="active"'; }?>><a href="#"><i class="fa fa-circle-o"></i> Tools</a></li>
                  <li <?php if ($this->uri->segment(3) == 'return-items') {echo 'class="active"'; }?>><a href="#"><i class="fa fa-circle-o"></i> Items</a></li>
                  <li <?php if ($this->uri->segment(3) == 'return-services') {echo 'class="active"'; }?>><a href="#"><i class="fa fa-circle-o"></i> Service</a></li>
                </ul>
              </li>
            </ul>
           </li> -->
         <!-- <li <?php if ($this->uri->segment(2) == 'transfer') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>transaction/transfer"><i class="fa fa-book"></i> Transferk</a></li> -->
        </ul>
    </li>
    <li <?php if ($this->uri->segment(1) == 'report') {echo 'class="active"'; }?>>
        <ul class="treeview-menu" id="report">
          <li><?php //echo anchor('transaction/receiving/admin', 'Receiving (PO)', 'class="fa fa-circle-o"') ?></li>
          <li <?php if ($this->uri->segment(2) == 'receiving') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>report/receiving"><i class="fa fa-print"></i> Receiving</a></li>
          <li <?php if ($this->uri->segment(2) == 'issue') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>report/issue"><i class="fa fa-print"></i> Issue</a></li>

          <li <?php if ($this->uri->segment(2) == 'vendor') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>report/vendor"><i class="fa fa-print"></i> Return To Vendor</a></li>
          <li <?php if ($this->uri->segment(2) == 'warehouse') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>report/warehouse"><i class="fa fa-print"></i> Return To Warehouse</a></li>
          <li <?php if ($this->uri->segment(2) == 'stockopname') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>report/stockopname"><i class="fa fa-print"></i> Stockopname</a></li>
          <!-- <li>
            <a href="#"><i class="fa fa-outdent"></i> Stock Opname <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li <?php if ($this->uri->segment(2) == 'stockopname') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>report/stockopname"><i class="fa fa-print"></i> Stockopname</a></li>
              <li <?php if ($this->uri->segment(2) == 'compare') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>report/compare-stockopname"><i class="fa fa-print"></i> Compare</a></li>
            </ul>
          </li> -->
         <li <?php if ($this->uri->segment(2) == 'adjustment') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>report/adjustment"><i class="fa fa-print"></i> Adjusment Stock</a></li>
          <!-- <li>
            <a href="#"><i class="fa fa-outdent"></i> Stock<i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li <?php if ($this->uri->segment(2) == 'balance') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>report/balance"><i class="fa fa-print"></i> Balance</a></li>
              <li <?php if ($this->uri->segment(2) == 'stock-tools') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>report/stock-tools"><i class="fa fa-print"></i> Stock Tools</a></li>
              <li <?php if ($this->uri->segment(2) == 'stock-movement') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>report/stock-movement"><i class="fa fa-print"></i> Stock Movement</a></li>
              <li <?php if ($this->uri->segment(2) == 'card-stock') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>report/card-stock"><i class="fa fa-print"></i> Card Stock</a></li>
            </ul>
          </li>
          <li <?php if ($this->uri->segment(2) == 'borrow') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>report/borrow"><i class="fa fa-print"></i> Borrow</a></li> -->
        </ul>
    </li>
    <li <?php if ($this->uri->segment(1) == 'admin') {echo 'class="active"'; }?>>
        <ul class="treeview-menu" id="user">
        <!-- <li>
            <a href="<"><i class="fa fa-users"></i> Users <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li <?php if ($this->uri->segment(1) == 'admin') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>admin"><i class="fa fa-user"></i> Right</a></li>
              <li <?php if ($this->uri->segment(2) == 'list') {echo 'class="active"'; }?>><a href="#"><i class="fa fa-user"></i> List</a></li>
            </ul>
          </li> -->
          <li <?php if ($this->uri->segment(1) == 'admin') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>admin"><i class="fa fa-users"></i> User</a></li>
          <li <?php if ($this->uri->segment(2) == 'shipper') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>admin/shipper"><i class="fa fa-user"></i> Shipper</a></li>
          <li <?php if ($this->uri->segment(2) == 'person') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>admin/person"><i class="fa fa-user"></i> Person</a></li>
          <li <?php if ($this->uri->segment(2) == 'log-activities') {echo 'class="active"'; }?>><a href="<?php echo base_url(); ?>admin/log-activities"><i class="fa fa-hourglass"></i> Log Activities</a></li>
          
        </ul>
    </li>
</ul>