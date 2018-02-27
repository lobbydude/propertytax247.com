<?php
session_start();
if (isset($_POST['total_cart_items'])) {
    if (isset($_SESSION['cart_item'])) {
        echo count($_SESSION['cart_item']);
    } else {
        echo "0";
    }
}

if (isset($_POST['showcart'])) {
    $total_amount = 0;
    if (isset($_SESSION["cart_item"])) {
        foreach ($_SESSION["cart_item"] as $item) {
            $plan_id_sess = $item['plan_name'];
            $code_sess = $item['code'];
            $q_plan_sess = "select * from tbl_plan where Plan_Id=$plan_id_sess";
            $result_plan_sess = mysql_query($q_plan_sess);
            while ($row_plan_sess = mysql_fetch_array($result_plan_sess)) {
                $plan_name_sess = $row_plan_sess['Plan_Name'];
                $plan_price_sess1 = $row_plan_sess['Price'];
                $plan_price_sess = number_format((float) $plan_price_sess1, 2, '.', '');
                ?>

                <div class="row">
                    <div class="col-sm-6">
                        <span class="text-theme">
                            <?php echo $plan_name_sess . " - " . $item['order_type'] ?>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-theme"><?php echo "$" . $plan_price_sess; ?></span>                        
                    </div>

                    <div class="col-sm-1">
                        <i class="fa fa-close" style="cursor:pointer;color:#fff" onclick="removepopupcart('<?php echo $code_sess; ?>')">
                        </i>                       
                    </div>
                </div>
                <div class="divider-singledotted" style="margin-top:6px;"></div>
                <?php
                $total_amount = $plan_price_sess + $total_amount;
            }
        }
        ?>
        <div class="row">
            <div class="col-sm-6">
                <span class="text-theme">Total : $<?php
                    $total_amount1 = number_format((float) $total_amount, 2, '.', '');
                    echo $total_amount1;
                    ?></span>
            </div>
            <div class="col-sm-6"> <a href="<?php echo site_url('Cart')?>" class="delete pull-right">CHECKOUT</a> </div>
        </div>
        <?php
    } else {
        echo 'Your Cart is Empty';
    }
}
?>