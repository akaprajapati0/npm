<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $page['title']; ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/colors/blue.css" id="theme" rel="stylesheet">
    
    <style>
        /* Ensure scrolling works */
        #wrapper {
            max-height: 100vh;
            overflow-y: auto;
        }

        .error {
            display: none; 
        }
    </style>
</head>

<body>
    <section id="wrapper" class="login-register login-sidebar">
    <div class="card-body">
            <div id="content" class="content-box" style="width: 70%;">
                <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
                <?php if (isset($page) && !empty($page)) { ?>
                    <h1 align="center"=><?php echo $page['title']; ?></h1>
                    <!--<p><strong>Author:</strong> <?php echo $page['authour']; ?></p>
                    <p><strong>Updated:</strong> <?php echo $page['update_date']; ?></p>-->
                    <div class="content"> <?php echo $page['content']; ?> </div>
                <?php } ?>
            </div>
        </div>
		<div class="login-box card" style="position: fixed; top: 10px;">

            <div class="card-body loginpage">
							<?php if(!empty($this->session->flashdata('feedback'))){ ?>
							<div class="message">
							<strong>Danger! </strong><?php echo $this->session->flashdata('feedback')?>
							</div>
							<?php
							}
							?>                                          
                <form class="form-horizontal form-material" method="post" id="loginform" action="<?php echo base_url('login/Login_Auth'); ?>">
                    <h2 class="text-center">CEPL HRMS System</h2>
                    <a href="<?php echo base_url(); ?>" class="text-center db"><br/><img src="<?php echo base_url(); ?>assets/images/cepl_logo.jpg" width="80" height="70" alt="CEPL HRMS " /></a>
                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input class="form-control" name="email" value="<?php if(isset($_COOKIE['email'])) { echo $_COOKIE['email']; } ?>" type="text" required placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" name="password" value="<?php if(isset($_COOKIE['password'])) { echo $_COOKIE['password']; } ?>" type="password" required placeholder="Password">
                        </div>
                    </div>
                 <div class="form-check">
                     <input type="checkbox" name="remember" class="form-check-input" id="remember-me">
                     <label class="form-check-label" for="remember-me">Remember me plz!</label>
                 </div>                     
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-login btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
					
                </form>
				<div class="text-center">
            <a href="<?php echo base_url('privacy-policy'); ?>">Privacy Policy</a> |
            <a href="<?php echo base_url('terms-and-conditions'); ?>">Terms and Conditions</a>
        </div>
    </section>

    <!-- Scripts -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
   
</body>
</html>
