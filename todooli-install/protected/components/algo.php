<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class Algo extends CUserIdentity
{
	function encrypt($string)
	{
		
		$sKey = "8866385527";
		$result=$string.$sKey;
		//base64_encode($result);exit;
		$data=base64_encode($result);
		return str_replace("=",'',$data);
	}
	
	function decrypt($string)
	{
		/*$userObj=new User();
		$userObj->id=$string;
		$sKeyarray=$userObj->getRow('phoneNumber');
		$sKey=$sKeyarray['phoneNumber'];*/
		$sKey = "8866385527";
		$res=base64_decode($string);
		$result=explode($sKey,$res);
		return $result[0];
	} 	
}