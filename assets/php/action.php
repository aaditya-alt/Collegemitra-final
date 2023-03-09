<?php

require_once 'auth.php';
$user = new Auth();

if(isset($_POST['action'])&& $_POST['action'] == 'predict_college'){
    $rank = $cuser->test_input($_POST['rank']);
    $category = $user->test_input(($_POST['category']));
    $output = '';
    $data = $user->get_prediction($rank, $category);
    print_r($data);
    if($data){
        $output .= '<table class="table tablle-striped table-bordered text-center">
                    <thead>
                    <tr>
                       <th>#</th>
                       <th>College</th>
                       <th>Branch</th>
                       <th>Category</th>
                       <th>Opening Rank</th>
                       <th>Closing Rank</th>
                    </tr>
                    </thead>
                    <tbody>';
                    foreach($data as $row){
                        $output .= '<tr>
                        <td>'.$row['id'].'</td>
                        <td>'.$row['college'].'</td>
                        <td>'.$row['branch'].'</td>
                        <td>'.$row['category'].'</td>
                        <td>'.$row['openingRank'].'</td>
                        <td>'.$row['closingRank'].'</td>
                        </tr>';
                    }

                    $output .= '</tbody>
                    </table>';

                    echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:(No any user registered yet!)</h3>';
    }
}



?>