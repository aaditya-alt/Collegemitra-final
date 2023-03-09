<?php
    require_once './assets/php/header.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Welcome</title>
	<!-- Link Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" />
    <!-- Fontawesome CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
	<style>
		/* Box sizing */
		* {
			box-sizing: border-box;
		}
    body{
        background-color: #efefef;
      }
		/* Colors */
		.primary-color {
			color: #007bff;
		}
		.secondary-color {
			color: #6c757d;
		}
		.success-color {
			color: #28a745;
		}
		.warning-color {
			color: #ffc107;
		}
		.danger-color {
			color: #dc3545;
		}
		.highlight {
			color: #007bff;
			font-weight: bold;
		}
		/* Spacing */
		.mb-4 {
			margin-bottom: 1.5rem;
		}
		/* Font sizes */
		h1, h2, h3, h4, h5, h6 {
			font-weight: 700;
		}
		.text-lg {
			font-size: 1.5rem;
		}
		/* Jumbotron */
		.jumbotron {
			background-color: #007bff;
			color: #fff;
			padding: 2rem;
			margin-bottom: 0;
		}
		.jumbotron h1 {
			font-size: 3rem;
			margin-bottom: 1.5rem;
		}
		/* Mentor details */
		.card {
			margin-bottom: 1.5rem;
		}
		.card-header {
			background-color: #f8f9fa;
			border-bottom: none;
			padding: 1.25rem 1.5rem;
			font-weight: bold;
			font-size: 1.25rem;
		}
		.card-body {
			padding: 1.5rem;
		}
		/* Action buttons */
		.btn-primary {
			background-color: #007bff;
			border-color: #007bff;
		}
		.btn-primary:hover {
			background-color: #0069d9;
			border-color: #0062cc;
		}
		.btn-block {
			margin-bottom: 1rem;
		}
		@media (max-width: 576px) {
			h1 {
				font-size: 2.5rem;
			}
			h2 {
				font-size: 2rem;
			}
			.text-lg {
				font-size: 1.25rem;
			}
			.card-header {
				font-size: 1rem;
			}
		}
	</style>
</head>
<body>
	<!-- Jumbotron -->
	<div class="jumbotron" style="border-radius: 0%;">
		<div class="container">
			<h1 class="display-4">Welcome, <?= $fname; ?>!&nbsp;</h1>
			<p class="lead">We're here to help you get into the college of your dreams.</p>
		</div>
	</div>

	<!-- Service info -->
	<div class="container" style="margin-top: 20px;">
		<div class="row">
			<div class="col-md-6 mb-4">
				<h2 class="primary-color">Your Service Info</h2>
				<p class="text-lg">
                    <ul>
                        <li>We provide college admission assistance based on your JEE Mains score.</li>
                        <li>Our team of experts will guide you through the entire process.</li>
                        <li>We offer personalized services tailored to your needs.</li>
                        <li>We have a proven track record of success.</li>
                    </ul>
                </div>
                <!-- Mentor details -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            Your Mentor
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">John Doe</h5>
                            <p class="card-text">John has over 10 years of experience in college admissions counseling. He has helped hundreds of students achieve their dreams of attending top universities.</p>
                            <p class="card-text">Contact John at <a href="tel:+1234567890">+1 (234) 567-890</a> or <a href="mailto:john.doe@example.com">john.doe@example.com</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

	 <!--Show Choice Filling Modal-->
	 <!--Show Choice Filling Modal-->
<div class="modal fade" id="showChoiceFillingModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="getName"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-7">
            <div class="card border-primary">
              <div class="card-body">
                <p id="getSent"></p>
                <p id="getCounselling"></p>
                <p id="getCreated"></p>
                <p id="getMessage"></p>
                <p id="getRank"></p>
              </div>
            </div>
          </div>
          <div class="col-md-5 align-self-center">
            <div id="getPdf"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

        <!-- Action buttons -->
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                <?php if($premium=='Subscribed!'):?>
                    <button class="btn btn-primary btn-block mb-4" id="choice-filling-link">Request Choice Filling</button>
					          <button id="hide-btn" class="btn btn-secondary" style="display: none;">Hide</button>
                </div>
            <!-- Request Choice filling Form -->
				<div class="wrapper" id="choice-filling-box" style="display: none;">
               <form action="#" method="post" class="px-3" id="choice-filling-form">

                        <?php

                          $counsellingHosts = array('HSTES', 'UPTU', 'MPDTE', 'REAP', 'UGEAC', 'JOSAA', 'OJEE');
                          
                          // Assume that $array is the array that you want to check
                          $array = $all_counselling;
                          
                          // Output the HTML code for the <select> element
                          echo '<select name="counselling" id="counselling"class="form-control">
                                <option value="Counselling" selected disabled>Select Counselling</option>';
                          
                          
                          foreach ($counsellingHosts as $host) {
                              $optionText = ucfirst($host);
                              $optionValue = $host;
                              $optionDisabledAttr = !in_array($host, $array) ? 'disabled' : 'style="color:green; font-weight:bold;"';
                              echo "<option value=\"$optionValue\" $optionDisabledAttr>$optionText</option>";
                          }

                          echo '</select>';
                          ?>

                    <textarea form="choice-filling-form" type="text" id="description" name="description" class="form-control rounded-2" placeholder="Any Suggestions..." required></textarea>


                    <input type="submit" id="choice-filling-btn" value="Submit" class="btn btn-primary btn-lg btn-block myBtn"/>

               </form>
               </div>
               <?php else: ?>
                
                <?php endif; ?>

                <!-- End choice filling request -->

                <div class="col-md-4">
                <?php if($premium=='Subscribed!'):?>
                    <button class="btn btn-danger btn-block mb-4" id="calling-link">Request a Call</button>
					          <button id="calling-hide-btn" class="btn btn-secondary" style="display: none;">Hide</button>
                </div>

				<!--calling facility -->
				<div class="wrapper" id="calling-options-box" style="display: none;">
                 <form action="#" method="post" id="calling-options-form" class="px-3">
                 <?php
                        
                        $counsellingHosts = array('HSTES', 'UPTU', 'MPDTE', 'REAP', 'UGEAC', 'JOSAA', 'OJEE');
                        
                        // Assume that $array is the array that you want to check
                        $array = $all_counselling;
                        
                        // Output the HTML code for the <select> element
                        echo '<select name="calling-options" id="calling-options"class="form-control">
                              <option value="Counselling" selected disabled>Select Counselling</option>';
                        
                        
                        foreach ($counsellingHosts as $host) {
                            $optionText = ucfirst($host);
                            $optionValue = $host;
                            $optionDisabledAttr = !in_array($host, $array) ? 'disabled' : 'style="color:green; font-weight:bold;"';
                            echo "<option value=\"$optionValue\" $optionDisabledAttr>$optionText</option>";
                        }
                        
                        echo '</select>';
                        ?>
                        <input type="submit" id="calling-options-btn" value="Submit" class="form-control btn btn-primary btn-lg btn-block myBtn" />
              
              </form></div>
              <?php else: ?>
                
                <?php endif; ?>

                <!-- End calling request -->

                <div class="col-md-4">
                <?php if($premium=='Subscribed!'):?>
                    <button href="#" class="btn btn-success btn-block mb-4" id="getChoiceFilling" data-toggle="modal" data-target="#showChoiceFillingModal">Get Choice Filling</button>
                  <?php else: ?>
                
                <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Additional info -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="secondary-color mb-4">Additional Info</h2>
                    <p>Need help? Contact our customer support team at <a href="tel:+1234567890">+1 (234) 567-890</a> or <a href="mailto:info@example.com">info@example.com</a>.</p>
                    <p class="mb-0">We value your feedback. If you have any comments or suggestions, please email us at <a href="mailto:feedback@example.com">feedback@example.com</a>.</p>
                </div>
            </div>
        </div><br><br>
        
        <!-- Link Bootstrap JS -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
    <script type="text/javascript" src="./assets/js/script.js"></script>
	
  <script>
    $("#choice-filling-link").click(function(){
     $("#choice-filling-box").show();
     $("#hide-btn").show();
    });

    $("#hide-btn").click(function(){
        $("#choice-filling-box").hide();
        $("#hide-btn").hide();
    });

    $("#calling-link").click(function(){
      $("#calling-options-box").show();
      $("#calling-hide-btn").show();
    });

    $("#calling-hide-btn").click(function(){
      $("#calling-options-box").hide();
      $("#calling-hide-btn").hide();
    });

    $("table").DataTable();

    //Updating status of chat
    window.addEventListener('load', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'assets/php/process.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
            data=xhr.response;
            console.log(data);
        }
    }
  }
    xhr.send('status=Offline now');
});

    

    // choice filling ajax request
    $("#choice-filling-form").submit(function(e){
      e.preventDefault();
      $("#choice-filling-btn").val('Please Wait...');

      $.ajax({
        url: 'assets/php/process.php',
        method: 'post',
        data: $("#choice-filling-form").serialize()+'&action=choice_filling_request',
        success: function(response){
          $("#choice-filling-form")[0].reset();
                    $("#choice-filling-btn").val('Submit');
                     Swal.fire({
                        title: 'Choice Filling Request Successfully sent to the Mentor!',
                        type: 'success'
                     });
        }
      });
    });
    

  //calling form ajax request
    $("#calling-options-form").submit(function(e){
      e.preventDefault();
      $("#calling-options-btn").val('Please Wait...');

      $.ajax({
        url: 'assets/php/process.php',
        method: 'post',
        data: $("#calling-options-form").serialize()+'&action=request_call',
        success: function(response){
                    $("#calling-options-form")[0].reset();
                    $("#calling-options-btn").val('Submit');
                     Swal.fire({
                        title: 'Calling Request Successfully sent to the Mentor!',
                        type: 'success'
                     });

        }
      });
    });
     //Check notification
     checkNotification();
        function checkNotification(){
          $.ajax({
            url: 'assets/php/process.php',
            method: 'post',
            data: {action: 'checkNotification'},
            success: function(response){
              $("#checkNotification").html(response);
            }
          });
        }

    //Get choice filling ajax request
    $("#getChoiceFilling").click(function(e){

      e.preventDefault();

      $.ajax({
        url: 'assets/php/process.php',
        method: 'post',
        data: {action : 'getChoiceFilling'},
        success: function(response){
          if(response != 'false'){
                    data = JSON.parse(response);
                    console.log(data);
                    $("#getName").text(data.name+' '+ '(ID: '+data.id+')');
                    $("#getSent").text('Recieved On : '+data.sent_at);
                    $("#getRank").text('Rank : '+data.rank);
                    $("#getCounselling").text('Counselling : '+data.counselling);
                    $("#getMessage").text('Instruction : '+data.message);
                    $("#getCreated").text('Requested at : '+data.created_at);

                    if(data.pdf != ''){
                        $("#getPdf").html('<iframe src="../user-system/mentor/assets/php/'+data.pdf+'" width="200" height="300">');
                    }
                    else{
                        $("#getPdf").html('<img src="../assets/php/photo/dummy-image.jpg'+data.pdf+'"class="img-thumbnail img-fluid align-self-center width="280px">');
                    }
                  }
                  else {
                    $("#getMessage").text("Either You Haven't Requested a Choice Filling Or Your Mentor Has not Sent You Yet!");
                  }
                }
      });

    });
  </script>
</body>
</html>        
