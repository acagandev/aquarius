<?php
ob_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/dbHandler.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/dataTransfer.class.php');

?>

<!DOCTYPE html>
<div>
  <form id="tableSelectForm" action="" method="post">
    <div>
      <label for="tableList">Set tempWater:</label>
      <select name="tableSelectList" id="tableSelectList">
        <option value="" disabled selected>Select an option</option>

        <?php
        if (isset($_POST['tableSelectList'])) {

          // $tbl = $_POST['tableSelectList'];
          // $showColumns->getColumnNames($tbl);
          // $jsonDataString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/json/graph.data.json');
          // $jsonData = json_decode($jsonDataString, true);
          // $columnList = $jsonData['column_names'];
        }

        foreach ($tableList as $tableName) {
          $selected = '';
          if (isset($_POST['tableSelectList']) && $_POST['tableSelectList'] == $tableName) {
            $selected = 'selected="selected"';
          }
          echo "<option value=\"$tableName\" $selected>$tableName</option>";
        }
        ?>

      </select>
    </div>
    <div>
      <label for="time">Select lighting time from:</label>
      <input type="time" id="startDate" name="startDate">
      <label for="time">To:</label>
      <input type="time" id="stopDate" name="stopDate" value="<?php echo date('Y-m-d\TH:i'); ?>">
    </div>
    <div>
      <input type="hidden" name="selectedTable" value="<?php echo $tbl; ?>">
      <button type="submit" name="submit">Set</button>
    </div>
  </form>
</div>
<button type="submit" id="submitBtn1" style="display: none;"></button>
</form>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');
ob_flush();
