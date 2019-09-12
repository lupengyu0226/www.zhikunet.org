<?php
session_start();
$aResponse['error'] = false;
$_SESSION['ihuadong'] = false;	
if(isset($_POST['action']))
{
	if(htmlentities($_POST['action'], ENT_QUOTES, 'UTF-8') == 'huadong')
	{
		$_SESSION['ihuadong'] = true;
		if($_SESSION['ihuadong'])
			echo json_encode($aResponse);
		else
		{
			$aResponse['error'] = true;
			echo json_encode($aResponse);
		}
	}
	else
	{
		$aResponse['error'] = true;
		echo json_encode($aResponse);
	}
}
else
{
	$aResponse['error'] = true;
	echo json_encode($aResponse);
}