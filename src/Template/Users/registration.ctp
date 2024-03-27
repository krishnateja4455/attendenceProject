<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
  </style>
</head>

<body>
  <div class="container">
    <div class="form-container">
      <?= $this->Flash->render() ?>
      <h2>Registration Form</h2>
      <form method="post">
        <div class="form-group">
          <label for="full_name">Full Name</label>
          <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter your full name" required>
        </div>
        <div class="form-group">
          <label for="employee_id">Employee ID</label>
          <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="Enter your employee ID" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <a href='/attendenceProject/users/login'>Login</a><br><br>
        <button type="submit" class="btn btn-primary btn-block">Register</button>
      </form>
    </div>
  </div>
</body>

</html>