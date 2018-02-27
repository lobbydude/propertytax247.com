<?php
$plan_id = $_POST['plan_id'];
if (!empty($plan_id)) {
    $q_plan = "select * from tbl_plan where Status=1 AND Plan_Id=$plan_id";
    $result_plan = mysql_query($q_plan);
    $count_plan = mysql_num_rows($result_plan);
    if ($count_plan > 0) {
        while ($row_plan = mysql_fetch_array($result_plan)) {
            $plan_id = $row_plan['Plan_Id'];
            $price = $row_plan['Price'];
            $plan_type = $row_plan['Type'];
            $no_of_order = $row_plan['No_Of_Order'];
            $perorder_price = $price / $no_of_order;
            $perorder_amt = number_format((float) $perorder_price, 2, '.', '');
            $plan_price = number_format((float) $price, 2, '.', '');
            if ($plan_type == "Single") {
                echo "$" . $plan_price;
            }
            if ($plan_type == "Bulk") {
                echo $no_of_order . " orders @ $" . $perorder_amt . " each / $" . $plan_price . " Total";
            }
        }
    }
}
?>
