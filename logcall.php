<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Police Emergency Servvice System</title>
<link href="folder/yunqistyle.css" rel="stylesheet" type="text/css">
</head>

<body>
  <script>
  function YunQi()
    {
      var x=document.forms["frmLogCall"]["callerName"].value;
      if (x==null || x=="")
        {
          alert("Caller Name is required.");
          return false;
        }
    }
  </script>
  <?php require 'nav.php';?>
  <?php require 'db.php';
  $mysqli = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
  if ($mysqli->connect_error)
  {
    die("Unable to connect to Database:".$mysqli->connect_errno);
  }
  
  $sql = "Select * FROM incidenttype";
  
  if (!($stmt = $mysqli->prepare($sql)))
  {
    die("Command error: ".$mysqli->errno);
  }
  
  if (!$stmt->execute())
  {
    die("Cannot Run SQL command: ".$stmt->errno);
  }
  
  if (!($resultset = $stmt->get_result())) {
    die("No data in resultset: ".$stmt->errno);
  }
  
  $incidentType;
  
  while ($row = $resultset->fetch_assoc()) {
     $incidentType[$row['incidentTypeId']] = $row['incidentTypeDesc'];
  }
  $stmt->close();
  
  $resultset->close();
  
  $mysqli->close();
  
  ?>
<fieldset>
  <legend>Log Call</legend>
  <form name="frmLogCall" method="post" action="dispatch.php" onSubmit="return YunQi();">
  <table width="40%" border="1" align="center" cellpadding="4" cellspacing="4">
  <tr>
  <td width="50%">Caller's Name :</td>
  <td width="50%"><input type="text" name="callerName" id="callerName"></td>
  </tr>
<tr>
  <td width="50%">Contact No :</td>
  <td width="50%"><input type="text" name="contactNo" id="contactNo"></td>
  </tr>
  <tr>
  <td width="50%">Location :</td>
  <td width="50%"><input type="text" name="location" id="location"></td>
  </tr>
  <tr>
<td width="50%">Incident Type :
    <td width="50%"><select name="incidentType" id="incidentType">
    <?php
    foreach($incidentType as $incident=>$data){
      echo "<option value='$data'>$data</option>";
    }
    ?>
    </select>
      </td>
  </tr>
    <tr>
    <td width="50%">Description :</td>
    <td width="50%"><textarea name="IncidentDesc" id="incidentDesc" cols="45" rows="5"></textarea></td>
      </tr>
    <tr>
    <td> <input type="reset" name="cancelProcess" id="cancelProcess" value="Reset"></td>
    <td> <input type="submit" name="btnProcessCall" id="btnProcessCall" value="Process Call"></td>
    </tr>
  </table>
</form>
</fieldset>
</body>
</html><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Police Emergency Servvice System</title>
</head>