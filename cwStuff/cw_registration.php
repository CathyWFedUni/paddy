<?php
include 'include/registrationFunction.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style/main.css">

</head>
<body>
<?php include "include/nav.php";?>
  <div class="header">
  	<h2>Register an Account with Paddy Club Organiser</h2>
  </div>

  <form method="post" action="registerpage.php.php">
  	<?php include 'errors.php';?>
    <div class="content">

  	<div class="input-group">
  	  <label>*Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
    <p/>
  	<div class="input-group">
  	  <label>*Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
    <p/>
	<div class="input-group">
	<label>*Primary Language</label>
	<select name="nativeLag" >
            <option value="">--- Select ---</option>
			<option value="Japanese">Japanese</option>
			<option value="English">English</option>
	</select>
	</div>
    <p/>
  	<div class="input-group">
  	  <label>*Password</label>
  	  <input type="password" name="password_1">
  	</div>
    <p/>
  	<div class="input-group">
  	  <label>*Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
    <p/>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="loginpage.php">Sign in</a>
  	</p>
  </form>
  </div>

   <?php include "include/footer.php";?>

</body>
</html>