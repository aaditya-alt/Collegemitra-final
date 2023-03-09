<?php
    require_once './assets/php/header.php';

?>
<head>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
</head>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card my-2 border-info">
        <div class="card-header bg-info text-white">
          <h4 class="m-0"><b>Updates From The Counselling</b></h4>
        </div>
        <div class="card-body">
          <div class="table-responsive" id="showAllUpdates">
            <table class="table table-hover table-striped">
              <thead class="bg-secondary text-white">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Title</th>
                  <th scope="col">Update</th>
                  <th scope="col">PDF</th>
                  <th scope="col">Counselling</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>HSTES</td>
                  <td>HSTES</td>
                  <td>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti nam animi fugiat exercitationem aliquid tempora omnis id quas nihil, accusantium, qui, saepe beatae est eveniet deserunt non totam minima ipsam.</td>
                  <td></td>
                  <td>
                    <a href="#" class="btn btn-sm btn-info infoBtn" title="View Details"><i class="fas fa-info-circle fa-lg"></i> Details</a>
                  </td>
                </tr>
              </tbody>
            </table>

            <div class="text-center align-self-center py-3">
              <div class="spinner-border text-info" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <p class="lead mb-0">Please Wait...</p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js" ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    
    <script type="text/javascript">
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

     $(document).ready(function(){
      $("table").DataTable();

      //Fetch all updates ajax request
      fetchAllUpdates();
        function fetchAllUpdates(){
            $.ajax({
                url:'assets/php/process.php',
                method: 'post',
                data: {action: 'fetchAllUpdates'},
                success: function(response){
                    $("#showAllUpdates").html(response);
                    $("table").DataTable({
                      "pageLength": 10
                    });
                }
            });
        }

        //View user details ajax request
        $("body").on("click", ".infoBtn", function(e){
            e.preventDefault();

            info_id = $(this).attr('id');

            $.ajax({
                url:'assets/php/process.php',
                method: 'post',
                data: {info_id: info_id},
                success: function(response){
                    data = JSON.parse(response);
                    Swal.fire({
                        title: '<strong>Note : ID('+data.counselling+')</strong>',
                        type: 'info',
                        html: '<b>Title :</b>'+data.title+'<br><br><b>Note : </b>'+data.update+'<br><br><b>File Attached : </b><a href="assets/php/'+data.pdf+'">Download Now</a>'+'<br><br><b>Written On :</b>'+data.created_at+'<br><br><b>Updated On : </b>'+data.updated_at,
                        showcloseButton: true,
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
     });


    </script>


  </body>
  </html>