<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
      padding-top: 50px;
    }

    .form-container {
      max-width: 400px;
      margin: 0 auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .form-container h2 {
      text-align: center;
    }

    /* Hide reason for delay field by default */
    #reason_for_delay_group {
      display: none;
    }

    svg {
      cursor: pointer;
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="form-container">
      <?= $this->Flash->render() ?>
      <?php date_default_timezone_set('Asia/Kolkata');
      $hours = date('G');
      ?>
      <div class="d-flex justify-content-around">
        <h2>Attendence</h2>
        <a href="/attendenceProject/Users/logout"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
          </svg></a>

      </div><br>
      <h5>Name : <?php
                  if (!empty($personalDetailes)) {
                    echo $personalDetailes->full_name;
                  }
                  ?></h5>
      <?php if ((!empty($detailes->login_time)) && ($hours < 12)) { ?>

        <p>Youre submitted Logedin time today</p>
        <p>LogIn Time: <?php echo $detailes->login_time ?></p>
      <?php } elseif ((!empty($detailes->logout_time)) && ($hours < 24)) { ?>
        <P>Youre Submitted logout time today</p>
        <p>LogIn Time: <?php echo $detailes->login_time ?></p>
        <p>LogOut Time: <?php echo $detailes->logout_time ?></p>
      <?php } else { ?>

        <p>Current Date and Time: <span id="currentDateTime"></span></p>
        <form method='post' action='/attendenceProject/HomePage/addingTime'>

          <p> <?php if (!empty($detailes)) {
                echo "Login Time : " . $detailes['login_time'];
              } ?></p>
          <div class="form-group">
            <label for="login_time"><span id="time">Login Time</span></label>
            <input type="text" class="form-control" id="login_time" placeholder="Enter login time" readonly>
          </div>
          <div class="form-group" id="reason_for_delay_group">
            <label for="reason_for_delay">Intimate To</label>
            <select class="form-control" id='leadersId'>
              <option value=''>select one</option>
              <?php
              foreach ($leaders as $obj) {  ?>

                <option value=<?php echo $obj['id']; ?>><?php echo $obj['name'] ?></option>


              <?php }

              ?>

            </select>
          </div>

          <button type="submit" class="btn btn-primary btn-block" id="done">Confirm</button>
        </form>
      <?php } ?>
    </div>
  </div>

  <!-- JavaScript to display current date and time, and set default login time -->
  <script>
    $(document).ready(function() {





      function updateDateTime() {
        var now = new Date();
        var dateTimeString = now.toLocaleString();
        document.getElementById('currentDateTime').textContent = dateTimeString;

        // Set default login time to current time
        document.getElementById('login_time').value = now.toLocaleTimeString([], {
          hour: '2-digit',
          minute: '2-digit'
        });

        // Check if current time is after 9 AM
        var hours = now.getHours();
        // alert(hours)
        if (hours > 12) {
          if (hours < 20) {
            // Show reason for delay field if current time is after 9 AM
            document.getElementById('time').textContent = 'Logout Time';
            $('#login_time').attr('name', 'logout_time');
            $('#leadersId').attr('name', 'logout_intimate');
            document.getElementById('reason_for_delay_group').style.display = 'block';

          } else {
            // Hide reason for delay field if current time is before 9 AM
            document.getElementById('time').textContent = 'Logout Time';
            $('#login_time').attr('name', 'logout_time');
            $('#leadersId').attr('name', 'logout_intimate');
            document.getElementById('reason_for_delay_group').style.display = 'none';
          }
        } else {
          if (hours > 9.10) {
            // Show reason for delay field if current time is after 9 AM
            document.getElementById('time').textContent = 'LogIn Time';
            $('#login_time').attr('name', 'login_time');
            $('#leadersId').attr('name', 'login_intimate');
            document.getElementById('reason_for_delay_group').style.display = 'block';
          } else {
            // Hide reason for delay field if current time is before 9 AM
            $('#login_time').attr('name', 'login_time');
            $('#leadersId').attr('name', 'login_intimate');
            document.getElementById('reason_for_delay_group').style.display = 'none';
          }
        }
      }
      // Update date and time initially and every second
      updateDateTime();
      setInterval(updateDateTime, 1000);

    })
  </script>
  <script>
    // Function to get the user's location
    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    }

    // Function to handle successful retrieval of location
    function showPosition(position) {
      var latitude = position.coords.latitude;
      var longitude = position.coords.longitude;

      // Attach click event handler to the element with ID #done
      //     $('#done').click(function() {
      //       if (latitude >= 17.44 && latitude <= 17.45 && longitude >= 78.39 && longitude <= 78.40) {
      //         // Location matched, proceed with your logic
      //         console.log("Latitude: " + latitude + ", Longitude: " + longitude);
      //       } else {
      //         // Location not matched, inform the user
      //         alert('Please Try In Office Premises Only!');
      //         return false;
      //       }
      //     });
      //   }

      $('#done').click(function() {
        if (latitude >= 17.44 && latitude <= 17.46 && longitude >= 78.36 && longitude <= 78.38) {
          // Location matched, proceed with your logic
          console.log("Latitude: " + latitude + ", Longitude: " + longitude);
        } else {
          // Location not matched, inform the user
          alert('Please Try In Office Premises Only!');
          return false;
        }
      });

    }

    // Function to handle errors in geolocation retrieval
    function showError(error) {
      switch (error.code) {
        case error.PERMISSION_DENIED:
          alert("User denied the request for geolocation.");
          break;
        case error.POSITION_UNAVAILABLE:
          alert("Location information is unavailable.");
          break;
        case error.TIMEOUT:
          alert("The request to get user location timed out.");
          break;
        case error.UNKNOWN_ERROR:
          alert("An unknown error occurred.");
          break;
      }
    }

    // Automatically get location when the page loads
    window.onload = function() {
      getLocation();
    };
  </script>


</body>

</html>