<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  
  require("conn.php");
  require("helpers.php");
  
  session_start();
?>
	
<!DOCTYPE html>
<html class="<?php if (isLoggedIn()) { echo 'logged-in'; } ?>">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <title>What'ev Airline</title>
  </head>
	
  <body>
    <div class="logo">
      <span>What'ev Lines</span>
      <img src="img/plane.png" alt="Logo">
    </div>
    <div>
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="home-li active">
          <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a>
        </li>
        <li role="presentation">
          <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a>
        </li>
        <li role="presentation" class="flights-li">
          <a href="#flights" aria-controls="flights" role="tab" data-toggle="tab" class="flights-tab">Flights</a>
        </li>
        <li role="presentation" class="booking-li">
          <a href="#booking" aria-controls="booking" role="tab" data-toggle="" class="booking-tab">Booking</a>
        </li>
        <li role="presentation" class="payment-li">
          <a href="#payment" aria-controls="payment" role="tab" data-toggle="">Payment</a>
        </li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="home">...</div>
        
				<div role="tabpanel" class="tab-pane fade" id="profile">
          <?php
            if (isLoggedIn()) { ?>
          <h4>Welcome, <span><?php echo currentUser()["firstname"]; ?></span></h4>
          <h5>See all your flights here:</h5>
					
					<button class="btn btn-primary btnLogout">Log out</button>
          <?php } else { ?>
          <div class="profile-forms-wrap">
            <div class="signup">
              <h1>Signup</h1>
              <form method="post">
                <input type="hidden" value="register" name="event">
                <div>
                  <i class="fa fa-user"></i><input type="text" name="firstname" id="firstname" placeholder="First name..">
                  <br>
                  </i><input type="text" name="lastname" id="lastname" placeholder="Last name..">
                </div>
                <div>
                  <i class="fa fa-envelope"></i><input type="email" name="email" id="email" placeholder="Email..">
                </div>
                <div>
                  <i class="fa fa-lock"></i><input type="password" name="password" id="password" placeholder="Password..">
                </div>
                <div>
                  <i class="fa fa-phone"></i><input type="text" name="phone" id="phone" placeholder="Phone..">
                </div>
                <div>
                  <i class="fa fa-venus-mars"></i>
                  <input type="radio" value="male" id="male" name="gender" checked>
                  <label for="male">Male</label>
                  <br>
                  <input type="radio" value="female" id="female" name="gender">
                  <label for="female">Female</label>
                </div>
                <div>
                  <i class="fa fa-birthday-cake"></i><input type="date" name="birthday" id="birthday">
                </div>
                <button id="btnSignup" type="submit" class="btn btn-primary btn-block">Sign me up</button>
              </form>
            </div>
            <div class="login">
							<form>
							  <h1>Login</h1>
								<input type="hidden" name="event" value="login">
							  <div>
							    <i class="fa fa-envelope"></i><input type="email" name="email" id="email" placeholder="Email..">
							  </div>
							  <div>
							    <i class="fa fa-lock"></i><input type="password" name="password" id="password" placeholder="Password..">
							  </div>
							  <button id="btnLogin" type="submit" class="btn btn-primary btn-block">Let me in</button>
							  <a>Forgot password?</a>
							</form>
            </div>
          </div>
          <?php } ?>
        </div>
        
				<div role="tabpanel" class="tab-pane fade" id="flights">
          <!-- <h2>Flights</h2> -->
          <h4>Narrow down your search:</h4>
          <input type="text" name="from" id="from" placeholder="From..">
          <input type="text" name="to" id="to" placeholder="To..">
          <input type="datetime" name="departure" id="departure" placeholder="Departure..">
          <input type="text" name="price" id="price" placeholder="Max. price..">
          <input type="submit" value="Submit" >
          <div class="flights-display">
            <?php
              $result = $db->query("SELECT * FROM flights");
              $flights = $result->fetchAll(PDO::FETCH_ASSOC);
              
              for ($i = 0; $i < count($flights); $i++) { 
              	$departure = $flights[$i]["departure_time"];
              	$arrival = $flights[$i]["arrival_time"];
              ?>
            <div class="flight" data-id="<?php echo $flights[$i]["id"]; ?>">
              <i class="fa fa-globe"></i>
              <div class="flight-nr"><i class="fa fa-plane"></i> <?php echo $flights[$i]["flight_number"]; ?></div>
              <button class="btn btn-primary btnPick">BUY</button>
              <select class="form-control" name="tickets">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
              </select>
              <div class="places-wrap">
                <span><?php echo $flights[$i]["flight_from"]; ?></span>
                <span>&rarr;</span>
                <span><?php echo $flights[$i]["flight_to"]; ?></span>
              </div>
              <div class="times-wrap">
                <span><?php echo date('h:i', strtotime($departure)); ?></span>
                - <span><?php echo date('h:i', strtotime($arrival)); ?></span><br>
                <span><?php echo date('d/m/Y', strtotime($arrival)); ?></span>
              </div>
              <div class="price"><?php echo $flights[$i]["price"]; ?>kr</div>
            </div>
            <?php } ?>
          </div>
        </div>
        
				<div role="tabpanel" class="tab-pane fade" id="booking">
          <div class="row">
            <button id="btnBuy" class="btn btn-primary">To payment</button>
            <div class="passengers col-md-4">
              <i class="fa fa-users"></i>
              <h4>Travellers</h4>
            </div>
          </div>
        </div>
				
        <div role="tabpanel" class="tab-pane fade" id="payment">
          <form class="credit-card-form form-horizontal" role="form">
            <h4>Please enter your credit card information<span>*</span></h4>
            <!-- <fieldset> -->
            <!-- <legend>Payment</legend> -->
            <div class="form-group">
              <label class="col-sm-3 control-label" for="card-holder-name">Name on Card</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="card-holder-name" id="card-holder-name" placeholder="Card Holder's Name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="card-number">Card Number</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="card-number" id="card-number" placeholder="Debit/Credit Card Number">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="expiry-month">Expiration Date</label>
              <div class="col-sm-9">
                <div class="row">
                  <div class="col-xs-3">
                    <select class="form-control col-sm-2" name="expiry-month" id="expiry-month">
                      <option>Month</option>
                      <option value="01">01</option>
                      <option value="02">02</option>
                      <option value="03">03</option>
                      <option value="04">04</option>
                      <option value="05">05</option>
                      <option value="06">06</option>
                      <option value="07">07</option>
                      <option value="08">08</option>
                      <option value="09">09</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                    </select>
                  </div>
                  <div class="col-xs-3">
                    <select class="form-control" name="expiry-year">
                      <option>Year</option>
                      <option value="13">2013</option>
                      <option value="14">2014</option>
                      <option value="15">2015</option>
                      <option value="16">2016</option>
                      <option value="17">2017</option>
                      <option value="18">2018</option>
                      <option value="19">2019</option>
                      <option value="20">2020</option>
                      <option value="21">2021</option>
                      <option value="22">2022</option>
                      <option value="23">2023</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="cvv">Card CVV</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" name="cvv" id="cvv" placeholder="CVV">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9">
                <button type="button" class="btn btn-primary btnPay">Pay Now</button>
              </div>
            </div>
            <!-- </fieldset> -->
          </form>
          <small>* This is just fake and will of course not be saved.</small>
          <p class=""></p>
        </div>
      </div>
    </div>
    <footer>XML &amp; Databases | Mandatory 2</footer>
		<?php echo $_SESSION["user_id"]; ?>
		
    <!-- // <script src="js/maxibear.js"></script> -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/moment.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>