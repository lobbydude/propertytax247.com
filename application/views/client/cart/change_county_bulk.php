<?php
if (isset($_POST['state_id'])) {
    $S_Id = $_POST['state_id'];
    $plan_id = $_POST['plan_id'];
    $q_plan_sess = "select * from tbl_plan where Plan_Id=$plan_id";
    $result_plan_sess = mysql_query($q_plan_sess);
    while ($row_plan_sess = mysql_fetch_array($result_plan_sess)) {
        $no_of_order = $row_plan_sess['No_Of_Order'];
        $plan_price_sess1 = $row_plan_sess['Price'];
        $plan_price_sess = number_format((float) $plan_price_sess1, 2, '.', '');
        $perorder_price = $plan_price_sess1 / $no_of_order;
        $perorder_amt = number_format((float) $perorder_price, 2, '.', '');
    }

    if (!empty($S_Id)) {
        $S_Id = $_POST['state_id'];
        $state_id_no = implode(',', $S_Id);
        $q_countywise = "select * from tbl_countywise where Status=1 AND Statewise_Id in ({$state_id_no})";
        $result_countywise = mysql_query($q_countywise);
        $count_countywise = mysql_num_rows($result_countywise);
        ?>
        <script src="<?php echo site_url('assets/global/dropdown/cbpHorizontalMenu.min.js') ?>"></script>
        <script>
            $(function () {
                cbpHorizontalMenu.init();
            });

            function valcontrol(btn, j) {
                var $button = btn;
                var min = 0;
                var max = 10;
                var $input = $button.closest('.sp-quantity').find("input.quntity-input");
                $input.val(function (i, value) {
                    var count = +value + (10 * +$button.data('multi'));
                    if (parseInt(count) < min || isNaN(count)) {
                        $('#lesscart_item').show();
                        return 0;
                    }
                    else if (parseInt(count) >= max) {
                        var total = (parseInt(count)) % max;
                        if (total == 0) {
                            $('#lesscart_item').hide();
                            $('#no_of_order_count' + j).val(count);
                            chkcontrol(j);
                            return parseInt(count);
                        } else {
                            $('#lesscart_item').show();
                            return 0;
                        }
                    }
                    else {
                        chkcontrol(j);
                        return count;
                    }
                });
            }
           function minmax(value, j)
            {
                var min = 0;
                var max = 10;
                if (parseInt(value) < min || isNaN(value) || parseInt(value) < max) {
                    $('#lesscart_item').show();
                    return 0;
                }
                else if (parseInt(value) >= max) {
                    var total = (parseInt(value)) % max;
                    if (total == 0) {
                        $('#lesscart_item').hide();
                        chkcontrol(j);
                        return parseInt(value);
                    } else {
                        return 0;
                        $('#lesscart_item').show();
                    }
                }
                else {
                    chkcontrol(j);
                    return value;
                }
            }
            function chkcontrol(j) {
                var sum = 0;
                var no_of_order = 0;
                var length = $('[name="add_county"]').length;
                for (var i = 0; i < length; i++) {
                    if (document.planForm.add_county[i].checked) {
                        no_of_order = $('#no_of_order_count' + (i + 1)).val();
                        if (no_of_order == 0) {
                            $('#lesscart_item').show();
                            return false;
                        } else {
                            sum = sum + parseInt(no_of_order);
                        }
                    }
                }
                if (sum < 10) {
                    $('#lesscart_item').show();
                }
                else if (sum > 10) {
                    var nooforder = sum / 10;
                    if ((nooforder % 1) != 0) {
                        $('#lesscart_item').show();
                    } else {
                        $('#lesscart_item').hide();
                        var price = "<?php echo $plan_price_sess; ?>";
                        var total_amount = price * nooforder;
                        var price_total_amount = total_amount.toFixed(2);
                        $("#add_price").val(sum + " orders @ $<?php echo $perorder_amt; ?> each / $" + price_total_amount + " Total")
                        var countycheckid = [];
                        var countyorder = [];
                        $("input:checkbox[name=add_county]:checked").each(function () {
                            countycheckid = $(this).attr("id");
                            countyorder += $('#' + countycheckid).val() + "(" + $('#no_of_order_count' + countycheckid).val() + "),";
                        });
                        $(".add_county_li").attr("data-tooltip", countyorder);
                    }
                } else {
                    $('#lesscart_item').hide();
                    var nooforder = sum / 10;
                    var price = "<?php echo $plan_price_sess; ?>";
                    var total_amount = price * nooforder;
                    var price_total_amount = total_amount.toFixed(2);
                    $("#add_price").val(sum + " orders @ $<?php echo $perorder_amt; ?> each / $" + price_total_amount + " Total")
                    var countycheckid = [];
                    var countyorder = [];
                    $("input:checkbox[name=add_county]:checked").each(function () {
                        countycheckid = $(this).attr("id");
                        countyorder += $('#' + countycheckid).val() + "(" + $('#no_of_order_count' + countycheckid).val() + "),";
                    });
                    $(".add_county_li").attr("data-tooltip", countyorder);
                }
            }
        </script>

        <div id="cbp-hrmenu" class="cbp-hrmenu">
            <ul>
                <li>
                    <a href="#" class="add_county_li" id="add_county_li">County Name</a>
                    <div class="cbp-hrsub" style="width:152%;">                       
                        <div class="cbp-hrsub-inner"> 
                            <div>
                                <ul>
                                    <?php
                                    if ($count_countywise > 0) {
                                        $i = 1;
                                        while ($row_countywise = mysql_fetch_array($result_countywise)) {
                                            $County_Id = $row_countywise['County_Id'];
                                            $statewise_id = $row_countywise['Statewise_Id'];
                                            $q_statewise = "select * from tbl_statewise where Status=1 AND S_Id=$statewise_id";
                                            $result_statewise = mysql_query($q_statewise);
                                            while ($row_statewise = mysql_fetch_array($result_statewise)) {
                                                $State_Id = $row_statewise['State_Id'];
                                                $q_state = "select * from tbl_state where State_ID=$State_Id";
                                                $result_state = mysql_query($q_state);
                                                while ($row_state = mysql_fetch_array($result_state)) {
                                                    $State_Abbreviation = $row_state['Abbreviation'];
                                                    $q_county = "select * from tbl_county where County_ID=$County_Id";
                                                    $result_county = mysql_query($q_county);
                                                    while ($row_county = mysql_fetch_array($result_county)) {
                                                        $County = $row_county['County'];
                                                        ?>
                                                        <li>
                                                            <input name="add_county" type="checkbox" class="check" id="<?php echo $i; ?>" value="<?php echo $State_Abbreviation . " - " . $County; ?>" onclick="chkcontrol(<?php echo $i; ?>)">
                                                            <input type="hidden" value="<?php echo $County_Id; ?>" name="county_id" id="county_id<?php echo $i; ?>"/>
                                                            <span class="cname"><?php echo $State_Abbreviation . " - " . $County; ?></span>
                                                            <span class="sp-quantity">
                                                                <a class="ddd" data-multi="-1" onclick="valcontrol(($(this)),<?php echo $i; ?>)">-</a>
                                                                <input type="text" class="quntity-input" value="0" maxlength="2" onkeyup="this.value = minmax(this.value,<?php echo $i; ?>)" name="no_of_order_count" id="no_of_order_count<?php echo $i; ?>"/>
                                                                <a class="ddd" data-multi="1" onclick="valcontrol(($(this)),<?php echo $i; ?>)">+</a>
                                                            </span>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                            }
                                            $i++;
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <?php
    }
} else {
    ?>
    <select style="margin-left:-40px;color:#002040" class="form-control select2me option3" name="add_county" id="add_county" autocomplete="off" style="text-align:center;" required>
        <option value=''> -- Select County -- </option>
    </select>
<?php } ?>

