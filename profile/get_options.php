<?php
// get_options.php
echo "First field was selected.";
// Retrieve the selected option from the AJAX request
$selectedOption = isset($_POST['selectedOption']) ? $_POST['selectedOption'] : '';
echo $selectedOption;
// Process the selected option and generate options for the second select field
if (!empty($selectedOption)) {
  echo $selectedOption;
  // Retrieve column list based on the selected table
  $showColumns->getRowsInTable($selectedOption);
  $jsonDataString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/json/profile.data.json');
  $data = json_decode($jsonDataString, true);
  $columnList = $data['column_names'];

  // Generate HTML options for the second select field
  $options = '';
  foreach ($columnList as $column_name) {
    $options .= "<option value=\"$column_name\">$column_name</option>";
  }

  // Return the generated options as a response
  echo $options;
}
