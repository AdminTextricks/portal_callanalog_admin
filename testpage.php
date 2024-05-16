<!DOCTYPE html>
<html>
 <head>
  <title>Make  Toggles & Use in Form with PHP Ajax</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
 </head>
 <body>
  <br /><br />
  <div class="container" style="width:600px;">
   
   <form method="post" id="insert_data">
   
    <div class="form-group">
     <label>User Status</label>
     <div class="checkbox">
      <input type="checkbox" name="status" id="status" checked />
     </div>
    </div>
    <input type="hidden" name="hidden_status" id="hidden_status" value="Active" />
    <br />
    <input type="submit" name="insert" id="action" class="btn btn-info" value="Change Status" />
   </form>
  </div>
 </body>
</html>

<script>
$(document).ready(function(){
 
 $('#status').bootstrapToggle({
  on: 'Active',
  off: 'Deactive',
  onstyle: 'success',
  offstyle: 'danger'
 });

 $('#status').change(function(){
  if($(this).prop('checked'))
  {
   $('#hidden_status').val('Active');
  }
  else
  {
   $('#hidden_status').val('Deactive');
  }
 });

 $('#insert_data').on('submit', function(event){
  event.preventDefault();

 if($('#hidden_status').val() != '')
  {
var hidden_status=$('#hidden_status').val();

	
   $.ajax({
    url:"update.php",
    method:"POST",
    data:$(this).serialize(),
    success:function(data){
		
     if(data == 'done')
     {
      $('#insert_data')[0].reset();
      $('#status').bootstrapToggle('on');
      alert("Data Inserted");
     }
    }
   });
}
 });

});
</script>
