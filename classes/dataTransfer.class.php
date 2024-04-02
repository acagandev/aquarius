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
    $jsonKey = 'plot_data';
    $jsonFileName = 'plot.data';

    $stmt = $this->connectPD()->prepare('SELECT * FROM ' . $this->dataTable . ' WHERE measured >= :value1 AND measured <= :value2');
    $stmt->bindParam(':value1', $this->value1);
    $stmt->bindParam(':value2', $this->value2);

    if ($stmt->execute()) {

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $x_value = $row['measured'];
        $y_value = $row[$parameter];
        $x_array[] = $x_value;
        $y_array[] = $y_value;
      }

      $plot_data = array(
        'x_array' => $x_array,
        'y_array' => $x_array
      );

      $this->jsonReplaceData($jsonKey, $plot_data, $jsonFileName);

      echo 'Data saved to file successfully.';
    } else {
      // Handle statement execution error
    }
  }

  public function getTablesDB()
  {
    $jsonKey = 'table_names';
    $jsonFileName = 'plot.data';

    $stmt = $this->connectPD()->prepare('SHOW TABLES');

    if ($stmt->execute()) {

      $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $table_names = [];
      foreach ($tables as $table) {
        $table_names[] = reset($table);
      }

      $this->jsonReplaceData($jsonKey, $table_names, $jsonFileName);
    } else {
      $errorInfo = $stmt->errorInfo();
      echo "Error: " . $errorInfo[2];
    }
  }

  public function getRowsInTable($table_name)
  {
    $jsonKey = 'column_names';
    $jsonFileName = 'plot.data';

    $stmt = $this->connectPD()->prepare("DESCRIBE $table_name");

    if ($stmt->execute()) {

      $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);

      $row_names = [];
      foreach ($rows as $row) {
        if ($row != "id" and $row != "measured") {
          $row_names[] = $row;
        }
      }

      $this->jsonReplaceData($jsonKey, $row_names, $jsonFileName);
    } else {
      $errorInfo = $stmt->errorInfo();
      echo "Error: " . $errorInfo[2];
    }
  }
}
