<?php

set_time_limit(30000);
$files = glob("reestr/*.json");
echo "<pre>";

$csv = [];
foreach ($files as $file) {
  $fileContent = file_get_contents($file);
  $json = json_decode($fileContent, TRUE);
  if($json['count'] > 0){
    foreach ($json['elements'] as $element) {
      if(!isset($element['rights'])){
        $csv[] = array(
          'part' => '-',
          'rightNumber' => '-',
          'rightRegDate' => '-',
          'rightTypeDesc' => '-',
          'area' => $element['area'],
          'apartmentType' => $element['address']['apartmentType'],
          'apartment' => $element['address']['apartment'],
          'levelFloor' => $element['levelFloor'],
          'cadNumber' => $element['cadNumber'],
          'readableAddress' => $element['address']['readableAddress']
        );
      } else {
        foreach ($element['rights'] as $right) {
          $csv[] = array(
            'part' => $right['part'],
            'rightNumber' => $right['rightNumber'],
            'rightRegDate' => gmdate("d-m-Y", $right['rightRegDate']/ 1000),
            'rightTypeDesc' => $right['rightTypeDesc'],
            'area' => $element['area'],
            'apartmentType' => $element['address']['apartmentType'],
            'apartment' => $element['address']['apartment'],
            'levelFloor' => $element['levelFloor'],
            'cadNumber' => $element['cadNumber'],
            'readableAddress' => $element['address']['readableAddress']
          );
        }
      }

    }

  }
}
echo "</pre>";
export_to_csv($csv);
function export_to_csv($csv){
  $fname = 'reest.csv';
  $fp = fopen($fname, 'w');
  fputcsv($fp, array(
    'apartment',
    'apartmentType',
    'area',
    'part',
    'rightNumber',
    'rightRegDate',
    'rightTypeDesc',
    'levelFloor',
    'cadNumber',
    'readableAddress'
  ), ";", '"');
  foreach ($csv as $item){
    fputcsv($fp, array(
      $item['apartment'],
      $item['apartmentType'],
      $item['area'],
      $item['part'],
      $item['rightNumber'],
      $item['rightRegDate'],
      $item['rightTypeDesc'],
      $item['levelFloor'],
      $item['cadNumber'],
      $item['readableAddress']
    ), ";", '"');

  }
  fclose($fp);
}