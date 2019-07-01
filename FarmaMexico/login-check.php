<?php
ob_start();
require_once "config/database.php";
require_once  "../../Classes/PHPExcel.php"; 
$username = mysqli_real_escape_string($mysqli, stripslashes(strip_tags(htmlspecialchars(trim($_POST['username'])))));
$password = sha1(mysqli_real_escape_string($mysqli, stripslashes(strip_tags(htmlspecialchars(trim($_POST['password']))))));

if (!ctype_alnum($username) OR !ctype_alnum($password)) {
	header("Location: index.php?alert=1");
}
else {

	$query = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE username='$username' AND password='$password' AND status='activo'")
									or die('error'.mysqli_error($mysqli));
	$rows  = mysqli_num_rows($query);

	if ($rows > 0) {
		$data  = mysqli_fetch_assoc($query);

		session_start();
		$_SESSION['id_user']   = $data['id_user'];
		$_SESSION['username']  = $data['username'];
		$_SESSION['password']  = $data['password'];
		$_SESSION['name_user'] = $data['name_user'];
		$_SESSION['permisos_acceso'] = $data['permisos_acceso'];
		
		$objPHPExcel = new PHPExcel;

                     
         $inputFileName = $_SERVER['DOCUMENT_ROOT']."/home3/cuartapr/AuditoriAcceso.xls";
         echo '<script language="javascript">alert("'.$inputFileName.'");</script>';

         $objReader = PHPExcel_IOFactory::createReader('Excel2007');
         $objPHPExcel = $objReader->load($inputFileName);
         $objPHPExcel->setActiveSheetIndex(0);

         $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

         $objWorksheet->insertNewRowBefore($num_rows + 1, $_SESSION['username']  );

         $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	     $objWriter->save($inputFileName);

		$referenciaPagina = 'main.php?module=start';
		header("Location:$referenciaPagina");
	}


	else {
		header("Location: index.php?alert=1");
	}
}
?>