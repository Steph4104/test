
<?php

require_once 'database.php';
$con=mysqli_connect($db_host, $db_username, $db_password,$db_name);
$survivor_id = $_POST['id'];

if($_POST['type'] == 'head' || $_POST['type'] == 'box_head_1'){

 $value = $_POST['value'];
	$sql = "UPDATE armor_stat SET HEAD ='".$value."' WHERE ID_SURVIVOR='".$_POST['id']."'";

	if ($con->query($sql) === TRUE) {
	    error_log('sucess');
	} else {
	    error_log( "Error updating record: " . $con->error);
	}

    $head = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM armor_stat WHERE ID_SURVIVOR = $survivor_id"));
	echo '<input type="text" class="form-control update_armor" id="head" value='.($head['HEAD'] >= 0 ?  $head['HEAD'] : 0).' >';
	echo '<input class=".form-check-inline update_armor" type="checkbox" value="-1" id="box_head_1"  '.($head['HEAD'] <= -1 ? 'checked' : '').' >';
  echo '<input class=".form-check-inline update_armor" type="hidden" value="-1" id="box_head_1"  '.($head['HEAD'] <= -1 ? 'checked' : '').' >';

} else if ($_POST['type'] == 'arm' || $_POST['type'] == 'arm_box_1' || $_POST['type'] == 'arm_box_2'){

  $value = $_POST['value'];
  $sql = "UPDATE armor_stat SET ARMS ='".$value."' WHERE ID_SURVIVOR='".$_POST['id']."'";

  if ($con->query($sql) === TRUE) {
      error_log('sucess');
  } else {
      error_log( "Error updating record: " . $con->error);
  }

    $arms = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM armor_stat WHERE ID_SURVIVOR = $survivor_id"));


  echo '<input type="text" class="form-control update_armor" id="arm" value='.($arms['ARMS'] >= 0 ?  $arms['ARMS'] : 0).'>';
  echo' <input class="form-check-input update_armor" type="checkbox" value="-1" id="arm_box_1" class="arm_box_1" '.($arms['ARMS'] < 0 ? 'checked' : '').'>';
  echo' <input class="form-check-input update_armor" type="checkbox" value="-2" id="arm_box_2" class="arm_box_2" '.($arms['ARMS'] < -1 ? 'checked' : '').'>';




}
?>
<script>
 $('.update_armor').off().on('change', function() {
	alert('on change');
   var itemVal = $(this).val();
   var character = <?php echo $survivor_id; ?>;
   var itemID = $(this).attr('id');

if ($(this).is('input:checkbox')){

  switch (itemID) {
    case 'box_head_1':
var ischecked= $(this).is(':checked');

    if(!ischecked){
          itemVal = 0;

    alert('uncheckd ' + itemVal);
 
    }


      break;

    case 'arm_box_1':

    var ischecked= $(this).is(':checked');

    if(!ischecked){
          itemVal = 0;

    alert('uncheckd ' + itemVal);
 
    }
    break;
    case 'arm_box_2':

     var ischecked= $(this).is(':checked');

    if(!ischecked){
          itemVal = -1;

    alert('uncheckd2 ' + itemVal);
 
    }
      break;
  }

}
    

 $.ajax({
   url: "update_armor.php",
   type: 'POST',
   data: { value: itemVal, id : character, type: itemID} ,
 }).success(function(data){
 switch (itemID) {
    case 'head':
    case 'box_head_1':
      var section = '#update_head';
      break;
    case 'arm':
    case 'arm_box_1':
    case 'arm_box_2':
      var section = '#update_arms';
      break;
}
   $(section).html(data);
 });
 });
</script>          	 
