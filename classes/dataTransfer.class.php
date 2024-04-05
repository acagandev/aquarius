<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/dbHandler.class.php');
class DataTransfer extends DbHandler
{
  private $dataTable;
  private $value1;
  private $value2;
  private $value3;

  public function __construct($dataTable = null, $value1 = null, $value2 = null, $value3 = null)
  {
    $this->dataTable = $dataTable;
    $this->value1 = $value1;
    $this->value2 = $value2;
    $this->value3 = $value3;
  }

  public function uploadDataDB()
  {
    $stmt = $this->connectPD()->prepare('DESCRIBE ' . $this->dataTable . ';');

    if (!$stmt->execute()) {
      $stmt = null;
      header("Location: /dataTransfer.php?error=tableNotFound");
      exit();
    }

    $columnString = implode(", ", $this->value1);
    $valuePlaceholders = implode(", ", array_fill(0, count($this->value2), '?'));

    $sql = 'INSERT INTO ' . $this->dataTable . ' (' . $columnString . ') VALUES (' . $valuePlaceholders . ')';

    $stmt = $this->connectPD()->prepare($sql);

    $i = 1;
    foreach ($this->value2 as $value) {
      $stmt->bindValue($i++, $value);
    }

    if (!$stmt->execute()) {
      $stmt = null;
      header("Location: /dataTransfer.php?error=stmtFailed");
      exit();
    }

    $stmt = null;

    header("Location: /dataTransfer.php?error=none");
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

  public function downloadDataDB($value1)
  {
    $jsonKey = 'graph_data';
    $jsonFileName = 'graph.data';
    $xData = [];
    $yData = [];

    $stmt = $this->connectPD()->prepare('SELECT * FROM ' . $this->dataTable . ' WHERE measured >= :startDate AND measured <= :stopDate');
    $stmt->bindParam(':startDate', $this->value2);
    $stmt->bindParam(':stopDate', $this->value3);
    if ($stmt->execute()) {

      if ($stmt->rowCount() > 0) { // Maybe 1 due to jpgraph unable to work with 1 value
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $xValue = $row['measured'];
          $yValue = $row[$value1];
          $xData[] = $xValue;
          $yData[] = $yValue;
          $plotData = array(
            'x_array' => $xData,
            'y_array' => $yData
          );

          $this->jsonReplaceData($jsonKey, $plotData, $jsonFileName);
          $stmt = null;
          header("location: /profile/viewData.prf.php?result=dataReceived");
        }
      } else {
        $stmt = null;
        header("location: /profile/viewData.prf.php?result=dataEmpty");
      }
    } else {
      $stmt = null;
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
      $stmt = null;
    } else {
      $stmt = null;
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
      $stmt = null;
    } else {
      $stmt = null;
      header("location: /profile/viewData.prf.php?error=stmtFailed");
    }
  }
}