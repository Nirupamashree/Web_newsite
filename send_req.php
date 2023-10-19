<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="register.css">
  </head>
  <body>
    <div class="wrapper">
      <div class="title">
        SEND REQUEST FORM
      </div>
      <div class="form" action="success1.html" method="POST">
      <div class="inputfield">
          <label>Venue</label>
          <div class="select">
            <select name="dob_day">
              <option value="">Day</option>
              <?php
                for ($i = 1; $i <= 31; $i++) {
                  echo "<option value=\"$i\">$i</option>";
                }
              ?>
            </select>
          </div>
          <div class="select">
            <select name="dob_month">
              <option value="">Month</option>
              <?php
                $months = array(
                  "January", "February", "March", "April", "May", "June",
                  "July", "August", "September", "October", "November", "December"
                );
                foreach ($months as $key => $month) {
                  echo "<option value=\"" . ($key + 1) . "\">$month</option>";
                }
              ?>
            </select>
          </div>
          <div class="select">
            <select name="dob_year">
              <option value="">Year</option>
              <?php
                $current_year = date("Y");
                for ($i = $current_year - 100; $i <= $current_year; $i++) {
                  echo "<option value=\"$i\">$i</option>";
                }
              ?>
            </select>
          </div>
        </div>
        <div class="inputfield">
          <label>Faculty Name</label>
          <input type="text" class="input" name="f_name">
        </div>  
        <div class="inputfield">
          <label>Subject</label>
          <input type="text" class="input" name="subject">
        </div>  
         
        <form action="sucess1.html">
          <input type="submit" value="Send Request" class="btn">
        </form>
      </div>
    </div>
  </body>
</html>
