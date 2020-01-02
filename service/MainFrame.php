<?php
include 'MainClass.php';
date_default_timezone_set("Asia/Jakarta");
class Sms extends panfic
{
	function sendSms ($nomor,$pesan)
	{
		$this->conInfo();
		$this->query("exec SendSms '$nomor','$pesan','response','a','123','1'");
		
	}
}
/**
 * buat test azure kalo udah kelar di hapus aja
 */
class azure extends panfic
{	
	function select($wherenya)
	{
		$this->conAzure();
		$query=$this->query("select top 300 * from Profile $wherenya ");
		if($query)
		{				 
			$pesan="1";
		}else
		{				 
			$pesan="0";
		}			
		return $pesan;
	}
}
/**
 * class punya BCAF
 */
class bcaf extends panfic
{
	
	function simpan($datanya)
	{
		$this->conInfo();

		$query=$this->insert("prj_bcaf",$datanya);
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";
		}
	
		return $pesan;
	}
}

/**
 * claass buat DTTOT
 */
class dttot extends panfic
{	
	function select($wherenya)
	{
		$this->conInfo();
		$query=$this->query("select * from mst_dttot $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
}
/**
 * proses ni untuk shield
 */
class shield extends panfic
{	
	function list_claim_workshop($wherenya)
	{
		$this->conInfo();
		$query=$this->query("select ROW_NUMBER() OVER(order by survey_id) AS Row,CONVERT(VARCHAR(11),submit_date,106) as submit_date, * 
from tr_ws_in_claim a inner join MST_MENU_PRIVILEDGE b on a.ESTIMATOR=b.ID $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}

	function list_payment_workshop($wherenya){
		$this->conInfo();
		$query=$this->query("select * from TR_WS_HISTORY_PEMBAYARAN $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function list_in_workshop($wherenya){
		$this->conInfo();
		$query=$this->query("select * from TR_WS_IN_CLAIM A inner join TR_WS_REGISTRATION B on A.CLAIM_NO=B.CLAIM_NO $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function get_user_priviledge($wherenya){
		$this->conInfo();
		$query=$this->query("select * from MST_MENU_PRIVILEDGE $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function get_user_care($wherenya){
		$this->conInfo();
		$query=$this->query("SET ANSI_NULLS ON");
		$query=$this->query("SET ANSI_WARNINGS ON");
		$query=$this->query("select * from care.sea_panpacific.dbo.SysUser $wherenya"); 
		// $this->conCare200();
		// $query=$this->query("select * from ACCEPTANCE $wherenya	");// ini untuk testing
			if($query)
			{				 
				$pesan="1";
			}else
			{				 
				$pesan="0";
			}				
			return $pesan;
	}
	function get_ct_care($wherenya){
		$this->conCare2();
		$query=$this->query("select * from CT $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function select_mst_history_claim($wherenya){
		$this->conInfo();
		$query=$this->query("select * from mst_history_claim $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function select_history_claim($wherenya){
		$this->conInfo();
		$query=$this->query("select * from tr_history_claim $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function simpan_history_claim($datanya){
		$this->conInfo();
		$query=$this->insert("tr_history_claim",$datanya);
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";
		}	
		return $pesan;
	}
	function update_ref_claim($data,$wherenya){
		$this->conInfo();
		$query=$this->query("SET ANSI_NULLS ON");
		$query=$this->query("SET ANSI_WARNINGS ON");
		//$query=$this->query("select * from care.sea_panpacific.dbo.acceptance $wherenya	");
		$query=$this->update("care.sea_panpacific.dbo.CLAIM",$data,$wherenya);//care2 pas masuk ke server azure
		// $this->conCare200();
		// $query=$this->query("select * from ACCEPTANCE $wherenya	");// ini untuk testing
			if($query)
			{				 
				$pesan="1";
			}else
			{				 
				$pesan="0";
			}				
			return $pesan;
	}
	function simpan_loss_item($datanya){
		$this->conInfo();
		$query=$this->insert("TR_WS_LOSS_ITEM",$datanya);
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";
		}	
		return $pesan;
	}
	function select_loss_item($wherenya){
		$this->conInfo();
		$query=$this->query("select * from TR_WS_LOSS_ITEM $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function select_tr_ws_registration($wherenya){
		$this->conInfo();
		$query=$this->query("select * from TR_WS_REGISTRATION $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function ubah_claim_status($data,$wherenya)
	{
		$this->conInfo();			
			$query=$this->update("TR_WS_IN_CLAIM",$data,$wherenya);
			if($query)
			{				 
				$pesan="1";
			}else
			{				 
				$pesan="0";
			}				
			return $pesan;
	}
	function ws_claim($wherenya)
	{
		$this->conInfo();
		$query=$this->query("select B.nama_bengkel from TR_WS_REGISTRATION A inner join MST_BENGKEL B on A.WORKSHOP=B.ID $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function list_bucket($branch)
	{
		$this->conInfo();
		$query=$this->query("select d.calls_id,d.tanggal,b.branch,d.names,a.reg_id,survey_id,convert(varchar(10),survey_date,101) as survey_date,
			a.policyno, claimno,address,city,province,a.remarks,a.status,a.surveyor,b.name 
			from TR_SURVEY_LOG a join MST_MENU_PRIVILEDGE b on a.cs=b.ID join 
			(select distinct reg_id,calls_id,no_claim from FU_Activity) c on a.CLAIMNO=c.no_claim  join calls_log d 
			on c.calls_id=d.calls_id where a.surveyor ='' and (a.status<>'2'and a.status<>'3'and a.status<>'5' ) 
			and b.branch='$branch' and CLAIMNO <>'' order by a.STATUS asc,a.survey_date desc
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function list_open_lock($claimno)
	{
		$this->conInfo();
		$query=$this->query("select d.calls_id,d.tanggal,b.branch,d.names,a.reg_id,survey_id,convert(varchar(10),survey_date,101) as survey_date,
			a.policyno, claimno,address,city,province,a.remarks,a.status,a.surveyor,b.name 
			from TR_SURVEY_LOG a join MST_MENU_PRIVILEDGE b on a.cs=b.ID join 
			(select distinct reg_id,calls_id,no_claim from FU_Activity) c on a.CLAIMNO=c.no_claim  join calls_log d 
			on c.calls_id=d.calls_id where CLAIMNO in('$claimno') and CLAIMNO <>'' and a.STATUS < 7 and YEAR(d.tanggal)>2017 order by a.STATUS asc,a.survey_date desc
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
function ubah_mst_bengkel($data,$wherenya)
	{
		$this->conInfo();			
			$query=$this->update("MST_BENGKEL",$data,$wherenya);
			if($query)
			{				 
				$pesan="1";
			}else
			{				 
				$pesan="0";
			}				
			return $pesan;
	}
	function ubah_tr_ws_registration($data,$wherenya)
	{
		$this->conInfo();			
			$query=$this->update("TR_WS_REGISTRATION",$data,$wherenya);
			if($query)
			{				 
				$pesan="1";
			}else
			{				 
				$pesan="0";
			}				
			return $pesan;
	}

}
/**
 * data ini berikisikan fungsi untuk API dari kemenag untuk bisnis syariah
 */
class syariah extends panfic
{
	
	function simpan($datanya)
	{
		$this->conInfo();

		$query=$this->insert("prj_kemenag_data_peserta",$datanya);
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";
		}
	
		return $pesan;
	}
	function select($wherenya)
	{
		 $this->conInfo();
		$query=$this->query("
			select * from prj_kemenag_data_peserta $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function ubah($data,$wherenya)
	{
		$this->conInfo();
			
			$query=$this->update("prj_kemenag_data_peserta",$data,$wherenya);
			if($query)
			{				 
				$pesan="1";
			}else
			{				 
				$pesan="0";
			}				
			return $pesan;
	}

	function simpan_ppiu($datanya)
	{
		$this->conInfo();

		$query=$this->insert("prj_kemenag_list_ppiu",$datanya);
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";
		}
	
		return $pesan;
	}
	function select_ppiu($wherenya)
	{
		 $this->conInfo();
		$query=$this->query("
			select * from prj_kemenag_list_ppiu $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function ubah_ppiu($data,$wherenya)
	{
		$this->conInfo();
			
			$query=$this->update("prj_kemenag_list_ppiu",$data,$wherenya);
			if($query)
			{				 
				$pesan="1";
			}else
			{				 
				$pesan="0";
			}				
			return $pesan;
	}

	function simpan_bank($datanya)
	{
		$this->conInfo();

		$query=$this->insert("prj_kemenag_list_bank",$datanya);
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";
		}
	
		return $pesan;
	}
	function select_bank($wherenya)
	{
		 $this->conInfo();
		$query=$this->query("
			select * from prj_kemenag_list_bank $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function ubah_bank($data,$wherenya)
	{
		$this->conInfo();
			
			$query=$this->update("prj_kemenag_list_bank",$data,$wherenya);
			if($query)
			{				 
				$pesan="1";
			}else
			{				 
				$pesan="0";
			}				
			return $pesan;
	}
	function get_nopol_syariah($wherenya){
		$this->conInfo();
		$query=$this->query("SET ANSI_NULLS ON");
		$query=$this->query("SET ANSI_WARNINGS ON");
		$query=$this->query("select * from care.sea_panpacific.dbo.acceptance $wherenya	"); // kalo udah live pake yang ini ngandalin link server
		
		// $this->conCare200();
		// $query=$this->query("select * from ACCEPTANCE $wherenya	");// ini untuk testing
			if($query)
			{				 
				$pesan="1";
			}else
			{				 
				$pesan="0";
			}				
			return $pesan;
	}

}
/**
 * data untuk api ke colection
 */
class colection extends panfic
{
	
	function select ($wherenya)
	{
		$this->conInfo();
		$query=$this->query("
			DECLARE @PageSize float,
        @Page INT
SELECT  @PageSize = 1000000,
        @Page = 1;        
WITH result_set AS (	 
  SELECT
    ROW_NUMBER() OVER (order by policy_no,type asc) AS [row_number],*
  FROM collecsy_register WHERE $wherenya) SELECT  * FROM  result_set WHERE   [row_number] BETWEEN((@Page - 1) * @PageSize + 1) AND (@Page * @PageSize) order by [row_number]

			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function select_max(){

		$this->conInfo();
		$query=$this->query("
			select MAX(DataAsAt) as DataAsAt  from collecsy_register
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function select_ct($wherenya){
		$this->conCare2();
		$query=$this->query("
			select * from CT where $wherenya 
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function select_lob($wherenya){
		$this->conCare2();
		$query=$this->query("
			select * from LOB $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function select_type()
	{		   
		   $this->conInfo();
		$query=$this->query("
			select * from collecsy_type_list
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function select_tipe_polis()
	{		   
		   $this->conInfo();
		$query=$this->query("
			select * from collecsy_tipe_polis
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function select_followup($wherenya)
	{		   
		   $this->conInfo();
		$query=$this->query("
			select * from collecsy_followup where $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function jumlah_followup($wherenya)
	{		   
		   $this->conInfo();
		$query=$this->query("
			select count(*) as total from collecsy_followup $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function select_followup_detail($wherenya)
	{		   
		   $this->conInfo();
		$query=$this->query("
			select * from collecsy_followup_detail where $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function simpan_followup($datanya)
	{
		$this->conInfo();

		$query=$this->insert("collecsy_followup",$datanya);
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";
		}
	
		return $pesan;
	}
	function ubah_followup($data,$wherenya)
	{
		$this->conInfo();
			
			$query=$this->update("collecsy_followup",$data,$wherenya);
			if($query)
			{
				 
				$pesan="1";
			}else
			{
				 
				$pesan="0";
			}
				
			return $pesan;
		}
	function select_total_followup($wherenya)
	{		   
		   $this->conInfo();
		$query=$this->query("
			select COUNT(*) as total from collecsy_detail_voucher where followup_id in (select id from collecsy_followup $wherenya)
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}	
	function simpan_followup_detail($datanya)
	{
		$this->conInfo();

		$query=$this->insert("collecsy_followup_detail",$datanya);
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";
		}
	
		return $pesan;
	}
	function ubah_followup_detail($data,$wherenya)
	{
		$this->conInfo();
			
			$query=$this->update("collecsy_followup_detail",$data,$wherenya);
			if($query)
			{
				 
				$pesan="1";
			}else
			{
				 
				$pesan="0";
			}
				
			return $pesan;
		}
	function simpan_log($datanya)
	{
		$this->conInfo();

		$query=$this->insert("collecsy_log",$datanya);
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";
		}
	
		return $pesan;
	}
	function select_log($wherenya)
	{		   
		   $this->conInfo();
		$query=$this->query("
			select top 1 * from collecsy_log where $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function select_jenis_polis($wherenya)
	{		   
		   $this->conInfo();
		$query=$this->query("
			select * from collecsy_jenis_polis $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function select_sum($wherenya)
	{		   
		   $this->conInfo();
		$query=$this->query("
			select  SUM(gross_premi) as total_premi,SUM(fee) as total_fee,SUM(komisi) as total_komisi,SUM(vat) as total_vat,SUM(tax) as total_tax,SUM(outstanding) as total_oustanding ,SUM(ujroh) as total_ujroh ,SUM(disc) as total_disc
			from collecsy_register $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function simpan_detail_voucher($datanya)
	{
		$this->conInfo();

		$query=$this->insert("collecsy_detail_voucher",$datanya);
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";
		}
	
		return $pesan;
	}
	function select_detail_voucher($wherenya)
	{		   
		   $this->conInfo();
		$query=$this->query("
			select * from collecsy_detail_voucher $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function hapus_detail_voucher($wherenya)
	{		   
		   $this->conInfo();
		$query=$this->query("
			delete from collecsy_detail_voucher $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function select_user_list($wherenya)
	{		   
		   $this->conInfo();
		$query=$this->query("
			select * from collecsy_user_list $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function simpan_reconcile($datanya)
	{
		$this->conInfo();

		$query=$this->insert("collecsy_reconcile",$datanya);
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";
		}
	
		return $pesan;
	}
	function ubah_reconcile($data,$wherenya)
	{
		$this->conInfo();
			
			$query=$this->update("collecsy_reconcile",$data,$wherenya);
			if($query)
			{
				 
				$pesan="1";
			}else
			{
				 
				$pesan="0";
			}
				
			return $pesan;
	}
	function select_reconcile($wherenya)
	{		   
		   $this->conInfo();
		$query=$this->query("
			select * from collecsy_reconcile where $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	function simpan_reconcile_detail($datanya)
	{
		$this->conInfo();

		$query=$this->insert("collecsy_reconcile_detail",$datanya);
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";
		}
	
		return $pesan;
	}
	function ubah_reconcile_detail($data,$wherenya)
	{
		$this->conInfo();
			
			$query=$this->update("collecsy_reconcile_detail",$data,$wherenya);
			if($query)
			{
				 
				$pesan="1";
			}else
			{
				 
				$pesan="0";
			}
				
			return $pesan;
	}
	function select_reconcile_detail($wherenya)
	{		   
		   $this->conInfo();
		$query=$this->query("
			select * from collecsy_reconcile_detail where $wherenya
			");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}

}
class MstPart extends panfic
{
	function select ($wherenya)
	{
		$this->conInfo();
		$query=$this->query("select distinct description,kol from mst_parts $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
}
class chatBot extends panfic{
	function simpan($datanya)
	{
		$this->conInfo();

		$query=$this->insert("line_chatbot",$datanya);
		if($query)
		{
				 //$pesan="User ID dan Password anda akan dikirimkan melalui SMS sesaat lagi";
			$pesan="1";
		}else
		{
				 //$pesan="Register data gagal";
			$pesan="0";
		}
		$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			//echo $Cout;
		return $pesan;
	}

	function cek_mobil ($wherenya){
		/*$this->conCare();
		$query=$this->query("select * from GENDTAB $wherenya");*/
		$this->conInfo();
		$query=$this->query("select * from line_chatbot_kendaraan $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;	
	}
	function cek_tahun ($wherenya){
		$this->conInfo();
		$query=$this->query("select * from line_chatbot_tahun $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;	
	}
	function cek_tpl ($wherenya){
		$this->conInfo();
		$query=$this->query("select * from line_chatbot_tpl $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;	
	}
	function cek_pad ($wherenya){
		$this->conInfo();
		$query=$this->query("select * from line_chatbot_pad $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;	
	}
	function cek_pap ($wherenya){
		$this->conInfo();
		$query=$this->query("select * from line_chatbot_pap $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;	
	}
	function cek_wilayah ($wherenya){
		$this->conInfo();
		$query=$this->query("select * from line_chatbot_wilayah $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;	
	}
	function cek_claim ($wherenya){
		$this->conInfo();
		$query=$this->query("select * from tr_history_claim $wherenya");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;	
	}
}
class MST_BENGKEL extends panfic
{
	function Select ($wherenya)
	{
		$this->conInfo();
		$query = $this->query("select * from mst_bengkel $wherenya");			
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";				
		}
		return $pesan;			
	}
	function insert()
	{
		$query= mssql_query("insert into about (judul,artikel,bahasa,visible)
			values('$judul','$artikel','$bahasa','$visible')");


		if($this->result = $query)
		{
			$message= "data anda berhasil di simpan";
		}else
		{
			$message= "data anda gagal di simpan";
		}
		$Cout='{"records":{"msg":"'.$message.'"}}';	
		echo $Cout;
	}
	function update($setnya,$wherenya)
	{
		$query= mssql_query("update about $setnya $wherenya");


		if($this->result = $query)
		{
			$message= "data anda berhasil di update";
		}else
		{
			$message= "data anda gagal di update";
		}
		$Cout='{"records":{"msg":"'.$message.'"}}';	
		echo $Cout;
	}

}
class Cass_MstUser extends panfic
{
	function select($cek)
	{
		$this->conInfo();
		$query=$this->query("select * from Cass_MstUser $cek");
		if($query)
		{
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;			
	}

	function login($user,$password)
	{
		$this->conInfo();
		$masuk = $this->query("select * from Cass_MstUser where mail='$user' and password='$password'");						
	}
	function login_polis($user,$password)
	{
		$this->conInfo();
		$masuk = $this->query("select * from Cass_MstUser where phone='$user' and password='$password'");						
	}
	function autonum()
	{
		$this->conInfo();
		$query=$this->query("select MAX (id) as nomor from Cass_MstUser");
		$pecah=$this->tampil();
		$nomor=strlen($pecah['nomor']+1);

		$bln=date("m");
		if($nomor > '2')
		{
			$nomor=substr($nomor,0-2);
		}
		$nomor=$bln.$nomor;
		return $nomor;
	}
	function register($datanya)
	{
		$this->conInfo();

		$query=$this->insert("Cass_MstUser",$datanya);
		if($query)
		{
				 //$pesan="User ID dan Password anda akan dikirimkan melalui SMS sesaat lagi";
			$pesan="1";
		}else
		{
				 //$pesan="Register data gagal";
			$pesan="0";
		}
		$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			//echo $Cout;
		return $pesan;
	}
	function ubahPass($newPass,$oldPass,$id)
	{
		$this->conInfo();
		$data = array(
			'password'=>$newPass
		);
		$query=$this->update("Cass_MstUser",$data,"where token_id='$id' and password='$oldPass'");
		if($query)
		{
				 //$pesan="Update Password sukses";
			$pesan="1";
		}else
		{
				 //$pesan="Update Password gagal";
			$pesan="0";
		}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
		return $pesan;
	}
	function ubahData($data,$wherenya)
	{
		$this->conInfo();
			/*$data = array(
				'password'=>$newPass
			);*/
			$query=$this->update("Cass_MstUser",$data,$wherenya);
			if($query)
			{
				 //$pesan="Update Password sukses";
				$pesan="1";
			}else
			{
				 //$pesan="Update Password gagal";
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}
		function ubahTokenID($newToken,$date,$mail,$password)
		{
			$this->conInfo();
			$data = array(
				'token_id'=>$newToken,
				'last_login'=>$date
			);
			$query=$this->update("Cass_MstUser",$data,"where mail='$mail' and password='$password'");
			if($query)
			{
				$pesan="Update Password sukses";
			}else
			{
				$pesan="Update Password gagal";
			}
			$Cout='{"data":[{"msg":"'.$pesan.'"}]}';	
			return $Cout;
		}
		function ubahTokenPolis($newToken,$date,$mail,$password)
		{
			$this->conInfo();
			$data = array(
				'token_id'=>$newToken,
				'last_login'=>$date
			);
			$query=$this->update("Cass_MstUser",$data,"where phone='$mail' and password='$password'");
			if($query)
			{
				$pesan="Update Password sukses";
			}else
			{
				$pesan="Update Password gagal";
			}
			$Cout='{"data":[{"msg":"'.$pesan.'"}]}';	
			return $Cout;
		}
		function logOut($data,$wherenya)
		{
			$this->conInfo();

			$query=$this->update("Cass_MstUser",$data,$wherenya);
			if($query)
			{
				 //$pesan="Anda telah keluar dari sistem Casandra";
				$pesan="1";
			}else
			{
				 //$pesan="Update Password gagal";
				$pesan="0";
			}
			$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}

	}
	class callsLog extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select top 100 * from calls_log $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
		function autonum()
		{
			$query=$this->query("select MAX (calls_id) as nomor from calls_log");
			$pecah=$this->tampil();
			$nomor=substr($pecah['nomor'],0-6);
			$jml=strlen($nomor+1);
			if($jml==1){$no='00000';}
			elseif($jml==2){$no='0000';}
			elseif($jml==3){$no='000';}
			elseif($jml==4){$no='00';}
			elseif($jml==5){$no='0';}
			elseif($jml==6){$no='';}
			$taun=date("y");
			$bln=date("m");
			$nilai= "CL".$taun.$bln.$no.($nomor+1);
			return $nilai;
		}
		function simpan($datanya)
		{
			$query=$this->insert("calls_log",$datanya);
			if($query)
			{
				$pesan="Simpan data sukses";
			}else
			{
				$pesan="Simpan data gagal";
			}
			$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			echo $Cout;
		}
	}
	class fu_activity extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select top 100 * from fu_activity $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
		function select_join_bengkel($wherenya)
		{
			$this->conInfo();

			$query=$this->query("select distinct CONVERT(varchar, workshop),B.nama_bengkel from fu_activity A  join  mst_bengkel B on CONVERT(varchar, A.workshop)=B.ID $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
		function autonum()
		{
			$query=$this->query("select MAX (reg_id) as nomor from fu_activity");
			$pecah=$this->tampil();
			$nomor=substr($pecah['nomor'],0-6);
			$jml=strlen($nomor+1);
			if($jml==1){$no='00000';}
			elseif($jml==2){$no='0000';}
			elseif($jml==3){$no='000';}
			elseif($jml==4){$no='00';}
			elseif($jml==5){$no='0';}
			elseif($jml==6){$no='';}
			$taun=date("y");
			$bln=date("m");
			$nilai= "FU".$taun.$bln.$no.($nomor+1);
			return $nilai;
		}
		function simpan($datanya)
		{
			$query=$this->insert("fu_activity",$datanya);
			if($query)
			{
				$pesan="Simpan data sukses";
			}else
			{
				$pesan="Simpan data gagal";
			}
			$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			echo $Cout;
		}
	}


	class tr_survey_log extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select top 100 * from TR_SURVEY_LOG $wherenya ");
			 if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}

		function get_query_care_claim($claimno)
		{
			$this->conCare();
			$query=$this->query("select top 1 cno from CARE.sea_panpacific.dbo.claim where claimno='$claimno'");//pake link server solnya koneksi ke data live ga bisa
            if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
		function get_query_care_clloss($cno,$refno)
		{
			$this->conInfo();
			$query=$this->query("select * from CARE.sea_panpacific.dbo.clloss where cno='$cno' and NOC='PR05' and RefNo='$refno'" );//pake link server solnya koneksi ke data live ga bisa
            if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
		function get_query_care_profile($id)
		{
			$this->conInfo();
			$query=$this->query("select * from CARE.sea_panpacific.dbo.profile where ID='$id'" );//pake link server solnya koneksi ke data live ga bisa
            if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}

		function query_care_profile($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from CARE.sea_panpacific.dbo.profile $wherenya" );//pake link server solnya koneksi ke data live ga bisa
            if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}

		function get_query_requestClaim_status($branch,$claimno)
		{
			$this->conInfo();
			$query=$this->query("select d.calls_id,d.tanggal,b.branch,d.names,a.reg_id,survey_id,convert(varchar(10),survey_date,101) as survey_date,a.policyno, claimno,address,city,province,a.remarks,a.status,a.surveyor,b.name,d.[from]   
            from TR_SURVEY_LOG a join MST_MENU_PRIVILEDGE b on a.cs=b.ID 
            join (select distinct reg_id,calls_id,no_claim,status from FU_Activity) c on a.CLAIMNO=c.no_claim  
            join calls_log d on c.calls_id=d.calls_id 
            where
            b.branch='$branch' and CLAIMNO <>'' and c.status<>'close' and YEAR(d.tanggal) > 2017 and CLAIMNO like'%$claimno%' order by d.tanggal desc ");
            if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;

		}

		function autonum()
		{
			$query=$this->query("select MAX (SURVEY_ID) as nomor from TR_SURVEY_LOG");
			$pecah=$this->tampil();
			$nomor=substr($pecah['nomor'],0-6);
			$jml=strlen($nomor+1);
			if($jml==1){$no='00000';}
			elseif($jml==2){$no='0000';}
			elseif($jml==3){$no='000';}
			elseif($jml==4){$no='00';}
			elseif($jml==5){$no='0';}
			elseif($jml==6){$no='';}
			$taun=date("y");
			$bln=date("m");
			$nilai= "SU".$taun.$bln.$no.($nomor+1);
			return $nilai;
		}
		function simpan($datanya)
		{
			$query=$this->insert("TR_SURVEY_LOG",$datanya);
			if($query)
			{
				$pesan="Simpan data sukses";
			}else
			{
				$pesan="Simpan data gagal";
			}
			$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			echo $Cout;
		}
		function ubah($datanya,$wherenya)
		{
			$this->conInfo();
			$query=$this->update("TR_SURVEY_LOG",$datanya,$wherenya);
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}	
			return $pesan;//$Cout;
		}
	}
	class mst_branch extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from mst_branch $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
	}
	class Cass_MstDataUser extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select  * from Cass_MstDataUser $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
		function count($wherenya)
		{
			$this->conInfo();
			$this->query("select COUNT(*) as total from Cass_MstDataUser $wherenya ");
		}	
		function simpan($datanya)
		{
			$this->conInfo();
			$query=$this->insert("Cass_MstDataUser",$datanya);
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			//return $Cout;
			return $pesan;
		}
		function ubah($datanya,$wherenya)
		{
			$this->conInfo();
			$query=$this->update("Cass_MstDataUser",$datanya,$wherenya);
			if($query)
			{
				 //$pesan="Update data sukses";
				$pesan="1";
			}else
			{
				 //$pesan="Update data gagal";
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;//$Cout;
		}
		function hapus($wherenya)
		{
			$this->conInfo();
			$query=$this->delete("Cass_MstDataUser",$wherenya);
			if($query)
			{
				 //$pesan="Hapus data sukses";
				$pesan="1";
			}else
			{
				 //$pesan="Hapus data gagal.....";
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}		
	}
	class Cass_Banner extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from Cass_Banner $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
	}
	class Cass_MstTowing extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from Cass_MstTowing $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
	}
	class Cass_survey_request extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from Cass_survey_request $wherenya");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
		function select_shield($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from incominglog $wherenya");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
		function ubah_shield($datanya,$wherenya)
		{
			$this->conInfo();
			$query=$this->update("incominglog",$datanya,$wherenya);
			if($query)
			{
				 //$pesan="Update data data sukses";
				$pesan="1";
			}else
			{
				 //$pesan="Update data surveyor gagal";
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}
		function select_detail_Claim($wherenya){
			$this->conInfo();
			$query=$this->query("select * from Cass_survey_request A left join Cass_MstDataUser B on 
				(A.policy_no=B.policyno and A.certificateno=B.certificateno) 
				left join MST_MENU_PRIVILEDGE C on A.surveyor=C.ID 
				left join (select distinct content_id  from Cass_notification) D on A.survey_id=D.content_id $wherenya");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
		function totalSurvey($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select count(*) as total from Cass_survey_request $wherenya");
			return $query;
		}			
		function autonum()
		{
			$this->conInfo();
			$query=$this->query("select MAX (survey_id) as nomor from Cass_survey_request");
			$pecah=$this->tampil();
			$nomor=substr($pecah['nomor'],0-6);
			$jml=strlen($nomor+1);
			if($jml==1){$no='00000';}
			elseif($jml==2){$no='0000';}
			elseif($jml==3){$no='000';}
			elseif($jml==4){$no='00';}
			elseif($jml==5){$no='0';}
			elseif($jml==6){$no='';}
			$taun=date("y");
			$bln=date("m");
			$nilai= "RC".$taun.$bln.$no.($nomor+1);//RC = request casandra 
			$cek=$this->query("select count(*) as total from Cass_survey_request where survey_id='$nilai'");
			$tampilkan=$this->tampil();
			$data=$tampilkan['total'];
			if($data !='0')
			{
				$nilai= "RC".$taun.$bln.$no.($nomor+1);
			}
			return $nilai;
		}
		function simpan($datanya)
		{
			$this->conInfo();
			$query=$this->insert("Cass_survey_request",$datanya);
			if($query)
			{
				 //$pesan="Permohonan survey anda akan segera kami proses";
				$pesan="1";
			}else
			{
				 //$pesan="Simpan data gagal";
				$pesan="0";
			}
			$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			//echo $Cout;
			return $pesan;
		}
		function simpan_shield($datanya)
		{
			$this->conInfo();
			$query=$this->insert("incominglog",$datanya);
			if($query)
			{
				 //$pesan="Permohonan survey anda akan segera kami proses";
				$pesan="1";
			}else
			{
				 //$pesan="Simpan data gagal";
				$pesan="0";
			}
			$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			//echo $Cout;
			return $pesan;
		}
		function ubah($datanya,$wherenya)
		{
			$this->conInfo();
			$query=$this->update("Cass_survey_request",$datanya,$wherenya);
			if($query)
			{
				 //$pesan="Update data data sukses";
				$pesan="1";
			}else
			{
				 //$pesan="Update data surveyor gagal";
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}
	}
	
	class MST_USER extends panfic
	{
		
		function select($where)
		{
			$this->conInfo();
			$query=$this->query("select * from MST_USER $where ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
		function ubah($datanya,$wherenya)
		{
			$this->conInfo();
			$query=$this->update("MST_USER",$datanya,$wherenya);
			if($query)
			{				
				$pesan="1";
			}else
			{				
				$pesan="0";
			}
			
			return $pesan;
		}
		function simpan($datanya)
		{
			$this->conInfo();
			$query=$this->insert("MST_USER",$datanya);
			if($query)
			{				
				$pesan="1";
			}else
			{				 
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}
	}
	class MST_MENU_PRIVILEDGE extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from MST_MENU_PRIVILEDGE $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
		function posisiSurveyor($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from Cass_agent_location A left join MST_MENU_PRIVILEDGE B on A.user_id=B.ID $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}	
	}	
	class Cass_pickUp_survey extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$this->query("select * from Cass_pickUp_survey $wherenya ");
		}
		function count($wherenya)
		{
			$this->conInfo();
			$this->query("select count(*) as total from Cass_pickUp_survey $wherenya ");
		}	
		function simpan($datanya)
		{
			$this->conInfo();
			$query=$this->insert("Cass_pickUp_survey",$datanya);
			if($query)
			{
				 //$pesan="Pick up survey berhasil";
				$pesan="1";
			}else
			{
				 //$pesan="Failed";
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}
		function updateLatLon($datanya,$wherenya)
		{
			$this->conInfo();
			
			$query=$this->update("Cass_pickUp_survey",$datanya,$wherenya);
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}			
	}		
	class Cass_COL extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from Cass_COL $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
	}	
	class Cass_RoadAsst extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from Cass_RoadAsst $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
	}	
	class Cass_Gcm extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from Cass_Gcm $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
		function gcm_internal($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select a.user_id,a.device_id from cass_gcm a inner join MST_MENU_PRIVILEDGE b on a.user_id=b.ID $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}	
		function count($wherenya)
		{
			$this->conInfo();
			$this->query("select count(*) as total from Cass_Gcm $wherenya ");
		}	
		function simpan($datanya)
		{
			$this->conInfo();
			$query=$this->insert("Cass_Gcm",$datanya);
			if($query)
			{
				 //$pesan="Register Gcm Success";
				$pesan="1";
			}else
			{
				 //$pesan="Register Gcm Gagal";
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;//$pesan;
		}
		function updated($datanya,$wherenya)
		{
			$this->conInfo();
			
			$query=$this->update("Cass_Gcm",$datanya,$wherenya);
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}			
	}
	class Cass_Apns extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$this->query("select * from Cass_Apns $wherenya ");
		}
		function count($wherenya)
		{
			$this->conInfo();
			$this->query("select count(*) as total from Cass_Apns $wherenya ");
		}	
		function simpan($datanya)
		{
			$this->conInfo();
			$query=$this->insert("Cass_Apns",$datanya);
			if($query)
			{
				 //$pesan="Register Apns Success";
				$pesan="1";
			}else
			{
				 //$pesan="Register Apns Gagal";
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}
		function ubah($datanya,$wherenya)
		{
			$this->conInfo();
			$query=$this->update("Cass_Apns",$datanya,$wherenya);
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;

		}		
	}	
	class Cass_notification extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from Cass_notification $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
		function count($wherenya)
		{
			$this->conInfo();
			$this->query("select count(*) as total from Cass_notification $wherenya ");
		}	
		function simpan($datanya)
		{
			$this->conInfo();
			$query=$this->insert("Cass_notification",$datanya);
			if($query)
			{
				$pesan="--";
			}else
			{
				$pesan="..";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}
		function ubahData($userid,$ID)
		{
			$this->conInfo();
			$data = array(
				'read_status'=>"2"
			);
			$query=$this->update("Cass_notification",$data,"where user_id='$userid' and ID='$ID'");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}	
		function ubah($data,$wherenya)
		{
			$this->conInfo();
			
			$query=$this->update("Cass_notification",$data,$wherenya);
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}			
	}
	class Cass_rating extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$this->query("select * from Cass_rating $wherenya ");
		}
		function count($wherenya)
		{
			$this->conInfo();
			$this->query("select count(*) as total from Cass_rating $wherenya ");
		}	
		function simpan($datanya)
		{
			$this->conInfo();
			$query=$this->insert("Cass_rating",$datanya);
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}
		function ubahData($userid,$ID)
		{
			$this->conInfo();
			$data = array(
				'read_status'=>"2"
			);
			$query=$this->update("Cass_rating",$data,"where user_id='$userid' and ID='$ID'");
			if($query)
			{
				$pesan="Read";
			}else
			{
				$pesan="Unread";
			}
			$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $Cout;
		}		
	}	
	class Cass_decline_survey extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select top 1 * from Cass_decline_survey $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}
		function count($wherenya)
		{
			$this->conInfo();
			$this->query("select count(*) as total from Cass_decline_survey $wherenya ");
		}	
		function simpan($datanya)
		{
			$this->conInfo();
			$query=$this->insert("Cass_decline_survey",$datanya);
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}
		function ubahData($userid,$ID)
		{
			$this->conInfo();
			$data = array(
				'read_status'=>"2"
			);
			$query=$this->update("Cass_decline_survey",$data,"where user_id='$userid' and ID='$ID'");
			if($query)
			{
				$pesan="Read";
			}else
			{
				$pesan="Unread";
			}
			$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $Cout;
		}		
	}
	class Cass_UserPanfic extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from Cass_UserPanfic $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
		function selectJoinUser($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from Cass_UserPanfic a inner join MST_MENU_PRIVILEDGE b on a.user_id=b.ID $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}	
		function count($wherenya)
		{
			$this->conInfo();
			$this->query("select count(*) as total from Cass_UserPanfic $wherenya ");
		}	
		function simpan($datanya)
		{
			$this->conInfo();
			$query=$this->insert("Cass_UserPanfic",$datanya);
			if($query)
			{
				$pesan="Pembatalan survey telah di sampaikan";
			}else
			{
				$pesan="Failed";
			}
			$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $Cout;
		}
		function ubahData($authKey,$userid)
		{
			$this->conInfo();
			$data = array(
				'auth_key'=>$authKey
			);
			$query=$this->update("Cass_UserPanfic",$data,"where user_id='$userid'");
			if($query)
			{
				$pesan="Read";
			}else
			{
				$pesan="Unread";
			}
			$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $Cout;
		}
		function ubahData_shield($authKey,$userid)
		{
			$this->conInfo();
			$data = array(
				'auth_key_shield'=>$authKey
			);
			$query=$this->update("Cass_UserPanfic",$data,"where user_id='$userid'");
			if($query)
			{
				$pesan="Read";
			}else
			{
				$pesan="Unread";
			}
			$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $Cout;
		}
		function logOut($data,$wherenya)
		{
			$this->conInfo();
			$query=$this->update("Cass_UserPanfic",$data,$wherenya);
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}
		function userCtCare($wherenya)
		{
			$this->conInfo();
			$query=$this->query("SET ANSI_NULLS ON");
			$query=$this->query("SET ANSI_WARNINGS ON");
			$query=$this->query("select * from CARE.SEA_PANPACIFIC.dbo.SysUser $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}			
	}
	class MST_PROFILE_CARE extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from MST_PROFILE_CARE $wherenya ");
			if($query)
			{
				$hasil="1";
			}else
			{
				$hasil="0";
			}
			return $hasil;
		}
		function select_license($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select top 1 PHONE from MST_PROFILE_CARE $wherenya ");
			if($query)
			{
				$hasil="1";
			}else
			{
				$hasil="0";
			}
			return $hasil;
		}
		function selectJoinUser($wherenya)
		{
			$this->conInfo();
			$this->query("select * from MST_PROFILE_CARE a inner join MST_MENU_PRIVILEDGE b on a.user_id=b.ID $wherenya ");
		}	
		function count($wherenya)
		{
			$this->conInfo();
			$this->query("select count(*) as total from MST_PROFILE_CARE $wherenya ");
		}	
		function simpan($datanya)
		{
			$this->conInfo();
			$query=$this->insert("MST_PROFILE_CARE",$datanya);
			if($query)
			{
				$pesan="simpan data Success";
			}else
			{
				$pesan="Failed";
			}
			$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $Cout;
		}
		function ubahData($authKey,$userid)
		{
			$this->conInfo();
			$data = array(
				'auth_key'=>$authKey
			);
			$query=$this->update("MST_PROFILE_CARE",$data,"where user_id='$userid'");
			if($query)
			{
				$pesan="Read";
			}else
			{
				$pesan="Unread";
			}
			$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $Cout;
		}
		function ubah($data,$where)
		{
			$this->conInfo();			
			$query=$this->update("MST_PROFILE_CARE",$data,$where);
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}			
			return $pesan;
		}				
	}	
	class Detail_survey extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from Detail_survey $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}
		function totalPLA($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select isnull(sum(price),0) as price from Detail_survey $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}
		function count($wherenya)
		{
			$this->conInfo();
			$this->query("select count(*) as total from Detail_survey $wherenya ");
		}	
		function simpan($datanya)
		{
			$this->conInfo();
			$query=$this->insert("Detail_survey",$datanya);
			if($query)
			{
				 //$pesan="simpan data Success";
				$pesan="1";
			}else
			{
				 //$pesan="Failed";
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}
		function ubahData($data,$wherenya)
		{
			$this->conInfo();			
			$query=$this->update("Detail_survey",$data,$wherenya);
			if($query)
			{
				 //$pesan="Update berhasil";
				$pesan="1";
			}else
			{
				 //$pesan="Update gagal";
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;//$Cout;
		}	
		function hapus($wherenya)
		{
			$this->conInfo();
			$query=$this->delete("Detail_survey",$wherenya);
			if($query)
			{
				 //$pesan="Hapus data sukses";
				$pesan="1";
			}else
			{
				 //$pesan="Hapus data gagal.....";
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}			
	}
	class Profil_panfic extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from Cass_profil_panfic $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
	}	
	class Cass_finish_towing extends panfic
	{
		function select($wherenya)
		{
			$this->conInfo();
			$query=$this->query("select * from Cass_finish_towing $wherenya ");
			if($query)
			{
				$pesan="1";
			}else
			{
				$pesan="0";
			}
			return $pesan;
		}
		function simpan($datanya)
		{
			$this->conInfo();
			$query=$this->insert("Cass_finish_towing",$datanya);
			if($query)
			{
				 //$pesan="simpan data Success";
				$pesan="1";
			}else
			{
				 //$pesan="Failed";
				$pesan="0";
			}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
			return $pesan;
		}	
	}	

	class JoinTable extends panfic
	{
	function selectAccClaim($wherenya)//buat ACC SPK supaya lebih cepet prosesnya
	{
		$this->conInfo();
		$query=$this->query("select * from Cass_survey_request a inner join MST_BENGKEL b on a.workshop=b.ID inner join 
			Cass_MstUser c on a.user_id=c.userid $wherenya ");
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";
		}
		return $pesan;
	}
}

class PushNotif extends panfic
{
	
	function sendPushNotification($message, $ids) {
    // Insert real GCM API key from the Google APIs Console
    // https://code.google.com/apis/console/        
    //$apiKey = 'abc';
		$data = array('id'=> "2",'title'=> 'Casandra','message' => $message);

		$apiKey="AIzaSyDVfro5bmqwAnQ0SEO08ni_vyGGMyawo-E";

    // Set POST request body
		$post = array(
			'registration_ids'  => $ids,
			'data'              => $data,
		);
    //$post = array('id' =>$ids ,'title'=>'This is a title.title','message'=>'test' );
    // Set CURL request headers 

		$headers = array( 
			'Authorization: key=' . $apiKey,
			'Content-Type: application/json'
		);

    // Initialize curl handle       
		$ch = curl_init();

    // Set URL to GCM push endpoint     
		curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    // Set request method to POST       
		curl_setopt($ch, CURLOPT_POST, true);

    // Set custom request headers       
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Get the response back as string instead of printing it       
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set JSON post data
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

    // Actually send the request    
		$result = curl_exec($ch);

    // Handle errors
		if (curl_errno($ch)) {
			echo 'GCM error: ' . curl_error($ch);
		}

    // Close curl handle
		curl_close($ch);

    // Debug GCM response       
    //echo $result;//di maitiin kalo udah berhasil ini fungsinya buat debug / pesan balikan dari GCM nya
	}

	function sendPushNotificationTowing($message, $ids) {
    // Insert real GCM API key from the Google APIs Console
    // https://code.google.com/apis/console/        
    //$apiKey = 'abc';
		$data = array('id'=> "2",'title'=> 'Towing','message' => $message);

		$apiKey="AIzaSyB9Fq16YPkBOtRuUE3NZnT2tGJ8BXCsxiU";

    // Set POST request body
		$post = array(
			'registration_ids'  => $ids,
			'data'              => $data,
		);
    //$post = array('id' =>$ids ,'title'=>'This is a title.title','message'=>'test' );
    // Set CURL request headers 

		$headers = array( 
			'Authorization: key=' . $apiKey,
			'Content-Type: application/json'
		);

    // Initialize curl handle       
		$ch = curl_init();

    // Set URL to GCM push endpoint     
		curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    // Set request method to POST       
		curl_setopt($ch, CURLOPT_POST, true);

    // Set custom request headers       
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Get the response back as string instead of printing it       
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set JSON post data
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

    // Actually send the request    
		$result = curl_exec($ch);

    // Handle errors
		if (curl_errno($ch)) {
			echo 'GCM error: ' . curl_error($ch);
		}

    // Close curl handle
		curl_close($ch);

    // Debug GCM response       
    //echo $result;//di maitiin kalo udah berhasil ini fungsinya buat debug / pesan balikan dari GCM nya
	}

	function sendPushNotificationRoad($message, $ids) {
    // Insert real GCM API key from the Google APIs Console
    // https://code.google.com/apis/console/        
    //$apiKey = 'abc';
		$data = array('id'=> "2",'title'=> 'Road Assistance','message' => $message);

		$apiKey="AIzaSyCWZ9IFJp4NAbBg2GSZJReUN8SduTPjLu8";

    // Set POST request body
		$post = array(
			'registration_ids'  => $ids,
			'data'              => $data,
		);
    //$post = array('id' =>$ids ,'title'=>'This is a title.title','message'=>'test' );
    // Set CURL request headers 

		$headers = array( 
			'Authorization: key=' . $apiKey,
			'Content-Type: application/json'
		);

    // Initialize curl handle       
		$ch = curl_init();

    // Set URL to GCM push endpoint     
		curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    // Set request method to POST       
		curl_setopt($ch, CURLOPT_POST, true);

    // Set custom request headers       
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Get the response back as string instead of printing it       
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set JSON post data
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

    // Actually send the request    
		$result = curl_exec($ch);

    // Handle errors
		if (curl_errno($ch)) {
			echo 'GCM error: ' . curl_error($ch);
		}

    // Close curl handle
		curl_close($ch);

    // Debug GCM response       
    //echo $result;//di maitiin kalo udah berhasil ini fungsinya buat debug / pesan balikan dari GCM nya
	}

	function sendPushNotificationEsti($message, $ids) {
    // Insert real GCM API key from the Google APIs Console
    // https://code.google.com/apis/console/        
    //$apiKey = 'abc';
		$data = array('id'=> "2",'title'=> 'Estimator','message' => $message);

		$apiKey="AIzaSyD_0rH9tQrX47wGqVyzVeOs2msf4viJ1xg";

    // Set POST request body
		$post = array(
			'registration_ids'  => $ids,
			'data'              => $data,
		);
    //$post = array('id' =>$ids ,'title'=>'This is a title.title','message'=>'test' );
    // Set CURL request headers 

		$headers = array( 
			'Authorization: key=' . $apiKey,
			'Content-Type: application/json'
		);

    // Initialize curl handle       
		$ch = curl_init();

    // Set URL to GCM push endpoint     
		curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    // Set request method to POST       
		curl_setopt($ch, CURLOPT_POST, true);

    // Set custom request headers       
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Get the response back as string instead of printing it       
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set JSON post data
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

    // Actually send the request    
		$result = curl_exec($ch);

    // Handle errors
		if (curl_errno($ch)) {
			echo 'GCM error: ' . curl_error($ch);
		}

    // Close curl handle
		curl_close($ch);

    //Debug GCM response       
    //echo $result;//di maitiin kalo udah berhasil ini fungsinya buat debug / pesan balikan dari GCM nya
	}

	function sendPushNotificationSurveyor($message, $ids) {
    // Insert real GCM API key from the Google APIs Console
    // https://code.google.com/apis/console/        
    //$apiKey = 'abc';
		$data = array('id'=> "2",'title'=> 'Surveyor','message' => $message);

		$apiKey="AIzaSyBMx8LLfGI0wBKzwIi-6ZknkeVGT81lfus";

    // Set POST request body
		$post = array(
			'registration_ids'  => $ids,
			'data'              => $data,
		);
    //$post = array('id' =>$ids ,'title'=>'This is a title.title','message'=>'test' );
    // Set CURL request headers 

		$headers = array( 
			'Authorization: key=' . $apiKey,
			'Content-Type: application/json'
		);

    // Initialize curl handle       
		$ch = curl_init();

    // Set URL to GCM push endpoint     
		curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    // Set request method to POST       
		curl_setopt($ch, CURLOPT_POST, true);

    // Set custom request headers       
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Get the response back as string instead of printing it       
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set JSON post data
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

    // Actually send the request    
		$result = curl_exec($ch);

    // Handle errors
		if (curl_errno($ch)) {
			echo 'GCM error: ' . curl_error($ch);
		}

    // Close curl handle
		curl_close($ch);

    // Debug GCM response       
    //echo $result;//di maitiin kalo udah berhasil ini fungsinya buat debug / pesan balikan dari GCM nya
	}

	function sendPushNotificationFCM($message, $ids) {
    // Insert real GCM API key from the Google APIs Console
    // https://code.google.com/apis/console/        
    //$apiKey = 'abc';
		$data = array('id'=> "2",'title'=> 'Surveyor','message' => $message);

		$apiKey="AIzaSyDUEz99NOPYgOZXqeaj8lyCohs-igPnKfA";
	//$apiKey="AIzaSyC3jDLfOkL-IiSRKpuLl3_dYvrUsjlx7S8";//react native
    // Set POST request body
   /* $post = array(
                    'registration_ids'  => $ids,
                    'data'              => $data,
                );*/

                $post = array (
                	'registration_ids' => $ids,
                	'notification' => array (
                		"body" => $message,
                		"title" => "Casandra App",
                		"icon" => "myicon"
                	)
                );

    //$post = array('id' =>$ids ,'title'=>'This is a title.title','message'=>'test' );
    // Set CURL request headers 

                $headers = array( 
                	'Authorization: key=' . $apiKey,
                	'Content-Type: application/json'
                );

    // Initialize curl handle       
                $ch = curl_init();

    // Set URL to GCM push endpoint     
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    // Set request method to POST       
                curl_setopt($ch, CURLOPT_POST, true);

    // Set custom request headers       
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Get the response back as string instead of printing it       
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set JSON post data
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

    // Actually send the request    
                $result = curl_exec($ch);

    // Handle errors
                if (curl_errno($ch)) {
                	echo 'GCM error: ' . curl_error($ch);
                }

    // Close curl handle
                curl_close($ch);

    // Debug GCM response       
    //echo $result;//di maitiin kalo udah berhasil ini fungsinya buat debug / pesan balikan dari GCM nya
}

	//==================================di bawah punya ios==========================================

function sendPushiOS($message, $devicetoken) 
{
	$tHost = 'gateway.push.apple.com';
	$tPort = 2195;

	$tCert = 'casandraPushLive.pem';
		// Provide the Private Key Passphrase (alternatively you can keep this secrete
		// and enter the key manually on the terminal -> remove relevant line from code).
		// Replace XXXXX with your Passphrase
	$tPassphrase = 'choc3747*';

	$tToken = $devicetoken;

	$tAlert = $message;
		// The Badge Number for the Application Icon (integer >=0).
	$tBadge = 7;
		// Audible Notification Option.
	$tSound = 'default';
		// The content that is returned by the LiveCode "pushNotificationReceived" message.
	$tPayload = 'APNS Message Handled by LiveCode';
		// Create the message content that is to be sent to the device.
	$tBody['aps'] = array (
		'alert' => $tAlert,
		'badge' => $tBadge,
		'sound' => $tSound,
	);
	$tBody ['payload'] = $tPayload;
		// Encode the body to JSON.
	$tBody = json_encode ($tBody);
		// Create the Socket Stream.
	$tContext = stream_context_create ();
	stream_context_set_option ($tContext, 'ssl', 'local_cert', $tCert);
		// Remove this line if you would like to enter the Private Key Passphrase manually.
	stream_context_set_option ($tContext, 'ssl', 'passphrase', $tPassphrase);
		// Open the Connection to the APNS Server.
	$tSocket = stream_socket_client ('ssl://'.$tHost.':'.$tPort, $error, $errstr, 30, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $tContext);
		// Check if we were able to open a socket.
	if (!$tSocket)
		exit ("APNS Connection Failed: $error $errstr" . PHP_EOL);
		// Build the Binary Notification.
	$tMsg = chr (0) . chr (0) . chr (32) . pack ('H*', $tToken) . pack ('n', strlen ($tBody)) . $tBody;
		// Send the Notification to the Server.
	$tResult = fwrite ($tSocket, $tMsg, strlen ($tMsg));
	if ($tResult)
		{//echo 'Delivered Message to APNS' . PHP_EOL;
}else{
	echo 'Could not Deliver Message to APNS' . PHP_EOL;
}
		// Close the Connection to the Server.
fclose ($tSocket);

}
}

class Cass_agent_location extends panfic
{
	
	function select($wherenya)
	{
		$this->conInfo();
		$query=$this->query("select * from Cass_agent_location $wherenya ");
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";
		}
		return $pesan;
	}
	function simpan($datanya)
	{
		$this->conInfo();
		$query=$this->insert("Cass_agent_location",$datanya);
		if($query)
		{
				 //$pesan="simpan data Success";
			$pesan="1";
		}else
		{
				 //$pesan="Failed";
			$pesan="0";
		}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
		return $pesan;
	}
	function ubah($data,$wherenya)
	{
		$this->conInfo();
		$query=$this->update("Cass_agent_location",$data,$wherenya);
		if($query)
		{
			$pesan="1";
		}else
		{
			$pesan="0";
		}
			//$Cout='{"data":{"msg":"'.$pesan.'"}}';	
		return $pesan;
	}		
}

class RTF
{
	static function Text($rtf)
	{
		$text = preg_replace('~(\\\[a-z0-9*]+({[^}]*}){0,1}([ a-z0-9]*;{1}){0,1})~si', '', $rtf);
		$find    = array("\r", "\n", '\line ', '{', '}');
		$replace = array('', '', "\r\n", '', '');
		$text = str_replace($find, $replace, $text);
		return preg_replace_callback("~\\\'([0-9a-f]{2})~", array('RTF', 'convert'), trim($text));
		//return preg_replace("~\\\\\\'([0-9a-f]{2})~", chr("0x$1"), $text);
	}
	static function convert($symbol)
	{
		return chr(hexdec($symbol[1]));
	}
}
/**
* buat kirim mail
*/
class Mailer
{
	
	function SendMailCustomer($mailnya,$Reqno,$tglSPK,$expSPK,$namaBengkel,$alamatBengkel,$noClaim)
	{
		require '../mailer/PHPMailerAutoload.php';
		$mail = new PHPMailer;

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'no-reply@panfic.com';                 // SMTP username
		$mail->Password = 'panfic12';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
		$mail->Port = 587;
		$mail->From = 'no-reply@panfic.com';
		$mail->FromName = 'Casandra Apps';
		$mail->addAddress($mailnya);     // Add a recipient
		//$mail->addAddress('ellen@example.com');               // Name is optional
		$mail->addReplyTo('no-reply@panfic.com', 'Casandra Apps');
		/* $mail->addCC('rendy@panfic.com'); 
		$mail->addCC('wilmen@panfic.com');
		$mail->addCC('rendy@panfic.com');
		$mail->addCC('rendy@panfic.com');
		$mail->addCC('fakhrullah@panfic.com');*/
		//$mail->addBCC('iwan.goepoet@gmail.com');

		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		$mail->addAttachment('c:/inetpub/wwwroot/ShieldService/spk_pdf/'.$Reqno.'.pdf');         // Add attachments
		$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = 'Detail Own Risk '.$noClaim;
		$mail->Body    = '
		<br>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Narrative Confirm Email</title>
		<style type="text/css">

		/* Take care of image borders and formatting */

		img {
			max-width: 600px;
			outline: none;
			text-decoration: none;
			-ms-interpolation-mode: bicubic;
		}

		a {
			border: 0;
			outline: none;
		}

		a img {
			border: none;
		}

		/* General styling */

		td, h1, h2, h3  {
			font-family: Helvetica, Arial, sans-serif;
			font-weight: 400;
		}

		td {
			font-size: 13px;
			line-height: 150%;
			text-align: left;
		}

		body {
			-webkit-font-smoothing:antialiased;
			-webkit-text-size-adjust:none;
			width: 100%;
			height: 100%;
			color: #37302d;
			background: #ffffff;
		}

		table {
			border-collapse: collapse !important;
		}


		h1, h2, h3 {
			padding: 0;
			margin: 0;
			color: #444444;
			font-weight: 400;
			line-height: 110%;
		}

		h1 {
			font-size: 35px;
		}

		h2 {
			font-size: 30px;
		}

		h3 {
			font-size: 24px;
		}

		h4 {
			font-size: 18px;
			font-weight: normal;
		}

		.important-font {
			color: #21BEB4;
			font-weight: bold;
		}

		.hide {
			display: none !important;
		}

		.force-full-width {
			width: 100% !important;
		}

		</style>

		<style type="text/css" media="screen">
		@media screen {
			@import url(http://fonts.googleapis.com/css?family=Open+Sans:400);

			/* Thanks Outlook 2013! */
			td, h1, h2, h3 {
				font-family: "Open Sans", "Helvetica Neue", Arial, sans-serif !important;
			}
		}
		</style>

		<style type="text/css" media="only screen and (max-width: 600px)">
		/* Mobile styles */
		@media only screen and (max-width: 600px) {

			table[class="w320"] {
				width: 320px !important;
			}

			table[class="w300"] {
				width: 300px !important;
			}

			table[class="w290"] {
				width: 290px !important;
			}

			td[class="w320"] {
				width: 320px !important;
			}

			td[class~="mobile-padding"] {
				padding-left: 14px !important;
				padding-right: 14px !important;
			}

			td[class*="mobile-padding-left"] {
				padding-left: 14px !important;
			}

			td[class*="mobile-padding-right"] {
				padding-right: 14px !important;
			}

			td[class*="mobile-block"] {
				display: block !important;
				width: 100% !important;
				text-align: left !important;
				padding-left: 0 !important;
				padding-right: 0 !important;
				padding-bottom: 15px !important;
			}

			td[class*="mobile-no-padding-bottom"] {
				padding-bottom: 0 !important;
			}

			td[class~="mobile-center"] {
				text-align: center !important;
			}

			table[class*="mobile-center-block"] {
				float: none !important;
				margin: 0 auto !important;
			}

      *[class*="mobile-hide"] {
			display: none !important;
			width: 0 !important;
			height: 0 !important;
			line-height: 0 !important;
			font-size: 0 !important;
		}

		td[class*="mobile-border"] {
			border: 0 !important;
		}
	}
	</style>
	</head>
	<body class="body" style="padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none" bgcolor="#ffffff">
	<table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr>
	<td align="center" valign="top" bgcolor="#ffffff"  width="100%">

	<table cellspacing="0" cellpadding="0" width="100%">
	<tr>
	<td style="background:#004C98" width="100%">
	<center>
	<table cellspacing="0" cellpadding="0" width="600" class="w320">
	<tr>
	<td valign="top" class="mobile-block mobile-no-padding-bottom mobile-center" width="270" style="background:#004C98;padding:10px 10px 10px 20px;">

	<img src="http://shield.panfic.com:8081/image_shield/casandra_pth.png" width="200" height="40" alt="Your Logo"/>

	</td>
	<td valign="top" class="mobile-block mobile-center" width="270" style="background:#004C98;padding:10px 15px 10px 10px">
	<table border="0" cellpadding="0" cellspacing="0" class="mobile-center-block" align="right">
	<tr>
	<td align="right">
	<a href="#">
	<img src="http://keenthemes.com/assets/img/emailtemplate/social_facebook.png"  width="30" height="30" alt="social icon"/>
	</a>
	</td>
	<td align="right" style="padding-left:5px">
	<a href="#">
	<img src="http://keenthemes.com/assets/img/emailtemplate/social_twitter.png"  width="30" height="30" alt="social icon"/>
	</a>
	</td>
	<td align="right" style="padding-left:5px">
	<a href="#">
	<img src="http://keenthemes.com/assets/img/emailtemplate/social_googleplus.png"  width="30" height="30" alt="social icon"/>
	</a>
	</td>


	</tr>
	</table>
	</td>
	</tr>
	</table>
	</center>
	</td>
	</tr>
	<tr>
	<td style="border-bottom:1px solid #e7e7e7;">
	<center>
	<table cellpadding="0" cellspacing="0" width="600" class="w320">
	<tr>
	<td align="left" class="mobile-padding" style="padding:20px">

	<br class="mobile-hide" />

	<h2>Casandra Apps</h2>
	<br>
	Terima kasih atas kepercayaan dan kesetiaan Anda menggunakan Asuransi Pan Pacific sebagai asuransi pilihan Anda..<br>
	<br>Pengajuan klaim kendaraan Anda dengan <b> Nomor Request : '.$Reqno.'</b> sudah berhasil
	dilakukan pada tanggal <b>'.$tglSPK.'</b>.

	<br><br>Silahkan bawa kendaraan anda ke bengkel yang sudah disetujui sebelum tanggal <b>'.$expSPK.'</b>. tunjukkan email ini sebagai bukti permohonan klaim Anda.

	Bersama ini kami lampirkan juga detail klaim kendaraan Anda.
	<br><br>
	Hormat kami,<br>
	<b>PT Pan Pacific Insurance</b>
	<table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff">
	<tr>
	<td style="width:100px;background:#D84A38;">

	</td>
	<td width="281" style="background-color:#ffffff; font-size:0; line-height:0;">&nbsp;</td>
	</tr>
	</table>
	</td>
	<td class="mobile-hide" style="padding-top:20px;padding-bottom:0; vertical-align:bottom;" valign="bottom">
	<table cellspacing="0" cellpadding="0" width="100%">
	<tr>
	<td align="right" valign="bottom" style="padding-bottom:0; vertical-align:bottom;">
	<img  style="vertical-align:bottom;" src="http://shield.panfic.com:8081/image_shield/C-logo.png"  width="174" height="174" />
	</td>
	</tr>
	</table>
	<br><br><br><br>
	</td>
	</tr>
	</table>
	</center>
	</td>
	</tr>
	<tr>
	<td valign="top" style="background-color:#f8f8f8;border-bottom:1px solid #e7e7e7;">

	<center>
	<table border="0" cellpadding="0" cellspacing="0" width="600" class="w320" style="height:100%;">
	<tr>
	<td valign="top" class="mobile-padding" style="padding:20px;">
	<table cellspacing="0" cellpadding="0" width="100%">
	<tr>
	<td style="padding-right:20px">
	<b>'.$namaBengkel.'</b>
	</td>                     
	</tr>
	<tr>
	<td style="padding-top:5px; padding-right:20px; border-top:1px solid #E7E7E7; vertical-align:top; ">
	'.$alamatBengkel.'
	</td>
	</tr>
	</table>
	<table cellspacing="0" cellpadding="0" width="100%">
	<tr>
	<td style="padding-top:50px;">
	<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
	<td width="350" style="vertical-align:top;">
	Untuk informasi silahkan menghubungi Care Center Panfic Tel : <b>(021) 45 8 45 511</b>,<br>
	<br>
	<div style="font-size:12px;">
	<b>PT Pan Pacific Insurance</b><br>
	Graha Pratama lt 6<br>
	Jl M.T Haryono Kav 15<br>
	Jakarta 12810, Indonesia
	</div>

	</td>

	</tr>
	</table><br>
	<table cellpadding="0" border="0" cellspacing="0" width="100%">
	<tr>
	<td width="100%" style="vertical-align:top;">
	<img  style="vertical-align:bottom;" src="http://shield.panfic.com:8081/image_shield/app_store.png"  width="100" height="30" />
	<a href="https://play.google.com/store/apps/details?id=com.panfic.casandra">
	<img  style="vertical-align:bottom;" src="http://shield.panfic.com:8081/image_shield/play_store.png"  width="100" height="30" />
	</a>
	</td>

	</tr>
	</table>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>
	</center>
	</td>
	</tr>
	<tr>
	<td style="background-color:#004C98;">
	<center>
	<table border="0" cellpadding="0" cellspacing="0" width="600" class="w320" style="height:100%;color:#ffffff" bgcolor="#004C98" >
	<tr>
	<td align="right" valign="middle" class="mobile-padding" style="font-size:12px;padding:20px; background-color:#004C98; color:#ffffff; text-align:left; ">
	<a style="color:#ffffff;"  href="www.panfic.com">www.panfic.com</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a style="color:#ffffff;" href="#">Facebook</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a style="color:#ffffff;" href="#">Twitter</a>                  
	</td>
	<td align="right" width="100" style="font-size:12px;padding:10px;">
	<img  style="vertical-align:bottom;" src="http://shield.panfic.com:8081/image_shield/panfic_pth.png"  width="174" height="30" />
	</td>
	</tr>
	</table>
	</center>
	</td>
	</tr>
	</table>

	</td>
	</tr>
	</table>
	</body>
	</html>

	';
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	if(!$mail->send()) {
		    /*$pesan= 'Message could not be sent.';
		    $pesan= 'Mailer Error: ' . $mail->ErrorInfo;*/
		    $pesan="0";
		} else {
		    //$pesan='Message has been sent';
			$pesan="1";
		}
		return $pesan;
	}
	function SendMailRegister($mailnya,$userId,$Password)
	{
		require '../mailer/PHPMailerAutoload.php';
		$mail = new PHPMailer;

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'no-reply@panfic.com';                 // SMTP username
		$mail->Password = 'panfic12';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
		$mail->Port = 587;
		$mail->From = 'no-reply@panfic.com';
		$mail->FromName = 'Casandra Apps';
		$mail->addAddress($mailnya);     // Add a recipient
		//$mail->addAddress('ellen@example.com');               // Name is optional
		$mail->addReplyTo('no-reply@panfic.com', 'Casandra Apps');
		/* $mail->addCC('rendy@panfic.com'); 
		$mail->addCC('wilmen@panfic.com');
		$mail->addCC('rendy@panfic.com');
		$mail->addCC('rendy@panfic.com');
		$mail->addCC('fakhrullah@panfic.com');*/
		$mail->addBCC('iwan.goepoet@gmail.com');

		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		$mail->addAttachment('c:/inetpub/wwwroot/ShieldService/spk_pdf/'.$Reqno.'.pdf');         // Add attachments
		$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = 'Register ID and Password';
		$mail->Body    = '
		<br>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Narrative Confirm Email</title>
		<style type="text/css">

		/* Take care of image borders and formatting */

		img {
			max-width: 600px;
			outline: none;
			text-decoration: none;
			-ms-interpolation-mode: bicubic;
		}

		a {
			border: 0;
			outline: none;
		}

		a img {
			border: none;
		}

		/* General styling */

		td, h1, h2, h3  {
			font-family: Helvetica, Arial, sans-serif;
			font-weight: 400;
		}

		td {
			font-size: 13px;
			line-height: 150%;
			text-align: left;
		}

		body {
			-webkit-font-smoothing:antialiased;
			-webkit-text-size-adjust:none;
			width: 100%;
			height: 100%;
			color: #37302d;
			background: #ffffff;
		}

		table {
			border-collapse: collapse !important;
		}


		h1, h2, h3 {
			padding: 0;
			margin: 0;
			color: #444444;
			font-weight: 400;
			line-height: 110%;
		}

		h1 {
			font-size: 35px;
		}

		h2 {
			font-size: 30px;
		}

		h3 {
			font-size: 24px;
		}

		h4 {
			font-size: 18px;
			font-weight: normal;
		}

		.important-font {
			color: #21BEB4;
			font-weight: bold;
		}

		.hide {
			display: none !important;
		}

		.force-full-width {
			width: 100% !important;
		}

		</style>

		<style type="text/css" media="screen">
		@media screen {
			@import url(http://fonts.googleapis.com/css?family=Open+Sans:400);

			/* Thanks Outlook 2013! */
			td, h1, h2, h3 {
				font-family: "Open Sans", "Helvetica Neue", Arial, sans-serif !important;
			}
		}
		</style>

		<style type="text/css" media="only screen and (max-width: 600px)">
		/* Mobile styles */
		@media only screen and (max-width: 600px) {

			table[class="w320"] {
				width: 320px !important;
			}

			table[class="w300"] {
				width: 300px !important;
			}

			table[class="w290"] {
				width: 290px !important;
			}

			td[class="w320"] {
				width: 320px !important;
			}

			td[class~="mobile-padding"] {
				padding-left: 14px !important;
				padding-right: 14px !important;
			}

			td[class*="mobile-padding-left"] {
				padding-left: 14px !important;
			}

			td[class*="mobile-padding-right"] {
				padding-right: 14px !important;
			}

			td[class*="mobile-block"] {
				display: block !important;
				width: 100% !important;
				text-align: left !important;
				padding-left: 0 !important;
				padding-right: 0 !important;
				padding-bottom: 15px !important;
			}

			td[class*="mobile-no-padding-bottom"] {
				padding-bottom: 0 !important;
			}

			td[class~="mobile-center"] {
				text-align: center !important;
			}

			table[class*="mobile-center-block"] {
				float: none !important;
				margin: 0 auto !important;
			}

      *[class*="mobile-hide"] {
			display: none !important;
			width: 0 !important;
			height: 0 !important;
			line-height: 0 !important;
			font-size: 0 !important;
		}

		td[class*="mobile-border"] {
			border: 0 !important;
		}
	}
	</style>
	</head>
	<body class="body" style="padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none" bgcolor="#ffffff">
	<table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr>
	<td align="center" valign="top" bgcolor="#ffffff"  width="100%">

	<table cellspacing="0" cellpadding="0" width="100%">
	<tr>
	<td style="background:#004C98" width="100%">
	<center>
	<table cellspacing="0" cellpadding="0" width="600" class="w320">
	<tr>
	<td valign="top" class="mobile-block mobile-no-padding-bottom mobile-center" width="270" style="background:#004C98;padding:10px 10px 10px 20px;">

	<img src="http://shield.panfic.com:8081/image_shield/casandra_pth.png" width="200" height="40" alt="Your Logo"/>

	</td>
	<td valign="top" class="mobile-block mobile-center" width="270" style="background:#004C98;padding:10px 15px 10px 10px">
	<table border="0" cellpadding="0" cellspacing="0" class="mobile-center-block" align="right">
	<tr>
	<td align="right">
	<a href="#">
	<img src="http://keenthemes.com/assets/img/emailtemplate/social_facebook.png"  width="30" height="30" alt="social icon"/>
	</a>
	</td>
	<td align="right" style="padding-left:5px">
	<a href="#">
	<img src="http://keenthemes.com/assets/img/emailtemplate/social_twitter.png"  width="30" height="30" alt="social icon"/>
	</a>
	</td>
	<td align="right" style="padding-left:5px">
	<a href="#">
	<img src="http://keenthemes.com/assets/img/emailtemplate/social_googleplus.png"  width="30" height="30" alt="social icon"/>
	</a>
	</td>


	</tr>
	</table>
	</td>
	</tr>
	</table>
	</center>
	</td>
	</tr>
	<tr>
	<td style="border-bottom:1px solid #e7e7e7;">
	<center>
	<table cellpadding="0" cellspacing="0" width="600" class="w320">
	<tr>
	<td align="left" class="mobile-padding" style="padding:20px">

	<br class="mobile-hide" />

	<h2>Casandra Apps</h2>
	<br>
	Terima kasih atas kepercayaan dan kesetiaan Anda menggunakan Asuransi Pan Pacific sebagai asuransi pilihan Anda.<br>
	<br>Berikut Adalah User ID dan Password anda :<br><br>
	<table border="0" cellpadding="0" cellspacing="0" width="200" class="w320">
	<tr>
	<td><b>USER ID</b></td>
	<td>&nbsp;<b>:</b>&nbsp;</td>
	<td><b>'.$userId.'<b></td>
	</tr>
	<tr>
	<td><b>PASSWORD</b></td>
	<td>&nbsp;<b>:</b>&nbsp;</td>
	<td><b>'.$Password.'</b></td>
	</tr>						
	</table>
	<br><br>Silahkan Ganti Password anda dengan kata yang mudah anda ingat.
	<br><br>
	Hormat kami,<br>
	<b>PT Pan Pacific Insurance</b>
	<table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff">
	<tr>
	<td style="width:100px;background:#D84A38;">

	</td>
	<td width="281" style="background-color:#ffffff; font-size:0; line-height:0;">&nbsp;</td>
	</tr>
	</table>
	</td>
	<td class="mobile-hide" style="padding-top:20px;padding-bottom:0; vertical-align:bottom;" valign="bottom">
	<table cellspacing="0" cellpadding="0" width="100%">
	<tr>
	<td align="right" valign="bottom" style="padding-bottom:0; vertical-align:bottom;">
	<img  style="vertical-align:bottom;" src="http://shield.panfic.com:8081/image_shield/C-logo.png"  width="174" height="174" />
	</td>
	</tr>
	</table>
	<br><br><br><br>
	</td>
	</tr>
	</table>
	</center>
	</td>
	</tr>
	<tr>
	<td valign="top" style="background-color:#f8f8f8;border-bottom:1px solid #e7e7e7;">

	<center>
	<table border="0" cellpadding="0" cellspacing="0" width="600" class="w320" style="height:100%;">
	<tr>
	<td valign="top" class="mobile-padding" style="padding:20px;">                  
	<table cellspacing="0" cellpadding="0" width="100%">
	<tr>
	<td style="padding-top:50px;">
	<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
	<td width="350" style="vertical-align:top;">
	Untuk informasi silahkan menghubungi Care Center Panfic Tel : <b>(021) 45 8 45 511</b>,<br>
	<br>
	<div style="font-size:12px;">
	<b>PT Pan Pacific Insurance</b><br>
	Graha Pratama lt 6<br>
	Jl M.T Haryono Kav 15<br>
	Jakarta 12810, Indonesia
	</div>
	</td>							
	</tr>
	</table><br>
	<table cellpadding="0" border="0" cellspacing="0" width="100%">
	<tr>
	<td width="100%" style="vertical-align:top;">
	<img  style="vertical-align:bottom;" src="http://shield.panfic.com:8081/image_shield/app_store.png"  width="100" height="30" />
	<a href="https://play.google.com/store/apps/details?id=com.panfic.casandra">
	<img  style="vertical-align:bottom;" src="http://shield.panfic.com:8081/image_shield/play_store.png"  width="100" height="30" />
	</a>
	</td>

	</tr>
	</table>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>
	</center>
	</td>
	</tr>
	<tr>
	<td style="background-color:#004C98;">
	<center>
	<table border="0" cellpadding="0" cellspacing="0" width="600" class="w320" style="height:100%;color:#ffffff" bgcolor="#004C98" >
	<tr>
	<td align="right" valign="middle" class="mobile-padding" style="font-size:12px;padding:20px; background-color:#004C98; color:#ffffff; text-align:left; ">
	<a style="color:#ffffff;"  href="www.panfic.com">www.panfic.com</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a style="color:#ffffff;" href="#">Facebook</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	<a style="color:#ffffff;" href="#">Twitter</a>                  
	</td>
	<td align="right" width="100" style="font-size:12px;padding:10px;">
	<img  style="vertical-align:bottom;" src="http://shield.panfic.com:8081/image_shield/panfic_pth.png"  width="174" height="30" />
	</td>
	</tr>
	</table>
	</center>
	</td>
	</tr>
	</table>

	</td>
	</tr>
	</table>
	</body>
	</html>

	';
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	if(!$mail->send()) {
		   /* $pesan= 'Message could not be sent.';
		   $pesan= 'Mailer Error: ' . $mail->ErrorInfo;*/
		   $pesan="0";
		} else {
		    //$pesan='Message has been sent';
			$pesan="1";
		}
		return $pesan;
	}
}
/**
 * clas buat data bpd jambi
 */
class prj_askred extends panfic
{	
	function simpan($datanya)
	{
		$this->conInfo();
		$query=$this->insert("prj_askred",$datanya);
		if($query)
		{
			$pesan="1";
		}else
		{				
			$pesan="0";
		}		
		return $pesan;
	}
	function select($wherenya)
	{
		$this->conInfo();
		//$query=$this->select("prj_askred",$wherenya);
		$query=$this->query("select top 100 * from prj_askred $wherenya	");
		if($query)
		{
			$pesan="1";
		}else
		{				
			$pesan="0";
		}		
		return $pesan;
	}
}
/**
 * untuk API kopnus
 */
class prj_broker extends panfic
{
	
	function simpan($datanya)
	{
		$this->conInfo();
		$query=$this->insert("prj_broker",$datanya);
		if($query)
		{
			$pesan="1";
		}else
		{				
			$pesan="0";
		}		
		return $pesan;
	}
	function simpan_adonai($datanya)
	{
		$this->conInfo();
		$query=$this->insert("prj_broker_adonai",$datanya);
		if($query)
		{
			$pesan="1";
		}else
		{				
			$pesan="0";
		}		
		return $pesan;
	}
	function select($wherenya)
	{
		$this->conInfo();
		//$query=$this->select("prj_broker",$wherenya);
		$query=$this->query("select top 100 * from prj_broker $wherenya	");
		if($query)
		{
			$pesan="1";
		}else
		{				
			$pesan="0";
		}		
		return $pesan;
	}
	function select_adonai($wherenya)
	{
		$this->conInfo();		
		$query=$this->query("select top 100 * from prj_broker_adonai $wherenya	");
		if($query)
		{
			$pesan="1";
		}else
		{				
			$pesan="0";
		}		
		return $pesan;
	}
}

//================================================================================================================================Classnya CARE	
class ACCEPTANCE extends panfic
{

	function Select($wherenya)
	{
		// $this->conCare();
		// $query=$this->query("select top 100 * from ACCEPTANCE $wherenya	");
		$this->conInfo();
		$query=$this->query("SET ANSI_NULLS ON");
		$query=$this->query("SET ANSI_WARNINGS ON");
		$query=$this->query("select top 100 * from care.sea_panpacific.dbo.ACCEPTANCE $wherenya"); 
		if($query)
		{

			$pesan="1";
		}else
		{

			$pesan="0";
		}

		return $pesan;
			//$this->conInfo();
	}	
	function ambil($wherenya)
	{
		//$this->conCare();
		//$query=$this->query("select top 100 * from ACCEPTANCE $wherenya order by ano desc");

		$this->conInfo();
		$query=$this->query("SET ANSI_NULLS ON");
		$query=$this->query("SET ANSI_WARNINGS ON");
		$query=$this->query("select top 100 * from care.sea_panpacific.dbo.ACCEPTANCE $wherenya"); 
		if($query)
		{

			$pesan="1";
		}else
		{

			$pesan="0";
		}

		return $pesan;
	}		
}
class RARRHEADER extends panfic
{

	function Select($wherenya)
	{
		// $this->conCare();
		// $query=$this->query("select top 100 * from RARRHEADER $wherenya");
		$this->conInfo();
		$query=$this->query("SET ANSI_NULLS ON");
		$query=$this->query("SET ANSI_WARNINGS ON");
		$query=$this->query("select top 100 * from care.sea_panpacific.dbo.RARRHEADER $wherenya"); 
		if($query)
		{				 
			$pesan="1";
		}else
		{				 
			$pesan="0";
		}			
		return $pesan;
	}		
}		
class GETPembayaran extends panfic
{
	
	function GetBayar($wherenya)
	{
		$this->conCare();
		$query=$this->query("select Payment_CC,* FROM nVoucher WHERE Voucher IN (select VOUCHER from AdmLink $wherenya )");
		if($query)
		{				 
			$pesan="1";
		}else
		{				 
			$pesan="0";
		}			
		return $pesan;
	}		
}		
class ACCDED extends panfic
{

	function Select($wherenya)
	{
		// $this->conCare();
		// $query=$this->query("select top 100 * from ACCDED $wherenya order by DCODE asc");
		$this->conInfo();
		$query=$this->query("SET ANSI_NULLS ON");
		$query=$this->query("SET ANSI_WARNINGS ON");
		$query=$this->query("select top 100 * from care.sea_panpacific.dbo.ACCDED $wherenya order by DCODE asc"); 
		if($query)
		{				 
			$pesan="1";
		}else
		{				 
			$pesan="0";
		}			
		return $pesan;
	}		
}	
class COLTAB extends panfic
{

	function Select($wherenya)
	{
		$this->conCare();
		$this->query("select top 500 * from COLTAB $wherenya");

	}		
}
class Care_claim extends panfic
{
	function get_datanya($wherenya)
	{
		$this->conCare();
		$query=$this->query("select * from claim where claimno='$wherenya'");
		// $pecah=$this->tampil();

		// $data = array(
		// 	'cno' => $pecah["CNO"],
		// 	'refno'=>$pecah["refno"]
		// );
		if($query){
			$pesan="1";
		}else{
			$pesan="0";
		}
		return $pesan;
	}
	
}			
class care_cllos extends panfic
{
	function get_data($wherenya)
	{
		$this->conCare();
		$this->query("select * from CLLOSS $wherenya");
		$pecah=$this->tampil();

		$data = array(
			'Payment' => $pecah["Payment"]
		);
		return $data;
	}
	
}		
class Ainfo extends panfic
{

	function Select($wherenya)
	{
		// $this->conCare();
		// $this->query("select top 100 * from AINFO $wherenya order by ano desc");	

		$this->conInfo();
		$this->query("SET ANSI_NULLS ON");
		$this->query("SET ANSI_WARNINGS ON");
		$this->query("select top 100 * from care.sea_panpacific.dbo.AINFO $wherenya order by ano desc"); 		
	}
	function detailvehicle($ano,$toc)
	{
		// $this->conCare();
		// $this->query("select * from AINFO where ANO='$ano'");
		$this->conInfo();
		$this->query("SET ANSI_NULLS ON");
		$this->query("SET ANSI_WARNINGS ON");
		$this->query("select * from care.sea_panpacific.dbo.AINFO where ANO='$ano'");
		$pecah=$this->tampil();
		if($toc=='0202')
		{
			$data = array(
				'Brand' => $pecah["VALUEDESC1"],
				'Vehicle_model' => $pecah["VALUEDESC2"],
				'SubMode' => $pecah["VALUEDESC3"],
				'Vehicle_type' => $pecah["VALUEDESC4"],
				'License_number' => $pecah["VALUEDESC5"],
				'Machine_number' => $pecah["VALUEDESC6"],
				'Chasis_number' => $pecah["VALUEDESC7"],
				'Functionn' => $pecah["VALUEDESC8"],
				'Capacity'=> $pecah["VALUEDESC9"],
				'Year' => $pecah["VALUEDESC10"],
				'Color' => $pecah["VALUEDESC11"],
				'Bpkb' => $pecah["VALUEDESC13"],
				'Condition' => $pecah["VALUEDESC15"],
				'Location' => "",
				'Area' =>"",
				'Ano' => $pecah["ANO"]

			);
		}else if ($toc== '0223')
		{
			$data = array(
				'Brand' => $pecah["VALUEDESC1"],
				'Vehicle_model' => $pecah["VALUEDESC2"],
				'SubMode' => $pecah["VALUEDESC3"],
				'Vehicle_type' => $pecah["VALUEDESC4"],
				'License_number' => $pecah["VALUEDESC5"],
				'Machine_number' => $pecah["VALUEDESC8"],
				'Chasis_number' => $pecah["VALUEDESC9"],
				'Functionn' => $pecah["VALUEDESC10"],
				'Capacity' => $pecah["VALUEDESC11"],
				'Year' => $pecah["VALUEDESC12"],
				'Color' => $pecah["VALUEDESC13"],
				'Bpkb' => $pecah["VALUEDESC14"],
				'Condition' => $pecah["VALUEDESC15"],
				'Location' => $pecah["VALUEDESC6"],
				'Area' => $pecah["VALUEDESC7"],
				'Ano' => $pecah["ANO"]
			);
		}
		else if ($toc == '0224')
		{
			$data = array(
				'Brand' => $pecah["VALUEDESC1"],
				'Vehicle_model' => $pecah["VALUEDESC2"],
                        'SubMode' => "", //'$pecah["VALUEDESC3"],
                        'Vehicle_type' => $pecah["VALUEDESC3"],
                        'License_number' => $pecah["VALUEDESC4"],
                        'Machine_number' => $pecah["VALUEDESC7"],
                        'Chasis_number' => $pecah["VALUEDESC8"],
                        'Functionn' => $pecah["VALUEDESC9"],
                        'Capacity' => "", //'$pecah["VALUEDESC11"],
                        'Year' => $pecah["VALUEDESC10"],
                        'Color' => $pecah["VALUEDESC11"],
                        'Bpkb' => $pecah["VALUEDESC12"],
                        'Condition' => $pecah["VALUEDESC15"],
                        'Location' => $pecah["VALUEDESC5"],
                        'Area' => $pecah["VALUEDESC6"],
                        'Ano' => $pecah["ANO"]
                    );
		}
		else if ($toc == '0253')
		{
			$data = array(
				'Brand' => $pecah["VALUEDESC1"],
				'Vehicle_model' => $pecah["VALUEDESC2"],
				'SubMode' => $pecah["VALUEDESC3"],
				'Vehicle_type' => $pecah["VALUEDESC4"],
				'License_number' => $pecah["VALUEDESC5"],
				'Machine_number' => $pecah["VALUEDESC8"],
				'Chasis_number' => $pecah["VALUEDESC9"],
				'Functionn' => $pecah["VALUEDESC10"],
				'Capacity' => $pecah["VALUEDESC11"],
				'Year' => $pecah["VALUEDESC12"],
				'Color' => $pecah["VALUEDESC13"],
				'Bpkb' => $pecah["VALUEDESC14"],
				'Condition' => $pecah["VALUEDESC15"],
				'Location' => $pecah["VALUEDESC6"],
				'Area' => $pecah["VALUEDESC7"],
				'Ano' => $pecah["ANO"]
			);
		}
		else if ($toc == '0254')
		{
			$data = array(
				'Brand' => $pecah["VALUEDESC1"],
				'Vehicle_model' => $pecah["VALUEDESC2"],
				'SubMode' => $pecah["VALUEDESC3"],
				'Vehicle_type' => $pecah["VALUEDESC3"],
				'License_number' => $pecah["VALUEDESC4"],
				'Machine_number' => $pecah["VALUEDESC7"],
				'Chasis_number' => $pecah["VALUEDESC8"],
				'Functionn' => $pecah["VALUEDESC9"],
                        'Capacity' => "", //'$pecah["VALUEDESC11"],
                        'Year' => $pecah["VALUEDESC10"],
                        'Color' => $pecah["VALUEDESC11"],
                        'Bpkb' => $pecah["VALUEDESC12"],
                        'Condition' => $pecah["VALUEDESC15"],
                        'Location' => $pecah["VALUEDESC5"],
                        'Area' => $pecah["VALUEDESC6"],
                        'Ano' => $pecah["ANO"]
                    );
		}
		else
		{
			$data = array(
				'Brand' => $pecah["VALUEDESC1"],
				'Vehicle_model' => $pecah["VALUEDESC2"],
				'SubMode' => $pecah["VALUEDESC3"],
				'Vehicle_type' => $pecah["VALUEDESC4"],
				'License_number' => $pecah["VALUEDESC5"],
				'Machine_number' => $pecah["VALUEDESC6"],
				'Chasis_number' => $pecah["VALUEDESC7"],
				'Functionn' => $pecah["VALUEDESC8"],
				'Capacity' => $pecah["VALUEDESC9"],
				'Year' => $pecah["VALUEDESC10"],
				'Color' => $pecah["VALUEDESC11"],
				'Bpkb' => $pecah["VALUEDESC12"],
				'Condition' => $pecah["VALUEDESC15"],
				'Location' =>"",
				'Area' => "",
				'Ano' => $pecah["ANO"]
			);
		}
		return $data;
	}		
}	
class RCOVER extends panfic
{
	function select($wherenya)
	{
		// $this->conCare();
		// $query=$this->query("select CONVERT(VARCHAR(10),SDATE,110) as SDATE,CONVERT(VARCHAR(10),EDATE,110) as EDATE,* from RCOVER $wherenya ");
		$this->conInfo();
		$query=$this->query("SET ANSI_NULLS ON");
		$query=$this->query("SET ANSI_WARNINGS ON");
		$query=$this->query("select CONVERT(VARCHAR(10),SDATE,110) as SDATE,CONVERT(VARCHAR(10),EDATE,110) as EDATE, * from care.sea_panpacific.dbo.RCOVER $wherenya "); 
		if($query)
		{				 
			$pesan="1";
		}else
		{				 
			$pesan="0";
		}			
		return $pesan;
	}
}
class PROFILE extends panfic
{
	function select($wherenya)
	{
		//$this->conCare();
		//$query=$this->query("select top 300 * from Profile $wherenya ");
		$this->conInfo();
		$query=$this->query("SET ANSI_NULLS ON");
		$query=$this->query("SET ANSI_WARNINGS ON");
		$query=$this->query("select top 300 * from care.sea_panpacific.dbo.Profile $wherenya"); 
		if($query)
		{				 
			$pesan="1";
		}else
		{				 
			$pesan="0";
		}			
		return $pesan;
	}
	function get_data($wherenya)
	{
		//$this->conCare();
		//$this->query("select * from Profile $wherenya");
		$this->conInfo();
		$query=$this->query("SET ANSI_NULLS ON");
		$query=$this->query("SET ANSI_WARNINGS ON");
		$query=$this->query("select * from care.sea_panpacific.dbo.Profile $wherenya"); 
		$pecah=$this->tampil();

		$data = array(
			'name' => $pecah["Name"]
		);
		return $data;
	}
}
class location extends panfic
{
	function select ($wherenya)
	{
		// $this->conCare();
		// $query=$this->query("select * from Location $wherenya");
		$this->conInfo();
		$query=$this->query("SET ANSI_NULLS ON");
		$query=$this->query("SET ANSI_WARNINGS ON");
		$query=$this->query("select * from care.sea_panpacific.dbo.Location $wherenya"); 
		if($query)
		{				 
			$pesan="1";
		}else
		{				 
			$pesan="0";
		}			
		return $pesan;
	}
}
class ACCCLA extends panfic
{
	function select($wherenya)
	{
		// $this->conCare();
		// $this->query("select * from ACCCLA $wherenya ");
		$this->conInfo();
		$this->query("SET ANSI_NULLS ON");
		$this->query("SET ANSI_WARNINGS ON");
		$this->query("select * from care.sea_panpacific.dbo.ACCCLA $wherenya"); 
	}
}

class ACCBS extends panfic
{
	function select($wherenya)
	{
		// $this->conCare();
		// $query=$this->query("select * from ACCBS $wherenya ");
		$this->conInfo();
		$query=$this->query("SET ANSI_NULLS ON");
		$query=$this->query("SET ANSI_WARNINGS ON");
		$query=$this->query("select * from care.sea_panpacific.dbo.ACCBS $wherenya"); 
		if($query)
		{				 
			$pesan="1";
		}else
		{				 
			$pesan="0";
		}			
		return $pesan;
	}
}
class ICOVER extends panfic
{
	function select($wherenya)
	{
		// $this->conCare();
		// $query=$this->query("select * from ICOVER $wherenya ");
		$this->conInfo();
		$query=$this->query("SET ANSI_NULLS ON");
		$query=$this->query("SET ANSI_WARNINGS ON");
		$query=$this->query("select * from care.sea_panpacific.dbo.ICOVER $wherenya");
		if($query)
		{				 
			$pesan="1";
		}else
		{				 
			$pesan="0";
		}			
		return $pesan;
	}
}
class sPCLASS extends panfic
{
	function select($code)
	{
		// $this->conCare();
		// $this->query("select * from PCLASS where TOR in (select TOR from RATECOV where CODE = '$code')");
		$this->conInfo();
		$this->query("SET ANSI_NULLS ON");
		$this->query("SET ANSI_WARNINGS ON");
		$this->query("select * from care.sea_panpacific.dbo.PCLASS where TOR in (select TOR from RATECOV where CODE = '$code')");

	}
	function get_si($code,$ano)
	{

		// $this->conCare();
		// $this->query("select A.TOI,A.SI,A.REMARK from ICOVER A left join PCLASS B on A.TOI=B.TOI 
		// 	where TOR in (select TOR from RATECOV where CODE = '$code') and ANO='$ano' and A.SI<>0");
		$this->conInfo();
		$this->query("SET ANSI_NULLS ON");
		$this->query("SET ANSI_WARNINGS ON");
		$this->query("select A.TOI,A.SI,A.REMARK from care.sea_panpacific.dbo.ICOVER A left join PCLASS B on A.TOI=B.TOI 
		 	where TOR in (select TOR from RATECOV where CODE = '$code') and ANO='$ano' and A.SI<>0");
		$pecah=$this->tampil();

		$data = array(
			'si' => $pecah["SI"],
			'remark'=>$pecah["REMARK"]
		);
		return $data;
	}
}
class SURVEYOR extends panfic
{
	function select($wherenya)
	{
		$this->conCare();
		$this->query("select * from SURVEYOR $wherenya ");
	}
}

?>