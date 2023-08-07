<h3 class="text-center text-success">All Orders</h3>
<table class="table table-bordered mt-5">
    <thead class="bg-info">

        <?php
            $get_orders = "SELECT * FROM `user_orders`";
            $result = mysqli_query($con , $get_orders);
            $row_count = mysqli_num_rows($result);
           

            if($row_count == 0){
                echo "<h2 class='text-danger text-center mt-5'>No Orders Yet</h2>";
            }else{
                echo "<tr class='text-center'>
                <th>Slno</th>
                <th>Due Amount</th>
                <th>Invoice Number</th>
                <th>Total Products</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Delete</th>
                </tr>
                </thead>   
                <tbody class='bg-secondary text-light'>";
                $number = 0;
                while($row_data = mysqli_fetch_assoc($result)){
                    $order_id = $row_data['order_id'];
                    $user_id = $row_data['user_id'];
                    $amount_due = $row_data['amount_due'];
                    $invoice_no = $row_data['invoice_no'];
                    $total_products = $row_data['total_products'];
                    $order_date = $row_data['order_date'];
                    $order_status = $row_data['order_status'];
                    $number++;
                    echo "<tr class='text-center'>
                    <td>$number</td>
                    <td>$amount_due</td>
                    <td>$invoice_no</td>
                    <td>$total_products</td>
                    <td>$order_date</td>
                    <td>$order_status</td>
                    <td><a href='index.php?delete_orders=$order_id' 
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
        <a href="./index.php?list_orders" class="text-light text-decoration-none">No</a></button>
        <button type="button" class="btn btn-primary"><a href='index.php?delete_orders=<?php echo $order_id ?>' 
        class="text-light text-decoration-none">Yes</a></button>
      </div>
    </div>
  </div>
</div>