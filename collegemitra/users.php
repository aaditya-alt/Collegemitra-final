<?php
include_once "assets/php/session.php";
require_once "assets/php/header.php";
// include_once "assets/php/auth.php";
$user = new Auth();
?>
<?php include_once "assets/php/header.php"; ?>
<head>
  <style>
    .wrapper{
        margin-top: 80px;
  margin-left: 400px;
  background: #fff;
  max-width: 450px;
  width: 100%;
  border-radius: 16px;
  box-shadow: 0 0 128px 0 rgba(0,0,0,0.1),
              0 32px 64px -48px rgba(0,0,0,0.5);
}
@media screen and (max-width: 450px) {

    .wrapper{
    margin-left: auto;
  }
  .users header img{
    height: 45px;
    width: 45px;
  }
  .users header .logout{
    padding: 6px 10px;
    font-size: 16px;
  }
  :is(.users, .users-list) .content .details{
    margin-left: 15px;
  }

  .users-list a{
    padding-right: 10px;
  }
}
/* Users List CSS Start */
.users{
  padding: 25px 30px;
}
.users header,
.users-list a{
  display: flex;
  align-items: center;
  padding-bottom: 20px;
  border-bottom: 1px solid #e6e6e6;
  justify-content: space-between;
}
.wrapper img{
  object-fit: cover;
  border-radius: 50%;
}
.users header img{
  height: 50px;
  width: 50px;
}
:is(.users, .users-list) .content{
  display: flex;
  align-items: center;
}
:is(.users, .users-list) .content .details{
  color: #000;
  margin-left: 20px;
}
:is(.users, .users-list) .details span{
  font-size: 18px;
  font-weight: 500;
}
.users header .logout{
  display: block;
  background: #333;
  color: #fff;
  outline: none;
  border: none;
  padding: 7px 15px;
  text-decoration: none;
  border-radius: 5px;
  font-size: 17px;
}
.users .search{
  margin: 20px 0;
  display: flex;
  position: relative;
  align-items: center;
  justify-content: space-between;
}
.users .search .text{
  font-size: 18px;
}
.users .search input{
  position: absolute;
  height: 42px;
  width: calc(100% - 50px);
  font-size: 16px;
  padding: 0 13px;
  border: 1px solid #e6e6e6;
  outline: none;
  border-radius: 5px 0 0 5px;
  opacity: 0;
  pointer-events: none;
  transition: all 0.2s ease;
}
.users .search input.show{
  opacity: 1;
  pointer-events: auto;
}
.users .search button{
  position: relative;
  z-index: 1;
  width: 47px;
  height: 42px;
  font-size: 17px;
  cursor: pointer;
  border: none;
  background: #fff;
  color: #333;
  outline: none;
  border-radius: 0 5px 5px 0;
  transition: all 0.2s ease;
}
.users .search button.active{
  background: #333;
  color: #fff;
}
.search button.active i::before{
  content: '\f00d';
}
.users-list{
  max-height: 350px;
  overflow-y: auto;
}
:is(.users-list, .chat-box)::-webkit-scrollbar{
  width: 0px;
}
.users-list a{
  padding-bottom: 10px;
  margin-bottom: 15px;
  padding-right: 15px;
  border-bottom-color: #f1f1f1;
}
.users-list a:last-child{
  margin-bottom: 0px;
  border-bottom: none;
}
.users-list a img{
  height: 40px;
  width: 40px;
}
.users-list a .details p{
  color: #67676a;
}
.users-list a .status-dot{
  font-size: 12px;
  color: #468669;
  padding-left: 10px;
}
.users-list a .status-dot.offline{
  color: #ccc;
}
  </style>
</head>
<div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <?php 
            $stmt = $user->conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(":email", $_SESSION['user']);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['unique_id'] = $row['unique_id'];
            if(!$row['photo'] == ''){
              $photo = $row['photo'];
            }else{
              $photo = '/uploads/dummy-image.jpeg';
            }
          ?>
          <img src="assets/php/<?php echo $photo; ?>" alt="">
          <div class="details">
            <span><?php echo $row['name']. " " ?></span>
            <div class="status">
            <p><?php echo $row['status']; ?></p>
            </div>
          </div>
        </div>
        <div class="logout">
        <?php
                        
                        $counsellingHosts = array('HSTES', 'UPTU', 'MPDTE', 'REAP', 'UGEAC', 'JOSAA', 'OJEE');
                        
                        // Assume that $array is the array that you want to check
                        $array = $all_counselling;
                        
                        // Output the HTML code for the <select> element
                        echo '<select name="counselling-chat" id="counselling-chat"class="logout form-control">
                              <option value="Counselling" selected disabled>Counselling</option>';
                        
                        
                        foreach ($counsellingHosts as $host) {
                            $optionText = ucfirst($host);
                            $optionValue = $host;
                            $optionDisabledAttr = !in_array($host, $array) ? 'disabled' : '';
                            echo "<option value=\"$optionValue\" $optionDisabledAttr>$optionText</option>";
                        }
                        
                        echo '</select>';
                        ?>
        </div>
      </header>
      <div class="search">
        <span class="text">Select an user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
  
      </div>
    </section>
  </div>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>

    <script type="text/javascript" src="./assets/js/script.js"></script>


  <script>
const searchBar = document.querySelector(".search input"),
searchIcon = document.querySelector(".search button"),
usersList = document.querySelector(".users-list");

//Getting user list based on counselling
const selectElement = document.getElementById("counselling-chat");
selectElement.addEventListener("change", function() {
  const selectedValue = selectElement.value;
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "assets/php/process.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if(xhr.status === 200){
          let data = xhr.response;
          console.log(data);
          if(!searchBar.classList.contains("active")){
            usersList.innerHTML = data;
          }
        }
  };
  xhr.send("selectedValue=" + encodeURIComponent(selectedValue) + "&action=chat_users");
});


searchIcon.onclick = ()=>{
  searchBar.classList.toggle("show");
  searchIcon.classList.toggle("active");
  searchBar.focus();
  if(searchBar.classList.contains("active")){
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
}

searchBar.onkeyup = ()=>{
  let searchTerm = searchBar.value;
  if(searchTerm != ""){
    searchBar.classList.add("active");
  }else{
    searchBar.classList.remove("active");
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "assets/php/process.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          usersList.innerHTML = data;
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm + "&action=search_users");
}


//Updating the status of logged in user
statusBox = document.querySelector(".status");

window.addEventListener('load', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'assets/php/process.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
            data=xhr.response;
            console.log(data);
            statusBox.innerHTML=data;
        }
    }
  }
    xhr.send('status=Active now');
});


//Getting the user list

// setInterval(() =>{
//   let xhr = new XMLHttpRequest();
//   xhr.open("GET", "php/users.php", true);
//   xhr.onload = ()=>{
//     if(xhr.readyState === XMLHttpRequest.DONE){
//         if(xhr.status === 200){
//           let data = xhr.response;
//           if(!searchBar.classList.contains("active")){
//             usersList.innerHTML = data;
//           }
//         }
//     }
//   }
//   xhr.send();
// }, 500);



//Updating status
// statusBox = document.querySelector(".status");

// // The timeout period for inactivity (in milliseconds)
// const INACTIVITY_TIMEOUT = 1000;

// // Variable to hold the inactivity timer
// let inactivityTimer;

// // Function to reset the inactivity timer and send an AJAX request to update the status as active
// function resetInactivityTimer() {
//   // Make an AJAX request to the PHP script to update the database column with the active status
//   const xhr = new XMLHttpRequest();
//   xhr.open('POST', 'php/update_status.php');
//   xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//   xhr.onload = ()=>{
//     if(xhr.readyState === XMLHttpRequest.DONE){
//         if(xhr.status === 200){
//             // If the request was successful, update the status box with the response from the server
//             data=xhr.response;
//             statusBox.innerHTML=data;
//         }
//     }
//   }
//   xhr.send('active_status=Active now');

//   // Clear the previous timer (if any)
//   clearTimeout(inactivityTimer);

//   // Start a new timer
//   inactivityTimer = setTimeout(sendInactiveRequest, INACTIVITY_TIMEOUT);
// }

// // Function to send the inactive request to the PHP script and update the status box
// function sendInactiveRequest() {
//   // Make an AJAX request to the PHP script to update the database column with the inactive status
//   const xhr = new XMLHttpRequest();
//   xhr.open('POST', 'php/update_status.php');
//   xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//   xhr.onload = ()=>{
//     if(xhr.readyState === XMLHttpRequest.DONE){
//         if(xhr.status === 200){
//             // If the request was successful, update the status box with the response from the server
//             data=xhr.response;
//             statusBox.innerHTML=data;
//         }
//     }
//   }
//   xhr.send('status=Offline now');
// }

// window.addEventListener("beforeunload", function() {
//   const xhr = new XMLHttpRequest();
//   xhr.open('POST', 'php/update_status.php');
//   xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//   xhr.onload = ()=>{
//     if(xhr.readyState === XMLHttpRequest.DONE){
//         if(xhr.status === 200){
//             // If the request was successful, update the status box with the response from the server
//             data=xhr.response;
//             statusBox.innerHTML=data;
//         }
//     }
//   }
//   xhr.send('status=Offline now');
// });


// // Start the inactivity timer when the page is loaded
// inactivityTimer = setTimeout(sendInactiveRequest, INACTIVITY_TIMEOUT);

// // Event listeners for user activity (keypress and mousemove)
// document.addEventListener('keypress', resetInactivityTimer);
// document.addEventListener('mousemove', resetInactivityTimer);

  </script>
</body>
</html>