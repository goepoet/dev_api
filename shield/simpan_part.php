<?php
include '../service/MainFrame.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

$data=json_decode(file_get_contents("php://input"));
$claimno=$data->claimno;
$item=$data->item;
$category=$data->category;
$descripton=$data->desc;
$estimate=$data->estimate;
$payment=$data->ws_id;
$shield =new shield;	
if ($estimate==''){
	$estimate=0;
}

$shield->select_tr_ws_registration("where CLAIM_NO='$claimno'");
$tampil_reg=$shield->tampil();
$regid=$tampil_reg["REG_ID"];

$shield->select_loss_item("where REG_ID='$regid' order by SEQ desc");
$tampil_loss=$shield->tampil();
$SEQ=$tampil_loss["SEQ"] + 1;

$isinya = array(
	'REG_ID'=>$regid,'SEQ'=>$SEQ,'ITEM'=>$item,'CATEGORY'=>$category,'DESCRIPTION'=>$descripton,'QTY'=>"1",'ESTIMATE'=>$estimate,'ACC_ESTIMATE'=>"0",'DISCOUNT'=>"0",'VAT'=>"0",'TAX'=>"0",'AMOUNT'=>$estimate,'STATUS_ITEM'=>"0",'PAYMENT'=>$payment,'FLAG_ITEM'=>"1",'AFTER_DISC'=>"0");


if($item==''){
	$query="0";
	$msg="Silahkan pilih dahulu partnya";
}elseif ($descripton=='') {
	$query="0";
	$msg="Nama Part tidak boleh kosong";
}elseif($category==''){
	$query="0";
	$msg="Silahkan dipilih dahulu Status Partnya";
}elseif($estimate==''){
	$query="0";
	$msg="Silahkan masukan Nilai estimasi anda";
}else{
	if($item){
		$query=$shield->simpan_loss_item($isinya);
		if($query==1){
			$msg="data behasil disimpann";
		}else{
			$msg="data gagal disimpan";
		}
	}
}
// if($remarks !=''){
// 	$query=$colection->simpan_loss_item($isinya);	
// 	$Cout3 = $query;
// 	if($query=='0')
// 	{
// 		$Cout4 = "Data gagal di simpan";				
// 	}else
// 	{
// 		$Cout4 = "Data berhasil disimpan";
// 		$ubahan = array('status' =>$status);
// 		if($status != 4){
// 			$colection->ubah_followup($ubahan,"where id='$fu_number'");			
// 		}	
// 	}			

// }else{

// 	$Cout4 = "Silahkan Masukan Remarksnya";
// 	$Cout3 = "0";
// }	
$Cout='{"status":"'.$query.'","msg":"'.$msg.'"}';
echo $Cout;


?>
