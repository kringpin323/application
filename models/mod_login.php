<?php
class Mod_login extends CI_Model {

	  function __construct()
	  { 
	  	  $this->config->load('config');
		  $this->load->database();
	  }
	  
	  function checking($vname,$vpasswd)	
	  {
		  //初始化错误信息
		  $_SESSION['nameword']=0;
		  if($vname==false || $vpasswd==false)
		  {
			 	$_SESSION['nameword']='用户名或密码为空了！';
			  	return false; 
		  }
		  else 
		  {
		  	//将用户输入密码加密后与数据库中存储密码配对
				// $key = $this->config->item('encryption_key');  	 
			  // $sql="SELECT uid,uname from useman where uname = '$vname' and encryptedpassword = AES_ENCRYPT('$vpasswd','Jb83MUhY01')";
				$sql="SELECT uid,uname from useman where uname = '$vname' and encryptedpassword = '$vpasswd'";
			    
		  		 $query=$this->db->query($sql);
				 if($query->num_rows()==0)
				 {
					 $_SESSION['nameword']='用户名或密码错误了！';
					 return false;
				 }	
				 else 
				 {
					 $row=$query->row_array();
					 $_SESSION['lzduser']=$row['uid'];
					 $_SESSION['lzdusername']=$row['uname'];
					 return true;
				 }
		  }
		 
	  }
  
}