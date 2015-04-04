<?php include "../includes/header.inc"; ?>

<?php
include_once __DIR__ . '/../includes/user.inc';
include_once __DIR__ . '/../includes/misc.inc';
include_once __DIR__ . '/../includes/weather.inc';
include_once __DIR__ . '/../includes/thermostat.inc';

if (!user_is_authenticated()) {
  redirect('/');
}

$temperature_updated = FALSE;
if (isset($_POST['temperature']) && thermostat_save_temperature($_POST['temperature'])) {
  $temperature = $_POST['temperature'];
  $temperature_updated = TRUE;
}
else {
  $temperature = thermostat_get_temperature();
}

?>

<h2>Please select a temperature</h2>
<hr />

<div class="row">
  <div class="col-md-8">
    <p>
      Instead of temperatures, we use fun images to describe what the temperature
      will be in your house.
    </p>

    <?php if ($temperature_updated): ?>
    <div class="alert alert-success" role="alert">Temperature updated to <?php echo $temperature; ?></div>
    <?php endif; ?>

    <form method="post" action="/admin/thermostat.php">
      <div class="radio">
        <label>
          <input type="radio" name="temperature" value="hot" <?php if ($temperature == 'hot') { echo "checked"; } ?>>
          <img src="/assets/sun.jpg" width="300" alt="Surface of the sun" />
          </label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="temperature" value="cold" <?php if ($temperature == 'cold') { echo "checked"; } ?>>
          <img src="/assets/titanic.jpg" width="300" alt="Leonardo DiCaprio in Titanic" />
          </label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="temperature" value="off" <?php if ($temperature == 'off') { echo "checked"; } ?>>
          <img src="/assets/off.jpg" width="300" alt="Fuck it. Just turn it off." />
        </label>
      </div>
      <input type="submit" class="btn btn-primary" value="Set temperature">
    </form>
    <br />
  </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Current conditions at your location</h3>
      </div>
      <div class="panel-body">
        <ul class="list-group">
          <li class="list-group-item">
            <span class="badge"><?php print weather_get_current_temperature(); ?>&#176;F</span>
            Current temperature
          </li>
          <li class="list-group-item">
            <span class="badge"><?php print weather_get_current_humidity(); ?>%</span>
            Current humidity
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php include "../includes/footer.inc"; ?>
