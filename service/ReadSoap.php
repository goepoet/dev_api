
<?php
/*$url = "http://data.bmkg.go.id/propinsi_13_2.xml"; // from http://data.bmkg.go.id/ sesuaikan dengan lokasi yang diinginkan
$sUrl = file_get_contents($url, False);
$xml = simplexml_load_string($sUrl);
$tgl=$xml->Tanggal;

for ($i=0; $i<sizeof($xml->Isi->Row); $i++) {
    $row = $xml->Isi->Row[$i];
    if(strtolower($row->Kota) == "bogor") {// blitar merupakan contoh kota yang diambil data cuacanya dari bmkg
        echo "<b>" . strtoupper($row->Kota) . "</b><br/>";
        echo "<img src='http://www.bmkg.go.id/ImagesStatus/" . $row->Cuaca . ".gif' alt='" . $row->Cuaca . "'><br/>";
		echo "Cuaca : " . $row->Cuaca . "<br/>";
        echo "Suhu : " . $row->SuhuMin . " - ".$row->SuhuMax . " &deg;C<br/>";
        echo "Kelembapan : " . $row->KelembapanMin . " - " . $row->KelembapanMax . " %<br/>";
		echo "Kecepatan Angin : " . $row->KecepatanAngin . " (km/jam)<br/>";
		echo "Arah Angin : " . $row->ArahAngin . "<br/>";
		echo "Arah Angin : " . $row->Lintang . "<br/>";
        break;
    }
}
echo $tgl->Mulai;*/
    
/*
    $id=$_REQUEST['id'];
    if($id=='')
    {
        echo "gagal";
    }else
    {


    $client=new SoapClient("http://192.168.0.205/shieldservice/service/casandra_service.asmx?WSDL");
    $result=$client->Register(array('id'=>$id));
    $result->RegisterResult->RegisterResult;
    
    $hasil=$result->RegisterResult;

    echo "<br>".$hasil;
    }*/
    include 'MainFrame.php';
    $Cass_survey_request = new Cass_survey_request;
    $isinya = array(
        'user_id'=>$user_id);
    $simpan=$Cass_survey_request->simpan($isinya);
                    
                    echo ($simpan);
?>



