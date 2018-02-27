<?php
$S_Id = $_POST['state_id'];
$q_countywise = "select * from tbl_countywise where Status=1 AND Statewise_Id=$S_Id";
$result_countywise = mysql_query($q_countywise);
$count_countywise = mysql_num_rows($result_countywise);
?>
<?php
if ($count_countywise > 0) {
    echo "<option value=''> -- Select County -- </option>";
    while ($row_countywise = mysql_fetch_array($result_countywise)) {
        $County_Id = $row_countywise['County_Id'];
        $q_county = "select * from tbl_county where County_ID=$County_Id";
        $result_county = mysql_query($q_county);
        while ($row_county = mysql_fetch_array($result_county)) {
            $County = $row_county['County'];
            ?>
            <option value="<?php echo $County_Id; ?>"><?php echo $County; ?></option>
            <?php
        }
    }
}
?>
