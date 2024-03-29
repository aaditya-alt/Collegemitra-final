<?php

require_once 'config.php';

class Auth extends Database{


    //Register new user 
    public function register($name, $email, $password){
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :pass)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['name'=>$name, 'email'=>$email, 'pass'=>$password]);
    return true;
}

    //Check if user already registered

    public function user_exist($email){
        $sql="SELECT email FROM users WHERE email=:email";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    //Login existing user

    public function login($email){
        $sql= "SELECT email, password FROM users WHERE email=:email AND deleted !=0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    //Current user details in session
    public function currentUser($email){
        $sql = "SELECT * FROM users WHERE email=:email AND deleted !=0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    //forgot-password
    public function forgot_password($token, $email){
        $sql="UPDATE users SET token =:token, token_expire = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email =:email";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute(['token'=>$token, 'email'=>$email]);

        return true;

    }

    //Update profile of an user
    public function update_profile($jee_rank, $phone, $gender, $photo, $category, $state, $id){
        $sql = "UPDATE users SET jee_rank=:jee_rank, gender=:gender, phone=:phone, photo=:photo, category=:category, state=:state WHERE id=:id AND deleted!=0";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute(['jee_rank'=>$jee_rank, 'gender'=>$gender, 'phone'=>$phone, 'photo'=>$photo, 'category'=>$category, 'state'=>$state, 'id'=>$id]);

        return true;
    }

    //Change password of an user 
    public function change_password($pass, $id){
        $sql = "UPDATE users SET password = :pass WHERE id=:id AND deleted !=0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['pass'=>$pass, 'id'=>$id]);
        return true;
    }

    //Send feedback to the database
    public function send_feedback($sub, $feed, $uid, $counselling){
        $sql = "INSERT INTO feedback (uid, subject, feedback, counselling) VALUES (:uid,:sub,:feed, :counselling)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid, 'sub'=>$sub, 'feed'=>$feed, 'counselling'=>$counselling]);
        return true;
    }

    //Check choice filling in the database
    public function check_choice_filling($id){
        $sql = "SELECT * FROM choice_filling WHERE uid=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    //Delete choice filling data from database
    public function delete_choice_filling($id){
        $sql = "DELETE FROM choice_filling WHERE uid=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return true;
    }

    //Send choice filling data to database
    public function choice_filling($name, $rank, $gender, $counselling, $category, $uid, $description, $state){
        $sql = "INSERT INTO choice_filling (uid, name, rank, gender, counselling, category, description, state) VALUES (:uid,:name,:rank,:gender,:counselling,:category, :description, :state)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid, 'name'=>$name, 'rank'=>$rank, 'gender'=>$gender, 'counselling'=>$counselling, 'category'=>$category, 'description'=>$description, 'state'=>$state]);
        return true;
    }

    //send calling data to the database
    public function calling($uid, $name, $phone, $rank, $category, $mentor, $counselling){
        $sql = "INSERT INTO calling(uid, name, rank, phone, category, mentor, counselling) VALUES (:uid, :name, :rank, :phone, :category, :mentor, :counselling)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid, 'name'=>$name, 'rank'=>$rank, 'phone'=>$phone, 'category'=>$category, 'mentor'=>$mentor, 'counselling'=>$counselling]);
        return true;
    }

    //Fetch all updates for all users
    public function fetchAllUpdates(){
        $sql = "SELECT * FROM updates";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //FETCH UPDATES In detail 
    public function fetch_updates_detail($id){
        $sql = "SELECT * FROM updates WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    //Insert notification 
    public function notification($uid, $type, $message, $counselling){
        $sql = "INSERT INTO notification (uid, type, message, counselling) VALUES (:uid, :type, :message, :counselling)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid, 'type'=>$type, 'message'=>$message, 'counselling'=>$counselling]);
        return true;
    }

    //fetch notification 
    public function fetchNotification($uid){
        $sql = "SELECT * FROM notification WHERE uid=:uid AND type='user' ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid'=>$uid]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //Remove notification from database
    public function removeNotification($id){
        $sql = "DELETE FROM notification WHERE id=:id AND type='user' ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return true;
    }

    //Get choice filling details by user id
    public function get_choice_filling($id){
        $sql = "SELECT * FROM choice_filling WHERE uid=:id AND sent=1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    
   //Reset Password user auth
   public function reset_pass_auth($email, $token){
    $sql = "SELECT id FROM users WHERE email=:email AND token=:token AND token!= '' AND token_expire>NOW() AND deleted !=0";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['email'=>$email, 'token'=>$token]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
   }

   //Update new password
   public function update_new_pass($pass, $email){
    $sql = "UPDATE users SET token='', password=:pass WHERE email=:email AND deleted!=0";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['pass'=>$pass, 'email'=>$email]);
    return true;
   }

   //Get users for chat
   public function getting_chat_mentors($counselling){
    $sql = "SELECT * FROM users WHERE counselling=:counselling";
    $query = $this->conn->prepare($sql);
    $query->bindParam(':counselling', $counselling);
    $query->execute();
    $row = $query->fetchAll(PDO::FETCH_ASSOC);
    return $row;
   }


}


?>