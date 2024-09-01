<?php

require 'vendor/autoload.php';
include ('api/class/include.php');
if(Account::isAuthentified()){
    header('Location: dashboard.php');
}
?>
<!doctype html>
<html class="h-full">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>GIM - Login</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <link href="assets/demo/demo.css" rel="stylesheet" />
</head>
<body class="">
  <div class="wrapper ">
    <div class="main-panel" style="width: 100%; height: 100%;">
      <div class="content">
        <div class="row">
          <div class="col-md-4 ml-auto mr-auto">
            <div class="card p-3">
              <div class="card-header text-center">
                <h4 class="card-title">Se connecter</h3>
              </div>
              <div class="card-body">
                <div class="">
                  <div class="row">
                    <input id="username" type="text" value="" class="form-control col-10 mr-auto ml-auto mb-3" placeholder="Nom d'utilisateur">
                    <input id="password" type="password" value="" class="form-control col-10 mr-auto ml-auto mb-3" placeholder="Mot de passe">
                    <button type="submit" onclick="login()"
                        class="btn btn-primary mr-auto ml-auto">
                        Se connecter</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <script src="assets/js/plugins/chartjs.min.js"></script>
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
  <script src="assets/demo/demo.js"></script>

</body>
<?php include "api/bottom.php"; ?>
<script src="api/js/login.js?a=A"></script>

</html>