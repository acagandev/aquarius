<?php
ob_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/downloadDataDB.inc.php');

$showTables = new DataTransfer();
$showColumns = new DataTransfer();
$showTables->getTablesDB();

$jsonDataString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/json/plot.data.json');
$data = json_decode($jsonDataString, true);
$tableList = $data['table_names'];
$columnList = $data['column_names'];
ob_end_flush();
?>

<!DOCTYPE html>
<div>
  <form id="tableSelectForm" action="" method="post">
    <div>
      <label for="tableList">Choose table:</label>
      <select name="tableSelectList" id="tableSelectList">
        <option value="" disabled selected>Select an option</option>

        <?php
        if (isset($_POST['tableSelectList'])) {

          $tbl = $_POST['tableSelectList'];
          $showColumns->getRowsInTable($tbl);
          $jsonDataString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/json/plot.data.json');
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
      <button type="submit" id="submitBtn1" style="display: none;"></button>
  </form>
</div>
<div>
  <form id="columnSelectForm" action="/includes/plotData.inc.php" method="post" onsubmit="return validateForm()">
    <label for="columnList">Choose parameter:</label>
    <select name="columnSelectList" id="columnSelectList">
      <option value="" disabled selected>Select an option</option>

      <?php
      foreach ($columnList as $column_name) {
        $selected = '';
        if (isset($_POST['columnSelectList']) && $_POST['columnSelectList'] == $column_name) {
          $selected = 'selected="selected"';
        }
        echo "<option value=\"$column_name\" $selected>$column_name</option>";
      }
      ?>

    </select>
</div>
<button type="submit" id="submitBtn1" style="display: none;"></button>
<div>
  <label for="datetime">From:</label>
  <input type="datetime-local" id="startDate" name="startDate">
  <label for="datetime">To:</label>
  <input type="datetime-local" id="stopDate" name="stopDate" value="<?php ob_start();
                                                                    echo date('Y-m-d\TH:i');
                                                                    ob_end_flush(); ?>">
</div>
<div>
  <input type="hidden" name="selectedTable" value="<?php ob_start();
                                                    echo $tbl;
                                                    ob_flush() ?>">
  <button type="submit" name="submit">Plot</button>
</div>
</form>
</div>

<!-- Disable default option "Select an option" -->
<script>
  function removeDefaultOption() {
    var defaultOption = document.querySelector('#columnSelectList option[value=""]');
    defaultOption.remove();
  }
</script>

<!-- Automatically submit first form -->
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
</script>

<!-- Prevent form from being submitted before all selections are made -->
<script>
  function validateForm() {
    var tableSelectedList = document.getElementById('tableSelectList');
    var columnSelectList = document.getElementById('columnSelectList');
    var startDate = document.getElementById('startDate');
    var stopDate = document.getElementById('stopDate');

    if (tableSelectList.value === '' ||
      tableSelectList.value === 'Select an option' ||
      columnSelectList.value === '' ||
      columnSelectList.value === 'Select an option' ||
      startDate.value === '' ||
      stopDate.value === '') {
      alert('Please fill out all required fields.');
      return false;
    }
    return true;
  }
</script>


<?php

if (isset($_GET["result"])) {
  if ($_GET["result"] == "dataEmpty") {
    echo "<p>There are no data in defined date range.</p>";
  } elseif ($_GET["result"] == "dataReceived") {
    echo "<p>Generating plot...</p>";
    include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/generateGraph.inc.php');
  } elseif ($_GET["result"] == "stmtFailed") {
    echo "<p>Database error.</p>";
  }
} elseif (isset($_GET["jpgraph"])) {
  if ($_GET["jpgraph"] == "graphGenerated") {

    // Display generated graph
    echo <<<HTML
<!DOCTYPE html>
    <div>
        <img src="/profile/graph.png" alt="PNG Image">
    </div>
</html>
HTML;
  }
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');

?>