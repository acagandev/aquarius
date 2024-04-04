<!-- To be replaced by another functionality -->
<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/dbHandler.class.php');
class DataTransfer extends DbHandler
{
  private $dataTable;
  private $parameter;
  private $value1;
  private $value2;

  public function __construct($dataTable = null, $parameter = null, $value1 = null, $value2 = null)
  {
    $this->dataTable = $dataTable;
    $this->$parameter = $parameter;
    $this->value1 = $value1;
    $this->value2 = $value2;
  }

  // http://localhost/aquarius/dataTransfer.php?dataTable=temperature&value1=tempWater&value2=24.4

  public function uploadDataDB()
  {
    $stmt = $this->connectPD()->prepare('DESCRIBE ' . $this->dataTable . ';');

    if (!$stmt->execute()) {
      $stmt = null;
      header("Location: /dataTransfer.php?error=projectNotFound");
      exit();
    }

    // $query = 'INSERT INTO ' . $this->dataTable . ' (' . $this->value1 . ') VALUES (' . $this->value2 . ');';
    // print_r($query);

    // $stmt = $this->connectPD()->prepare($query);
    $stmt = $this->connectPD()->prepare('INSERT INTO ' . $this->dataTable . ' (' . $this->value1 . ') VALUES (' . $this->value2 . ');');

    if (!$stmt->execute()) {
      $stmt = null;
      header("Location: /dataTransfer.php?error=stmtfailed");
      exit();
    }

    $stmt = null;

    header("Location: /dataTransfer.php?error=dataUploadOK");
    exit();
  }

  private function jsonReplaceData($jsonKey, $newData, $fileName)
  {
    $filePath = ($_SERVER['DOCUMENT_ROOT'] . '/json/' . $fileName . '.json');

    $jsonString = file_get_contents($filePath);
    $data = json_decode($jsonString, true);
    $data[$jsonKey] = $newData;
    $newJsonString = json_encode($data);

    file_put_contents($filePath, $newJsonString);
  }

  public function downloadDataDB($parameter)
  {
    $jsonKey = 'graph_data';
    $jsonFileName = 'graph.data';
    $xData = [];
    $yData = [];

    $stmt = $this->connectPD()->prepare('SELECT * FROM ' . $this->dataTable . ' WHERE measured >= :value1 AND measured <= :value2');
    $stmt->bindParam(':value1', $this->value1);
    $stmt->bindParam(':value2', $this->value2);
    if ($stmt->execute()) {

      if ($stmt->rowCount() > 0) { // Maybe 1 due to jpgraph unable to work with 1 value
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $xValue = $row['measured'];
          $yValue = $row[$parameter];
          $xData[] = $xValue;
          $yData[] = $yValue;
          $plotData = array(
            'x_array' => $xData,
            'y_array' => $yData
          );

          $this->jsonReplaceData($jsonKey, $plotData, $jsonFileName);

          header("location: /profile/viewData.prf.php?result=dataReceived");
        }
      } else {
        header("location: /profile/viewData.prf.php?result=dataEmpty");
      }
    } else {
      header("location: /profile/viewData.prf.php?error=stmtFailed");
    }
  }

  public function getTableNames()
  {
    $jsonKey = 'table_names';
    $jsonFileName = 'graph.data';

    $stmt = $this->connectPD()->prepare('SHOW TABLES');

    if ($stmt->execute()) {

      $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $tableNames = [];
      foreach ($tables as $table) {
        $tableNames[] = reset($table);
      }

      $this->jsonReplaceData($jsonKey, $tableNames, $jsonFileName);
    } else {
      header("location: /profile/viewData.prf.php?error=stmtFailed");
    }
  }

  public function getColumnNames($tableName)
  {
    $jsonKey = 'column_names';
    $jsonFileName = 'graph.data';

    $stmt = $this->connectPD()->prepare("DESCRIBE $tableName");

    if ($stmt->execute()) {

      $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

      $columnNames = [];
      foreach ($columns as $column) {
        if ($column != "id" and $column != "measured") {
          $columnNames[] = $column;
        }
      }

      $this->jsonReplaceData($jsonKey, $columnNames, $jsonFileName);
    } else {
      header("location: /profile/viewData.prf.php?error=stmtFailed");
    }
  }
}