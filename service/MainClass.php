<?php

class panfic
{
	var $konek;
	var $selectDb;
	var $query ;
	var $result ;
	var $row;
	var $jumlah ;
	
	function conCare()
	{

		// mssql_connect("192.168.0.159","panfic","gakjelas");
		// mssql_select_db("SEA_PANPACIFIC");//live

		mssql_connect("192.168.0.100","panfic","panfic");
		mssql_select_db("SEA_REPORTING");//reporting data h-1

		/*mssql_connect("192.168.0.200","panfic","panfic");
		mssql_select_db("SEA_PANPACIFIC");//testing 200*/
		/*print_r($query);
		exit;*/
	} 
	function conCare2()
	{

		// mssql_connect("192.168.0.159","panfic","gakjelas");
		// mssql_select_db("SEA_PANPACIFIC");//live

		mssql_connect("192.168.0.100","panfic","panfic");
		mssql_select_db("SEA_REPORTING");//reporting data h-1

		/*mssql_connect("192.168.0.200","panfic","panfic");
		mssql_select_db("SEA_PANPACIFIC");//testing 200*/
		/*print_r($query);
		exit;*/
	} 
	function conCare200()
	{

		// mssql_connect("192.168.0.159".'\/'."MSSQLEXPRESS","panfic","gakjelas");
		// mssql_select_db("SEA_PANPACIFIC");//live

		mssql_connect("192.168.0.200","panfic","panfic");
		mssql_select_db("SEA_PANPACIFIC2");//reporting data h-1

		
	} 
	function conAzure()//ini buat testing aja setelah berhasil di haus aja
	{
		mssql_connect("13.76.91.222","panfic","gakjelas");
		mssql_select_db("SEA_PANPACIFIC");//reporting data h-1		
	} 
	function conInfo()
	{
		mssql_connect("192.168.0.99","panfic","!p@nf1c$");
		mssql_select_db("INFORMATION_CENTER");

		/*mssql_connect("192.168.0.99","panfic","!p@nf1c$");
		mssql_select_db("INFORMATION_CENTER_2");*/
		
	}
	function query($query){
		//$query = $this->result = mssql_query("SET ANSI_NULLS ON;");
 		//$query = $this->result = mssql_query("SET ANSI_WARNINGS ON;");
 			
		$query = $this->result = mssql_query($query);
		//return $this->query;
		return $query;
	}
	function tampil(){
		$query=$this->row=mssql_fetch_array($this->result);
	return $query;//$this->row;
	}
 	function view()//fungsi menampilkan data
 	{
 	$this->row = mssql_fetch_object($this->result);
 	return $this->row;
 	}
 
    function tampil_row()//fungsi menampilkan jumlah data
    {
    	$query=$this->row=mssql_num_rows($this->result);
    	return $query;
      //$this->jumlah = mssql_num_rows($this->result);
      //return $this->jumlah;
    }

     function get($table)//fungsi select
     {
     	$this->result = mssql_query("SELECT * FROM ".$table);
     	return $this->result;
     }
	function cari($table , $where)//fungsi cari
	{
		$this->result = mssql_query("SELECT * FROM ".$table." ".$where);
		return $this->result;
	}
	function notalin($field , $as , $table , $where){
		$this->result = mssql_query("select sum".$field."as".$as."from".$table."where".$where);
	}

	function getJumlahFromTable($table)
	{
		$this->get($table);
		return $this->getJumlah();
	}

     function insert($table,$data)//fungsi insert
     {
     	$i=0;
     	foreach ( $data as $kolom =>$value )
     	{				
     		$i;
     		if($i >'0'){$k =",";}				
     		$nilai = "'".$value."'";
     		$field= $field.$k.$kolom;				
     		$hasil=$hasil.$k.$nilai;				
     		$i++;				
     	}
     	$query = $this->result=mssql_query("insert into ".$table." (".$field.") values (".$hasil.")");
			return $query;//$this->result;
		}

    function update($table , $data , $where)//fungsi update
    {
    	$i=0;
    	foreach ( $data as $kolom =>$value)
    	{				
    		$i;
    		if($i >'0'){$k =",";}				
    		$nilai = "'".$value."'";
    		$field= $field.$k.$kolom."=".$nilai;							
    		$i++;				
    	}
    	$query=$this->result=mssql_query("UPDATE ".$table." SET " .$field." ".$where);
		return $query;//$this->result;
	}

    function delete($table , $where)//fungsi delete
    {
    	$query=$this->query("DELETE FROM ".$table." ".$where);
		return $query;//return $this->result;
	}

	function select($table , $where)//fungsi delete
    {
    	$query=$this->query("SELECT * FROM ".$table." ".$where);
		return $query;
	}
}
?>