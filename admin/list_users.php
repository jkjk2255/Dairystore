<h3 class="text-center text-success">All Users</h3>
<table class="table table-bordered mt-5">
    <thead class="bg-info">

        <?php
            $get_user = "SELECT * FROM `user_table`";
            $result = mysqli_query($con , $get_user);
            $row_count = mysqli_num_rows($result);
           

            if($row_count == 0){
                echo "<h2 class='text-danger text-center mt-5'>No Users Yet</h2>";
            }else{
                echo "<tr class='text-center'>
                <th>Slno</th>
                <th>Username</th>
                <th>User Email</th>
                <th>User Image</th>
                <th>User Address</th>
                <th>User Mobile</th>
                <th>Delete</th>
                </tr>
                </thead>   
                <tbody class='bg-secondary text-light'>";
                $number = 0;
                while($row_data = mysqli_fetch_assoc($result)){
                    $user_id = $row_data['user_id'];
                    $username = $row_data['username'];
                    $user_email = $row_data['user_email'];
                    $user_img = $row_data['user_image'];
                    $user_address = $row_data['user_address'];
                    $user_mobile = $row_data['user_mobile'];
                    $number++;
                    echo "<tr class='text-center'>
                    <td>$number</td>
                    <td>$username</td>
                    <td>$user_email</td>
                    <td><img src='../user_area/user_images/$user_img' alt='$username' class='user_img'/></td>
                    <td>$user_address</td>
                    <td>$user_mobile</td>
                    <td><a href='index.php?delete_user=$user_id' 
                    type='button' class='text-light' data-toggle='modal' data-target='#exampleModal'> 
                    <i class='fa-solid fa-trash text-light'></i></a></td>
                </tr>";
                }
            }
       ?>

    </thead>   
    <tbody class="bg-secondary text-light">
        
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
      <div class="modal-body">
        <h4>Are You Sure Want To Delete This?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
        <a href="./index.php?list_payments" class="text-light text-decoration-none">No</a></button>
        <button type="button" class="btn btn-primary"><a href='index.php?delete_payment=<?php echo $payment_id ?>' 
        class="text-light text-decoration-none">Yes</a></button>
      </div>
    </div>
  </div>
</div>