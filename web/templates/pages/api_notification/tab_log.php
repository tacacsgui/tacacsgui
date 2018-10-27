<div class="box box-solid">
  <div class="box-body">
    <?php
    $addBtn = [];
    $filterBtn = false;
    $filterHint = 'e.g. username=user1, nas=10.1.1.1';
    $filterPopover =
    [
      'username' => 'Username',
      'nas' => 'NAS IP Address',
      'nac' => 'NAC IP Address',
      'cmd' => 'Command',
      'action' => 'Action',
      'line' => 'Line',
      'id' => 'ID',
    ];
    //$extraBtn = ['exportCsv' => true, 'delete' => false];
    require __DIR__ . '/../../../templates/parts/part_tableManager.php';
    ?>
    <div class="table-responsive">
      <table id="postLogDataTable" class="table-striped display table table-bordered" style="overflow: auto;">

      </table>
    </div>
  </div>
</div>
