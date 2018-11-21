<div class="row">
  <div class="col-xs-12">
    <div class="dropdown pull-right">
      <?php if( !empty($addBtn) ) : ?>
      <?php if( empty($addBtn['html']) ) : ?>
      <a class="btn btn-flat btn-success" id="<?php echo $addBtn['id']; ?>" data-toggle="modal" data-target="<?php echo $addBtn['modalId']; ?>"><?php echo $addBtn['name']; ?></a>
      <?php endif; ?>
      <?php if( !empty($addBtn['html']) ) : ?>
      <?php echo  $addBtn['html'];?>
      <?php endif; ?>
      <?php endif; ?>
      <?php if( $filterBtn ) : ?>
      <a class="btn btn-flat btn-info" onclick="dataTable.settings.filter()">Filter</a>
      <?php endif; ?>
      <?php if( !empty($extraBtn) ) : ?>
      <div class="btn-group">
        <button type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown">
          Action <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right">
          <?php if( !empty($extraBtn['exportCsv']) ) : ?>
          <li><a href="#" onclick="dataTable.settings.exportCsv()">Export Selected (CSV)</a></li>
          <?php endif; ?>
          <?php if( !empty($extraBtn['delete']) ) : ?>
          <li><a href="#" onclick="dataTable.settings.deleteSelected()">Delete Selected</a></li>
          <?php endif; ?>
        </ul>
      </div>
      <a class="btn btn-flat btn-warning" href="javascript: void(0)" id="exportLink" style="display: none;" target="_blank"><i class="fa fa-download"></i></a>
      <?php endif; ?>
      <div class="btn-group">
        <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
          More Columns <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right" id="<?php echo ( !empty($columnFilterBtn['filter_id']) ) ? $columnFilterBtn['filter_id'] :  'columnsFilter'; ?>">

        </ul>
      </div>
    </div>
  </div>
</div>
<?php if( $filterBtn ) : ?>
<div class="datatable-filter" style="display: none;">
  <div class="row">
    <div class="col-xs-12">
      <div class="form-group">
        <label>Table Filter</label>
        <div class="input-group input-group-sm">
          <input type="text" class="form-control" id="filterRequest" placeholder="Filter attributes...">
          <span class="input-group-btn">
            <button type="button" class="btn btn-flat btn-default" onclick="dataTable.settings.filterErase()"><i class="fa fa-close"></i></button>
          </span>
        </div>
        <p class="text-muted"><?php echo $filterHint; ?></p>
        <button class="btn btn-flat btn-default" id="filterInfo" data-placement="bottom" title="Filter Info"><i class="fa fa-info"></i> Filter Info</button>
        <div class="filterMessage pull-right" style="display: none;"></div>
      </div>
    </div>
  </div>
  <div class="filter-info-content">
  	<div class="box box-solid">
  		<div class="box-body">
  			<div class="filter-info-part attributes">
  				<h4>List of Attributes</h4>
          <?php foreach ($filterPopover as $key => $description) {
            echo '<p><b>'.$key.'</b> - '.$description.'</p>';
          } ?>
  			</div>
  			<div class="filter-info-part conditions" style="display:none">
  				<h4>List of Conditions</h4>
  				<p><b>=</b> - implicit equal</p>
  				<p><b>!=</b> - implicit not equal</p>
  				<p><b>==</b> - equal</p>
  				<p><b>!==</b> - not equal</p>
  			</div>
  		</div>
  		<div class="box-footer">
  			<button type="button" onclick="$('.filter-info-part').hide(); $('.filter-info-part.attributes').show();">Attributes</button>
  			<button type="button" onclick="$('.filter-info-part').hide(); $('.filter-info-part.conditions').show();">Conditions</button>
  		</div>
  	</div>
  </div>
</div>
<?php endif; ?>
