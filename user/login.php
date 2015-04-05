<?php include "../includes/header.inc"; ?>

  <form style="width:300px; margin: 0 auto;" method="post" action="/user/login.php">

  <?php
  if (isset($_POST['username'])) {
    include_once "../classes/user.php";
    include_once "../classes/util.php";
    $user = User::getInstance();

    $valid = $user->attemptLogin($_POST['username'], $_POST['password']);
    if ($valid) {
      Util::redirect("/admin/thermostat.php");
    }
    else {
    ?>
      <div class="alert alert-danger" role="alert">Invalid username or password</div>
    <?php
    }
  }
  ?>

    <h2 class="form-signin-heading">Please sign in</h2>
    <label for="username" class="sr-only">Username</label>
    <input type="text" name="username" class="form-control" placeholder="Username" required="" autofocus="">
    <label for="password" class="sr-only">Password</label>
    <input type="password" name="password" class="form-control" placeholder="Password" required="">
    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Login">
  </form>

<?php include "../includes/footer.inc"; ?>
