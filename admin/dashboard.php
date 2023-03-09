<?php
  session_start();
  $name = $_SESSION['email'];
  if(!isset($_SESSION['email'])){
     header('location: index.html');
     exit();
  }

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
	<!-- My CSS -->
	<link rel="stylesheet" href="assets/style.css">

	<title>AdminHub</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">Collegemitra</span>
		</a>
		<ul class="side-menu top">
			<li class="active" id="college">
				<a>
					<i class='bx bxs-dashboard' ></i>
					<span class="text">College List Request</span>
				</a>
			</li>
			<li id="users">
				<a>
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Users</span>
				</a>
			</li>
			<li id="calling">
				<a>
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Calling</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="./index.html" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- Modal -->
<div class="modal fade" id="sendCollegeList">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send College List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form action="#" method="post" id="send-mail-form">
        <input type="text" id="id" name="id" class="form-control form-control-lg" readonly>
		<input type="text" id="email" name="email" class="form-control form-control-lg" readonly>
		<input type="text" id="percentile" name="percentile" class="form-control form-control-lg" readonly>
		<input type="text" id="state" name="state" class="form-control form-control-lg" readonly>
		<input type="text" id="category" name="category" class="form-control form-control-lg" readonly>
		<input type="file" id="pdf" name="pdf" class="form-control form-control-lg">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="send-mail-btn">Send Now</button>
		<p id="mailResponse"></p>
      </div>
</form>
    </div>
  </div>
</div>




	<!-- CONTENT -->
	<section id="content">

		<!-- MAIN -->
		<main id="collegeList">
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">College List Request</a>
						</li>
					</ul>
				</div>
				<a href="#" class="btn-download">
					<span class="text" id="hideSidebar" >Hide Sidebar</span>
				</a>
				<a href="" class="btn-download">
					<span class="text" id="showSidebar" >Show Sidebar</span><br>
				</a>
			</div>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Recent College List Requests</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<div class="table-responsive" id="college-list-request">
					<table class="table table-striped text-center">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Percentile</th>
								<th>State</th>
								<th>Category</th>
								<th>Request At</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><a href="#" title="View Details" class="text-primary detailsBtn" data-toggle="modal" data-target="#sendCollegeList"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;</td>
							</tr>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	<!-- CONTENT -->
	

		<!-- MAIN -->
		<main id="callRequest">
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Call Request</a>
						</li>
					</ul>
				</div>
				<a href="#" class="btn-download">
					<span class="text" id="hideSidebar" >Hide Sidebar</span>
				</a>
				<a href="" class="btn-download">
					<span class="text" id="showSidebar" >Show Sidebar</span><br>
				</a>
			</div>

           <!-- call request -->
			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Recent Call Requests</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<div class="table-responsive" id="call-request">
					<table class="table table-striped text-center">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Percentile</th>
								<th>State</th>
								<th>Category</th>
								<th>Request At</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><a href="#" title="View Details" class="text-primary detailsBtn" data-toggle="modal" data-target="#callDetails"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;</td>
							</tr>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</main>
		<!-- MAIN -->

<!-- registered users -->
<!-- MAIN -->
        <main id="showUsers">
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Registered Users</a>
						</li>
					</ul>
				</div>
				<a href="#" class="btn-download">
					<span class="text" id="hideSidebar" >Hide Sidebar</span>
				</a>
				<a href="" class="btn-download">
					<span class="text" id="showSidebar" >Show Sidebar</span><br>
				</a>
			</div>

           <!-- call request -->
			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Recent Registered Users</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<div class="table-responsive" id="user-registered">
					<table class="table table-striped text-center">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Percentile</th>
								<th>State</th>
								<th>Category</th>
								<th>Request At</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><a href="#" title="View Details" class="text-primary detailsBtn" data-toggle="modal" data-target="#callDetails"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;</td>
							</tr>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</main>
	</section>

	<script src="assets/script.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

<script>
     collegeListRequest();
	 function collegeListRequest(){
		$.ajax({
			url: 'assets/php/config.php',
			method: 'post',
			data: '&action=college_list_request',
			success: function(response){
				$("#college-list-request").html(response);
				$("table").DataTable({

				});
			}
		});
	 }


	 $("body").on("click", ".detailsBtn", function(e){
            e.preventDefault();

            list_id = $(this).attr('id');
            
            $.ajax({
                url: 'assets/php/config.php',
                method: 'post',
                data: {list_id: list_id},
                success: function(response){
                data = JSON.parse(response);
                    
                $("#id").val(data.id);
                $("#email").val(data.email);
                $("#percentile").val(data.percentile);
				$("#state").val(data.state);
				$("#category").val(data.category);
            }
        });
    });

	$("#send-mail-form").submit(function(e){
        $("#send-mail-btn").val("Please Wait...");
		e.preventDefault();
		$.ajax({
			url: 'assets/php/mail.php',
			method: 'post',
			processData: false,
            contentType: false,
            cache: false,
            data: new FormData(this),
			success: function(response){
                 $("#mailResponse").html(response);
				
				// location.reload();
			}
		});
	});

	hiding();
    function hiding(){
		$("#callRequest").hide();
		$("#showUsers").hide();
		$("#collegeList").show();
}

	$("#calling").click(function(){
		$("#callRequest").show();
		$("#collegeList").hide();
		$("#showUsers").hide();
	});

	$("#college").click(function(){
		$("#callRequest").hide();
		$("#showUsers").hide();
		$("#collegeList").show();
	});

	$("#users").click(function(){
		$("#callRequest").hide();
		$("#showUsers").show();
		$("#collegeList").hide();
	});


	//Call request list ajax
	callRequest();
	 function callRequest(){
		$.ajax({
			url: 'assets/php/config.php',
			method: 'post',
			data: '&action=call_request',
			success: function(response){
				$("#call-request").html(response);
				$("table").DataTable({

				});
			}
		});
	 }

	 $("#hideSidebar").click(function(){
		$("#sidebar").hide();
		$("#content").css({"width": "calc(100% - 60px)",
	"left": "60px"});
	 });

	 $("#showSidebar").click(function(){
		$("#sidebar").show();
		$("#content").css({
			"width": "calc(100% - 280px)",
	        "left": "280px"
		});
	 });


	
</script>
</body>
</html>