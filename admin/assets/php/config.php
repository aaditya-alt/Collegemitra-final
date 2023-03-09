<?php
session_start();
try {
    $conn = new PDO("mysql:host=localhost;dbname=db_collegemitra", "collegemitra", "Collegemitra@collegemitra");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['action']) && $_POST['action'] == 'admin_login'){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hpassword = sha1($password);

    $query = "SELECT * FROM free_admin WHERE email=:email AND password=:hpassword";
    $stmt = $conn->prepare($query);
    $stmt->execute(['email'=>$email, 'hpassword'=>$hpassword]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
   if($data != null){
            echo 'login';
            $_SESSION['email'] = $email;
        }
        else{
            echo 'username or password is incorrect!';
        }
    
}

//college-list-request
if(isset($_POST['action']) && $_POST['action'] == 'college_list_request'){

    $query = "SELECT * FROM free_pdf";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $output ='';
    if($data){
        $output .= '<div class="table-responsive" id="college-list-request">
                    <table class="table table-striped text-center" id="myTable">
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
                    <tbody>';
                    foreach($data as $row){
                        if($row['sent'] == 0){
                            $status = '<span class="status pending">Pending</span>';
                        }
                        else{
                            $status = '<span class="status completed">Completed</span>';
                        }

                        $output .= '<tr>
                        <td>'.$row['id'].'</td>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['percentile'].'</td>
                        <td>'.$row['state'].'</td>
                        <td>'.$row['category'].'</td>
                        <td>'.$row['request_at'].'</td>
                        <td>'.$status.'</td>
                        <td>
                           <a href="#" id=" '.$row['id'].' " title="View Details" class="text-primary detailsBtn" data-toggle="modal" data-target="#sendCollegeList"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;
                        </td>
                        </tr>';
                    }

                    $output .= '</tbody>
                    </table></div>';

                    echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:(No any user registered yet!)</h3>';
    }
}

if(isset($_POST['list_id'])){
    $id = $_POST['list_id'];

    $query = "SELECT * FROM free_pdf WHERE id=:id";
    $stmt = $conn->prepare($query);
    $stmt->execute(['id'=>$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);
 }

//college-list-request
if(isset($_POST['action']) && $_POST['action'] == 'call_request'){

    $query = "SELECT * FROM free_call";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $output ='';
    if($data){
        $output .= '<div class="table-responsive" id="call-request">
                    <table class="table table-striped text-center">
                    <thead>
                    <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Percentile</th>
                    <th>State</th>
                    <th>Category</th>
                    <th>Contact No.</th>
                    <th>Request At</th>
                    <th>Status</th>
                    <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>';
                    foreach($data as $row){
                        if($row['done'] == 0){
                            $status = '<span class="status pending">Pending</span>';
                        }
                        else{
                            $status = '<span class="status completed">Completed</span>';
                        }

                        $output .= '<tr>
                        <td>'.$row['id'].'</td>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['percentile'].'</td>
                        <td>'.$row['state'].'</td>
                        <td>'.$row['category'].'</td>
                        <td>'.$row['phone'].'</td>
                        <td>'.$row['request_at'].'</td>
                        <td>'.$status.'</td>
                        <td>
                           <a href="#" id=" '.$row['id'].' " title="View Details" class="text-primary detailsBtn" data-toggle="modal" data-target="#sendCollegeList"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;
                        </td>
                        </tr>';
                    }

                    $output .= '</tbody>
                    </table></div>';

                    echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:(No any user registered yet!)</h3>';
    }
}




}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}




?>