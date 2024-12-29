<?php
$title = "User SignIn";
require_once "./template/header.php";

?>

<form class="form-horizontal" method="post" action="user_verify.php">
  <div class="form-group">
    <label for="exampleInputEmail1">Username</label>
    <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter username" name="username">

  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" placeholder="Password" name="password">
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php
if (isset($_GET['error']) && $_GET['error'] == 'invalid_credentials') {
  echo "<script>alert('Invalid credentials. Please try again.');</script>";
}
elseif(isset($_GET['error']) && $_GET['error'] == 'empty'){
  echo "<script>alert('You did not fill in all the fields.');</script>";
}
require_once "./template/footer.php";
?>