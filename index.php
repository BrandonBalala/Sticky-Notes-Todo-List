<!DOCTYPE html>
<html lang="en">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sticky Note Project</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  <!-- jQuery UI --> 
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	  <script type="text/javascript" src="script.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
  </head>

  <body>
    <?php
      session_start();
      session_regenerate_id();
    ?>

    <nav class="navbar navbar-default">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
    		<a class="navbar-brand" href="#">Sticky Notes</a>
    		

        <?php
          if(isset($_SESSION['userId'])){
            echo "<button type=\"button\" class=\"btn btn-default navbar-btn\" data-toggle=\"modal\" data-target=\"#createStickyNoteModal\">Create Note</button>";
          }
        ?>
			<!-- Form for when creating a sticky note -->
    		<div class="modal fade" id="createStickyNoteModal" tabindex="-1" role="dialog" aria-hidden="true">
    		  <div class="modal-dialog">
      			<div class="modal-content">
                 <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h1 class="text-center">Create a Note</h1>
              </div>

      			  <div class="modal-body">
        				<form>
        				  <div class="form-group">
        					 <textarea class="form-control input-lg" id="noteTextArea" placeholder="Write anything you want..."></textarea>
        				  </div>
        				</form>

                <h5 id="errorMsgCreate" class="errMsg text-danger text-right"></h5>
      			  </div>
      			  <div class="modal-footer">
      				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      				  <button type="button" id="submitButton" class="btn btn-primary">Create</button>
      			  </div>
      			</div>
    		  </div>
    		</div>
      </div>

      <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <?php
                if(isset($_SESSION['userId'])){
                  echo "<li><a id=\"logoutAnchor\">Logout</a></li>";
                }
                else{
                  echo "<li><a data-toggle=\"modal\" data-target=\"#registerModal\">Register</a></li>";
                  echo "<li><a data-toggle=\"modal\" data-target=\"#loginModal\">Login</a></li>";
                }
              ?>
            </ul>
          </li>
      </ul>
      </div>
    </div>
	
	<!-- Form for login -->
    <div id="loginModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h1 class="text-center">Login</h1>
            </div>
            <div class="modal-body">
              <form class="center-block">
                <div class="form-group">
                  <input type="text" id="loginUsername" class="form-control input-lg" placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="password" id="loginPassword" class="form-control input-lg" placeholder="Password">
                </div>
                <h5 id="errorMsgLogin" class="errMsg text-danger text-right"></h5>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" id="loginButton" class="btn btn-primary">Login</button>
            </div>
          </div>
        </div>
      </div>
    </div>
	
	<!-- Form for register -->
    <div id="registerModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >×</button>
            <h1 class="text-center">Register</h1>
          </div>
          <div class="modal-body">
            <form class="center-block">
              <div class="form-group">
                <input type="text" id="registerUsername" class="form-control input-lg" placeholder="Username">
              </div>
              <div class="form-group">
                <input type="password" id="registerPassword" class="form-control input-lg" placeholder="Password">
              </div>
              <div class="form-group">
                <input type="password" id="registerPassword2" class="form-control input-lg" placeholder="Confirm Password">
              </div>
              <h5 id="errorMsgRegister" class="errMsg text-danger text-right"></h5>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" id="registerButton" class="btn btn-primary">Register</button> 
          </div>
        </div>
      </div>
    </div>
  </nav>
      <?php
        if(isset($_SESSION['username']))
          $welcomeMsg = "Hello, ".$_SESSION['username']."!";
        else
          $welcomeMsg = "Hello, anonymous person! Login to start creating notes. ";
        
        echo "<h2 class=\"container\">$welcomeMsg</h2>";
      ?>
  		
      <div id="stickyNoteArea"></div>


  		<div class="navbar navbar-default navbar-fixed-bottom">
      <div class="container">
        <p class="navbar-text">©2015 Brandon Balala</p>
      </div>
      
      
    </div>
  		
  		
  </body>
</html>