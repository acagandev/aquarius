<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/downloadDataDB.inc.php');

// $tbl = 'tds';
$showTables = new DataTransfer(0, 0, 0);
$showColumns = new DataTransfer("", "", "");
$showTables->getTablesDB();
// $showColumns->getRowsInTable($tbl);

$jsonDataString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/json/profile.data.json');
$data = json_decode($jsonDataString, true);
$tableList = $data['table_names'];
$columnList = $data['column_names'];

?>

<!DOCTYPE html>
<div>
  <form id="tableSelectForm" method="post" action="">
    <label for="tableList">Choose table:</label>
    <select name="tableSelectList" id="tableSelectList">
      <?php

      if (isset($_POST['tableSelectList'])) {

        $tbl = $_POST['tableSelectList'];

        $showColumns->getRowsInTable($tbl);
        $jsonDataString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/json/profile.data.json');
        $data = json_decode($jsonDataString, true);
        $columnList = $data['column_names'];
        echo "You selected: " . $tbl;
      } else {
        echo "No table selected!";
      }

      foreach ($tableList as $table_name) {

        $selected = '';
        if (isset($_POST['tableSelectList']) && $_POST['tableSelectList'] == $table_name) {
          $selected = 'selected="selected"';
        }
        echo "<option value=\"$table_name\" $selected>$table_name</option>";
      }
      ?>
    </select>
    <!-- <input type="submit" value="Submit"> -->
    <button type="submit" id="submitBtn1" style="display: none;"></button>
  </form>
  <form id="columnSelectForm" method="post" action="">
    <label for="columnList">Choose parameter:</label>
    <select name="columnSelectList" id="columnSelectList">
      <?php
      // echo "ok";
      foreach ($columnList as $column_name) {
        // Check if the current table name matches the submitted value
        $selected = '';
        if (isset($_POST['columnSelectList']) && $_POST['columnSelectList'] == $column_name) {
          $selected = 'selected="selected"';
        }
        echo "<option value=\"$column_name\" $selected>$column_name</option>";
      }
      ?>
    </select>
    <!-- <input type="submit" value="Submit"> -->
    <!-- <button type="submit" id="submitBtn2" style="display: none;"></button> -->
  </form>
  <form action="process_form.php" method="post">
    <label for="datetime">From:</label>
    <input type="datetime-local" id="datetime1" name="datetime">
    <!-- <button type="submit">Submit</button> -->
    <!-- <button type="submit" id="submitBtn" style="display: none;"></button> -->
  </form>
  <form action="process_form.php" method="post">
    <label for="datetime">To:</label>
    <input type="datetime-local" id="datetime2" name="datetime">
    <!-- <button type="submit">Submit</button> -->
    <!-- <button type="submit" id="submitBtn" style="display: none;"></button> -->
  </form>

</div>

<script>
  function attachChangeEvent(selectId, submitBtnId) {
    const selectElement = document.getElementById(selectId);
    const submitButton = document.getElementById(submitBtnId);

    selectElement.addEventListener('change', function() {
      submitButton.click();
    });
  }
  attachChangeEvent('tableSelectList', 'submitBtn1');
  attachChangeEvent('columnSelectList', 'submitBtn2');

  // Add event listeners
  // for datetime inputs
  // document.getElementById('datetime1').addEventListener('change', function() {
  //   this.form.submit();
  // });
  // document.getElementById('datetime2').addEventListener('change', function() {
  //   this.form.submit();
  // });
</script>

<?php

// if (isset($_POST['tableSelectList'])) {

//   $tbl = $_POST['tableSelectList'];

include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');
?>