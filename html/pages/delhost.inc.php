<?php

if ($_SESSION['userlevel'] < 10) {
    require 'includes/error-no-perm.inc.php';
    exit;
}

$pagetitle[] = "Delete device";

if ($_SESSION['userlevel'] == 11) {
    demo_account();
}
else {

    if (is_numeric($vars['id'])) {
        echo('
            <div class="row">
            <div class="col-sm-offset-2 col-sm-7">
            ');
        if ($vars['confirm']) {
            print_message(nl2br(delete_device(mres($vars['id'])))."\n");
        }
        else {
            $device = device_by_id_cache($vars['id']);
            print_error("Are you sure you want to delete device " . $device['hostname'] . "?");
?>
<br />
<center>
  <font color="red"></font><i class="fa fa-exclamation-triangle fa-3x"></i></font>
  <br>
  <form name="form1" method="post" action="" class="form-horizontal" role="form">
    <div class="form-group">
      <input type="hidden" name="id" value="<?php echo $vars['id'] ?>" />
      <input type="hidden" name="confirm" value="1" />
      <!--<input type="hidden" name="remove_rrd" value="<?php echo $vars['remove_rrd']; ?>">-->
      <button type="submit" class="btn btn-danger">Confirm host deletion</button>
    </div>
  </form>
</center>
<?php
        }
        echo('
    </div>
  </div>');
    }
    else {
?>

    <form name="form1" method="post" action="" class="form-horizontal" role="form">
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-7">
          <div><h2>Delete Device</h2></div>
            <div class="alert alert-danger" role="alert">
                <center>
                  <p>Warning, this will remove the device from being monitered!</p>
                  <p>It will also remove historical data about this device such as <mark>Syslog</mark>, <mark>Eventlog</mark> and <mark>Alert log</mark> data.</p>
                </center>
              </div>
              <div class="well">
                <div class="form-group">
                  <label for="id" class="col-sm-2 control-label">Device:</label>
                  <div class="col-sm-10">
                    <select name="id" class="form-control" id="id">
                    <?php
                    foreach (dbFetchRows("SELECT * FROM `devices` ORDER BY `hostname`") as $data) {
                        echo("<option value='".$data['device_id']."'>".$data['hostname']."</option>");
                    }

                    ?>
                    </select>
                  </div>
                </div>
                <hr>
                <input id="confirm" type="hidden" name="confirm" value="0" />
                <center><button id="confirm_delete" type="submit" class="btn btn-default">Delete Device</button></center>
              </div>
  <div class="form-group">
 <!-- <tr>
    <td>Remove RRDs (Data files): </td>
    <td><input type="checkbox" name="remove_rrd" value="yes"></td>
  </tr>-->
</form>
<?php
    }
}
