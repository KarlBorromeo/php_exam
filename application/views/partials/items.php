<?php
    for($i = 0 ; $i < $total_row_now; $i++){?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td><?= $requests[$i]['employee_name'] ?></td>
                        <td><?= $requests[$i]['request_date'] ?></td>
                        <td><?= $requests[$i]['from_date'] ?></td>
                        <td><?= $requests[$i]['to_date'] ?></td>
                        <td><?= $requests[$i]['leave_type'] ?></td>
                    </tr>   

<?php } ?>