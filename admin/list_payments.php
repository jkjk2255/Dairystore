<h3 class="text-center text-success">All Payments</h3>
<table class="table table-bordered mt-5">
    <thead class="bg-info">

        <?php
            $get_payments = "SELECT * FROM `user_payments`";
            $result = mysqli_query($con , $get_payments);
            $row_count = mysqli_num_rows($result);
           

            if($row_count == 0){
                echo "<h2 class='text-danger text-center mt-5'>No Orders Yet</h2>";
            }else{
                echo "<tr class='text-center'>
                <th>Slno</th>
                <th>Due Amount</th>
                <th>Invoice Number</th>
                <th>Amount</th>
                <th>Payment Mode</th>
                <th>Order Date</th>
                <th>Delete</th>
                </tr>
                </thead>   
                <tbody class='bg-secondary text-light'>";
                $number = 0;
                while($row_data = mysqli_fetch_assoc($result)){
                    $payment_id = $row_data['payment_id'];
                    $order_id = $row_data['order_id'];
                    $amount = $row_data['amount'];
                    $invoice_no = $row_data['invoice_no'];
                    $payment_mode = $row_data['payment_mode'];
                    $date = $row_data['date'];
                    $number++;
                    echo "<tr class='text-center'>
                    <td>$number</td>
                    <td>$amount</td>
                    <td>$invoice_no</td>
                    <td>$amount</td>
                    <td>$payment_mode</td>
                    <td>$date</td>
                    <td><a href='index.php?delete_payment=$payment_id' 
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