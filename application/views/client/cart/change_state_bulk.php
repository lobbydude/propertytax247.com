<?php
$plan_id = $_POST['plan_id'];
$q_statewise = "select * from tbl_statewise where Status=1 AND Plan_Id=$plan_id";
$result_statewise = mysql_query($q_statewise);
$count_statewise = mysql_num_rows($result_statewise);
?>
<script type="text/javascript">
    $(function () {
        $("#add_state").multiselect();
        $('#add_state').change(function () {
            var selected = $("#add_state option:selected");
            var state_id = [];
             var state_name = [];
            selected.each(function (i, selected) {
                state_id[i] = $(selected).val();
                state_name[i] = $(selected).text();
            });
            $("#add_state_ms").attr("data-tooltip", state_name);
            $.ajax({
                 url: "<?php echo site_url('Cart/change_county_bulk'); ?>",
                type: 'post',
                data: {
                    state_id: state_id,
                    plan_id:"<?php echo $plan_id;?>"
                },
                method: 'POST',
                success: function (msg)
                {
                    $("#add_county_div").html(msg);
                }
            });
        });
    });
    
</script>
<select style="width:108px;color:#002040" class="form-control select2me option3" name="add_state" id="add_state" autocomplete="off" style="text-align:center;" multiple="multiple" required>
    <?php
    if ($count_statewise > 0) {
        while ($row_statewise = mysql_fetch_array($result_statewise)) {
            $S_Id = $row_statewise['S_Id'];
            $State_Id = $row_statewise['State_Id'];
            $q_state = "select * from tbl_state where State_ID=$State_Id";
            $result_state = mysql_query($q_state);
            while ($row_state = mysql_fetch_array($result_state)) {
                $Abbreviation = $row_state['Abbreviation'];
                ?>
                <option value="<?php echo $S_Id; ?>"><?php echo $Abbreviation; ?></option>
                <?php
            }
        }
    }
    ?>
</select>