<?php
set_time_limit(30000);
$stepStart = 0;
$stepStop = 100;



echo "<pre>";
for($i=$stepStart;$i<=$stepStop;$i++){
  file_put_contents('_reestr_' . $i . '.json', getReestr($i));
  echo $i . PHP_EOL;
}


function getReestr($nomer){
  // https://lk.rosreestr.ru/#/services/_5_7
  // https://lk.rosreestr.ru/#/gov_sevice_sfn/394992d0-6514-4fc1-9df4-24fdd0812ed9
  $data = array(
    "filterType"=>"address",
    "start"=>0,
    "size"=>200,
    "address" => array(
        "regionCode"=>"21",
        "district"=>null,
        "city"=>"CITY",
        "cityType"=>"г",
        "street"=>"STREET",
        "streetType"=>"ул",
        "house"=>"1",
        "building"=>null,
        "structure"=>null,
        "apartment"=>"$nomer",
        "aoguid"=>"XXXXXX-XXXX-XXXX-XXXX-XXXXXXXXX"
      ),
    "objTypes"=>[""]
  );
  $data_string = json_encode ($data, JSON_UNESCAPED_UNICODE);

  $ch = curl_init();
  $curl_opt_array = array(
    CURLOPT_URL => 'https://lk.rosreestr.ru/account-back/on/',
    CURLOPT_POSTFIELDS => $data_string,
    CURLOPT_HTTPHEADER => array(
     'Content-Type: application/json',
     'Content-Length: ' . strlen($data_string)),
    CURLOPT_POST => true,
    CURLOPT_TIMEOUT => 4000,
  //  CURLOPT_HEADER => true,
    CURLOPT_RETURNTRANSFER => true
  );
  curl_setopt_array($ch, $curl_opt_array);
  $html = curl_exec($ch);
  
  $json = json_decode($html);

  return $html;
}
echo "</pre>";

exit;

