<?php

  require_once 'session.php';

  //profile update ajax request
    if(isset($_FILES['image'])){
        $jee_rank = $cuser->test_input($_POST['jee_rank']);
        $gender = $cuser->test_input($_POST['gender']);
        $phone = $cuser->test_input($_POST['phone']);
        $state = $cuser->test_input($_POST['state']);
        $category = $cuser->test_input($_POST['category']);

        $oldImage = $_POST['oldimage'];
        $folder = 'uploads/';

        if(isset($_FILES['image']['name'])&&($_FILES['image']['name'] != "")){
            $newImage = $folder.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $newImage);

            if($oldImage != null){
                unlink($oldImage);
            }
        }
        else{
            $newImage = $oldImage;
        }
        $cuser->update_profile($jee_rank, $phone, $gender, $newImage, $category, $state, $cid);
        $cuser->notification($cid, 'admin', 'Profile Updated', $counselling);

        // Return a success message
        echo json_encode(array('message' => 'The form was submitted successfully'));
    }

    //handle ajax request for change password
    if(isset($_POST['action'])&& $_POST['action'] == 'change_pass'){
        $currentPass = $_POST['curpass'];
        $newPass = $_POST['newpass'];
        $cnewPass = $_POST['cnewpass'];

        $hnewPass = password_hash($newPass, PASSWORD_DEFAULT);

        if($newPass != $cnewPass){
            echo $cuser->showMessage('danger', 'Password did not matched!');
        }
        else{
            if(password_verify($currentPass, $cpass)){
                $cuser->change_password($hnewPass, $cid);
                $cuser->notification($cid, 'admin', 'Password changed!', $counselling);
                echo $cuser->showMessage('success', 'Password Changed Successfully!');
            }
            else{
                echo $cuser->showMessage('danger', 'Current Password is Wrong!');
            }
        }
    }

    //Handle send feedback to mentor ajax request
    if(isset($_POST['action']) && $_POST['action']=='feedback'){
        $subject = $cuser->test_input($_POST['subject']);
        $feedback = $cuser->test_input($_POST['feedback']);

        $cuser->send_feedback($subject, $feedback, $cid, $counselling);
        $cuser->notification($cid, 'admin', 'Feedback Written', $counselling);
    }
 
    //handle ajax request for choice filling
    if(isset($_POST['action']) && $_POST['action']=='choice_filling_request'){
        $counselling = $cuser->test_input($_POST['counselling']);
        $description = $cuser->test_input($_POST['description']);

        $row = $cuser->check_choice_filling($cid);
        if($row){
            $cuser->delete_choice_filling($cid);
            $cuser->choice_filling($cname,$cjee_rank,$cgender,$counselling,$category,$cid, $description, $cstate);
        }
        else{
            $cuser->choice_filling($cname,$cjee_rank,$cgender,$counselling,$category,$cid, $description, $cstate);
        }
        $cuser->notification($cid, 'admin', 'Choice Filling Request', $counselling);
    }

    //handle ajax request for calling
    if(isset($_POST['action'])&&$_POST['action']=='request_call'){
        $counselling = $cuser->test_input($_POST['calling-options']);
        

        $cuser->calling($cid, $cname, $cphone, $cjee_rank, $category, $cmentor_name, $counselling);
        $cuser->notification($cid, 'admin', 'Call Request', $counselling);
    }


//Handle ajax request for displaying all the updates
if(isset($_POST['action'])&& $_POST['action']=='fetchAllUpdates'){
    $output='';
    $data = $cuser->fetchAllUpdates();
    $path = 'assets/php/uploads/updates/';
    if($data){
        $output .= '<div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Title</th>
              <th scope="col">Updates</th>
              <th scope="col">PDF</th>
              <th scope="col">Counselling</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>';
            foreach ($data as $row) {
                if ($row['pdf'] == 'uploads/') {
                    $updf = 'mentor/assets/php/photo/dummy-image.jpeg';
                } else {
                    $updf = $path.$row['pdf'];
                }
                
            $output .= '<tr>
              <th scope="row">'.$row['id'].'</th>
              <td>'.$row['title'].'</td>
              <td>'.substr($row['update'],0, 75).'</td>
              <td>
                <a href="'.$updf.'" target="_blank">
                  <i class="far fa-file-pdf fa-lg text-danger"></i>
                </a>
              </td>
              <td>'.$row['counselling'].'</td>
              <td>
                <a href="#" id="'.$row['id'].'" title="View Details" class="text-success infoBtn">
                  <i class="fas fa-info-circle fa-lg"></i>
                </a>
              </td>
            </tr>
            ';
                    }

                    $output .= '</tbody>
                    </table></div>';

                    echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:(No any user registered yet!)</h3>';
    }
    
}

//Fetch updates in detail ajax request
if(isset($_POST['info_id'])){
    $id = $_POST['info_id'];

    $row = $cuser->fetch_updates_detail($id);

    echo json_encode($row);

 }

//Handle fetch notification
if(isset($_POST['action'])&& $_POST['action']=='fetchNotification'){
    $notification = $cuser->fetchNotification($cid);
    $output = '';
    if($notification){
        foreach($notification as $row){
            $output .= '<div class="alert alert-danger" role="alert">
            <button class="close" id="'.$row['id'].'" type="button" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="alert-heading">New Notification</h4>
            <p class="mb-0 lead">'.$row['message'].'</p>
            <hr class="my-2">
            <p class="mb-0 float-left">Reply of Feedback from admin</p>
            <p class="mb-0 float-right">'.$cuser->timeInAgo($row['created_at']).'</p>
            <div class="clearfix"></div>
          </div>';
        }
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary mt-5">No any new notification</h3>';
    }
}

//Check notification
if(isset($_POST['action'])&& $_POST['action']== 'checkNotification'){
    if($cuser->fetchNotification($cid)){
        echo '<i class="fas fa-circle fa-sm text-danger"></i>';
    }
    else{
        echo '';
    }
}

//Remove notification
if(isset($_POST['notification_id'])){
    $id = $_POST['notification_id'];
    $cuser->removeNotification($id);
}

//Get Choice filling sent by admin
if(isset($_POST['action'])&& $_POST['action']== 'getChoiceFilling'){
    $id = $cid;

    $data = $cuser->get_choice_filling($id);
    
   
    echo json_encode($data);
}


//Handle ajax for users list showing of chat
if(isset($_POST['action']) && $_POST['action'] == 'chat_users'){
    $counselling_selected = $_POST['selectedValue'];
    $counselling = '%'.$counselling_selected.'%';
    $sql = "SELECT * FROM users WHERE counselling LIKE :counselling AND NOT unique_id=:unique_id";
    $query = $cuser->conn->prepare($sql);
    $query->bindParam(':counselling', $counselling);
    $query->bindParam(':unique_id', $_SESSION['unique_id']);
    $query->execute();
    $output = "";
    if($query->rowCount() == 0){
        $output .= "No users are available to chat";
    }elseif($query->rowCount() > 0){
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = :unique_id OR outgoing_msg_id = :unique_id) 
                    AND (outgoing_msg_id = :outgoing_id OR incoming_msg_id = :incoming_id) 
                    ORDER BY msg_id DESC LIMIT 1";
            $query2 = $cuser->conn->prepare($sql2);
            $query2->bindParam(':unique_id', $row['unique_id']);
            $query2->bindParam(':outgoing_id', $_SESSION['unique_id']);
            $query2->bindParam(':incoming_id', $_SESSION['unique_id']);
            $query2->execute();
            $row2 = $query2->fetch(PDO::FETCH_ASSOC);
        
            $rowCount = $query2->rowCount();
            ($rowCount > 0) ? $result = $row2['msg'] : $result ="No message available";
            (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
            if(isset($row2['outgoing_msg_id'])){
                ($_SESSION['unique_id'] == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
            }else{
                $you = "";
            }
            ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
            ($_SESSION['unique_id'] == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";
            if(!$row['photo']==''){
                $photo = $row['photo'];
            }else{
                $photo = '/uploads/dummy-image.jpeg';
            }
    
            $output .= '<a href="chat.php?user_id='. $row['unique_id'] .'">
                        <div class="content">
                        <img src="assets/php/'. $photo .'" alt="">
                        <div class="details">
                            <span>'. $row['name']. " " .  '</span>
                            <p>'. $you . $msg .'</p>
                        </div>
                        </div>
                        <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                    </a>';
        }
     
    }
    echo $output;
}

//Insert chat into database
if(isset($_POST['action']) && $_POST['action'] == "insert_chat"){
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = $_POST['incoming_id'];
    $message = $_POST['message'];
    if(!empty($message)){
        $stmt = $cuser->conn->prepare("INSERT INTO chats (incoming_msg_id, outgoing_msg_id, msg) VALUES (?, ?, ?)");
        $stmt->execute([$incoming_id, $outgoing_id, $message]);
    }
}


//Getting the chat from database
if(isset($_POST['action']) && $_POST['action'] == "get_chat"){
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = $_POST['incoming_id'];
        $output = "";
        $sql = "SELECT * FROM chats LEFT JOIN users ON users.unique_id = chats.outgoing_msg_id
                WHERE (outgoing_msg_id = :outgoing_id AND incoming_msg_id = :incoming_id)
                OR (outgoing_msg_id = :incoming_id AND incoming_msg_id = :outgoing_id) ORDER BY msg_id";
        $stmt = $cuser->conn->prepare($sql);
        $stmt->bindParam('outgoing_id', $outgoing_id);
        $stmt->bindParam('incoming_id', $incoming_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0){
            foreach($result as $row){
                if(!$row['photo']==''){
                    $photo = $row['photo'];
                }else{
                    $photo = '/uploads/dummy-image.jpeg';
                }
                if($row['outgoing_msg_id'] == $outgoing_id){
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';
                }else
                {
                    $output .= '<div class="chat incoming">
                                <img src="assets/php/'.$photo.'" alt="">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';
                }
            }
        }else{
            $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
        }
        echo $output;
    }


    //Search the users based on their name 
    if(isset($_POST['action']) && $_POST['action'] == 'search_users'){
    $outgoing_id = $_SESSION['unique_id'];
    $searchTerm = $_POST['searchTerm'];

    $sql = "SELECT * FROM users WHERE NOT unique_id = ? AND (name LIKE ?)";
    $stmt = $cuser->conn->prepare($sql);
    $stmt->execute([$outgoing_id, '%'.$searchTerm.'%']);
    $query = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output = "";
    if(count($query) > 0){
            foreach($query as $row){
            $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = :unique_id OR outgoing_msg_id = :unique_id) 
            AND (outgoing_msg_id = :outgoing_id OR incoming_msg_id = :incoming_id) 
            ORDER BY msg_id DESC LIMIT 1";
            $query2 = $cuser->conn->prepare($sql2);
            $query2->bindParam(':unique_id', $row['unique_id']);
            $query2->bindParam(':outgoing_id', $_SESSION['unique_id']);
            $query2->bindParam(':incoming_id', $_SESSION['unique_id']);
            $query2->execute();
            $row2 = $query2->fetch(PDO::FETCH_ASSOC);
            
            $rowCount = $query2->rowCount();
            ($rowCount > 0) ? $result = $row2['msg'] : $result ="No message available";
            (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
            if(isset($row2['outgoing_msg_id'])){
                ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
            }else{
                $you = "";
            }
            ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
            ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";

            if(!$row['photo']==''){
                $photo = $row['photo'];
            }else{
                $photo = '/uploads/dummy-image.jpeg';
            }
    
            $output .= '<a href="chat.php?user_id='. $row['unique_id'] .'">
                        <div class="content">
                        <img src="assets/php/'. $photo .'" alt="">
                        <div class="details">
                            <span>'. $row['name']. " "  . '</span>
                            <p>'. $you . $msg .'</p>
                        </div>
                        </div>
                        <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                    </a>';
        
    }
    }else{
        $output .= 'No user found related to your search term';
    }
    echo $output;
    }

    //Status update in the database
    if(isset($_POST['status'])){
        $status = $_POST['status'];
        $sql = "UPDATE users SET status=:status WHERE unique_id=:unique_id";
        $stmt = $cuser->conn->prepare($sql);
        $stmt->execute(['status'=>$status, 'unique_id'=>$_SESSION['unique_id']]);

        $sql2 = "SELECT * FROM users WHERE unique_id=:unique_id";
        $stmt2 = $cuser->conn->prepare($sql2);
        $stmt2->execute(['unique_id'=>$_SESSION['unique_id']]);
        $result = $stmt2->fetch(PDO::FETCH_ASSOC);
        $final_status = $result['status'];
        echo $final_status;
        
    }





?>