<?php
$plan_id = $_POST['plan_id'];
$q_statewise = "select * from tbl_statewise where Status=1 AND Plan_Id=$plan_id";
$result_statewise = mysql_query($q_statewise);
$count_statewise = mysql_num_rows($result_statewise);
?>
<?php
if ($count_statewise > 0) {
    echo "<option value=''> --State-- </option>";
    while ($row_statewise = mysql_fetch_array($result_statewise)) {
        $S_Id = $row_statewise['S_Id'];
        $State_Id = $row_statewise['State_Id'];
        $q_state = "select * from tbl_state where State_ID=$State_Id";
        $result_state = mysql_query($q_state);
        while ($row_state = mysql_fetch_array($result_state)) {
            $Abbreviation = $row_state['Abbreviation'];
            ?>
            <option value="<?php echo $S_Id; ?>"><?php echo $Abbreviation; ?> <?php //echo $State;  ?></option>
            <?php
        }
    }
}
?>
