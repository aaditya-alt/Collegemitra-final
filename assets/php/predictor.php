<?php


try {
    $conn = new PDO("mysql:host=localhost;dbname=db_user_system", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if(isset($_POST['action'])&& $_POST['action'] == 'predict_college'){

$category = $_POST['category'];
$gender = $_POST['gender'];
$rank = $_POST['rank'];
$counselling = $_POST['counselling'];

    if ($counselling == "ALL") {
        $query = "SELECT * FROM tablename WHERE closingRank >= :rank AND gender = :gender AND category = :category AND counselling IN ('CSAB', 'MPDTE', 'UPTU')";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(":rank", $rank);
        $stmt->bindValue(":gender", $gender);
        $stmt->bindValue(":category", $category);
        $stmt->execute();
        $data = $stmt->fetchAll();
    } else if ($counselling == "CSAB" || $counselling == "UPTU" || $counselling == "MPDTE") {
        $query = "SELECT * FROM tablename WHERE closingRank >= :rank AND gender = :gender AND category = :category AND counselling = :counselling";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(":rank", $rank);
        $stmt->bindValue(":gender", $gender);
        $stmt->bindValue(":category", $category);
        $stmt->bindValue(":counselling", $counselling);
        $stmt->execute();
        $data = $stmt->fetchAll();
    }

    $number = $stmt->rowCount();
    echo $number;

$output = '';
$count = 1;
if($data){
    $output .= '<div class="col-lg-18">
                <div class="card my-2 border-warning">
                <div class="card-header text-white" style="background-color: #ff7800;">
                <h4 class="m-0" style="font-size: 150%;"><b>You Have Got '.$number.' Colleges Based On Your Preferences</b></h4>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                <table class="table table-striped table-bordered text-center" id="myTable">
                <thead>
                <tr style="font-size: 150%;">
                   <th>#</th>
                   <th>College</th>
                   <th>Branch</th>
                   <th>Category</th>
                   <th>Quota</th>
                   <th>Opening Rank</th>
                   <th>Closing Rank</th>
                   <th>Counselling</th>
                   <th>Type</th>
                </tr>
                </thead>
                <tbody>';
                foreach($data as $row){
                    $output .= '<tr style="font-size: 150%;">
                    <td>'.$count.'</td>
                    <td>'.$row['college'].'</td>
                    <td>'.$row['branch'].'</td>
                    <td>'.$row['category'].'</td>
                    <td>'.$row['quota'].'</td>
                    <td>'.$row['openingRank'].'</td>
                    <td>'.$row['closingRank'].'</td>
                    <td>'.$row['counselling'].'</td>
                    <td>'.$row['type'].'</td>
                    </tr>';
                    $count++;
                }

                $output .= '</tbody>
                </table> <p class="text-center align-self-center lead">Please Wait...</p>
                </div>
              </div>
            </div>
            </div>';

                echo $output;
}


else{
    echo '<h3 class="text-center text-secondary">:(No Records Found! </h3>';

}
}

//getting data for free pdf
if(isset($_POST['action'])&& $_POST['action'] == 'free-pdf-submit'){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $percentile = $_POST['percentile'];
    $category = $_POST['category'];
    $state = $_POST['state'];

    $query = "INSERT INTO free_pdf (name, email, phone, percentile, category, state) VALUES (:name, :email, :phone, :percentile, :category, :state)";
    $stmt = $conn->prepare($query);
    $stmt->execute(['name'=>$name, 'email'=>$email, 'phone'=>$phone, 'percentile'=>$percentile, 'category'=>$category, 'state'=>$state]);

    return true;
}

if(isset($_POST['action']) && $_POST['action'] == 'free-call-submit'){

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $percentile = $_POST['percentile'];
    $category = $_POST['category'];
    $state = $_POST['state'];

    $query = "INSERT INTO free_call (name, phone, percentile, category, state) VALUES (:name,:phone, :percentile, :category, :state)";
    $stmt = $conn->prepare($query);
    $stmt->execute(['name'=>$name, 'phone'=>$phone, 'percentile'=>$percentile, 'category'=>$category, 'state'=>$state]);

    return true;
}

if(isset($_POST['action']) && $_POST['action'] == 'payment_form_submit'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $category = $_POST['category'];
    $counselling1 = $_POST['counselling'];
    $counselling = implode(",", $counselling1);
    $rank = $_POST['rank'];
    $state = $_POST['state'];
    $dd = $_POST['dd'];
    $mm = $_POST['mm'];
    $yy = $_POST['yy'];
    $dob = $dd.'-'.$mm.'-'.$yy;
    $amount = $_POST['amount'];
    $txnid = 'txn00'.$phone;
    $key = 'gMBh5o';
    $salt = 'dBUXALRJ0BEhgQM1xIYEwcqVzgrwBbnv';
    $hash = hash('sha512', $key . '|' . $txnid . '|' . $amount . '|' . $counselling. '|' . $name . '|' . $email. '|' . '|' . '|' .  '|' . '|' . '||||||' . $salt);
    session_start();
    $_SESSION['name'] = $name;
    $_SESSION['password'] = $password;
    $_SESSION['email'] = $email;
    $_SESSION['txnid'] = $txnid;
    $_SESSION['amount'] = $amount;
    $_SESSION['hash'] = $hash;
    $_SESSION['counselling'] = $counselling;
    $_SESSION['phone'] = $phone;
    $_SESSION['state'] = $state;
    $_SESSION['rank'] = $rank;
    $_SESSION['gender'] = $gender;
    $_SESSION['category'] = $category;
    $_SESSION['dob'] = $dob;



   $response = '
        <input type="hidden" name="key" value="'.$key.'" style="font-size: 130%;" />
        <input type="hidden" name="txnid" value="'.$txnid.'" style="font-size: 130%;" />
        <input type="text" name="productinfo" value="'.$counselling.'" readonly style="font-size: 130%;" />
        <input type="text" name="amount" value="'.$amount.'" readonly style="font-size: 130%;" />
        <input type="text" name="email" value="'.$email.'" readonly style="font-size: 130%;" />
        <input type="text" name="firstname" value="'.$name.'" readonly style="font-size: 130%;" />
        <input type="hidden" name="surl" value="http://localhost/collegemitra/invoice.php" style="font-size: 130%;" />
        <input type="hidden" name="furl" value="http://localhost/collegemitra/invoice.php" style="font-size: 130%;" />
        <input type="text" name="phone" value="'.$phone.'" readonly style="font-size: 130%;" />
        <input type="hidden" name="hash" value="'.$hash.'" style="font-size: 130%;" />
      ';
echo $response;

}



function user_exist($email){
    $conn = new PDO("mysql:host=localhost;dbname=db_user_system", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql="SELECT * FROM users WHERE email=:email";
    $stmt= $conn->prepare($sql);
    $stmt->execute(['email'=>$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function register($name, $email, $password, $counselling, $state, $category, $txnid, $addedon, $gender, $rank, $dob, $phone, $premium){
    $conn = new PDO("mysql:host=localhost;dbname=db_user_system", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO users (name, email, password, premium, counselling, state, category, txnid, addedon, gender, jee_rank, dob, phone) VALUES (:name, :email, :pass, :premium  , :counselling, :state, :category, :txnid, :addedon, :gender, :rank, :dob, :phone)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['name'=>$name, 'email'=>$email, 'premium'=>$premium, 'pass'=>$password, 'counselling'=>$counselling, 'state'=>$state, 'category'=>$category, 'txnid'=>$txnid, 'addedon'=>$addedon, 'gender'=>$gender, 'rank'=>$rank, 'dob'=>$dob, 'phone'=>$phone]);
return true;
}




}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}




?>