<?php
//index.php

$message = '';

function clean_text($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}

if(isset($_POST["submit"]))
{
	$path = 'upload/' . $_FILES["resume"]["name"];
	move_uploaded_file($_FILES["resume"]["tmp_name"], $path);
	$message = '
		<meta charset="UTF-8">
		<h3 align="center">Programmer Details</h3>
		<table border="1" width="100%" cellpadding="5" cellspacing="5">
			<tr>
				<td width="30%">Họ và tên</td>
				<td width="70%">'.html_entity_decode($_POST["name"]).'</td>
			</tr>
			<tr>
				<td width="30%">Lớp</td>
				<td width="70%">'.$_POST["class"].'</td>
			</tr>
			<tr>
				<td width="30%">Trường</td>
				<td width="70%">'.$_POST["school"].'</td>
			</tr>
			<tr>
				<td width="30%">Additional Information</td>
				<td width="70%">'.$_POST["additional_information"].'</td>
			</tr>
		</table>
	';
	
	require 'class/class.phpmailer.php';
	$mail = new PHPMailer;
	$mail->IsSMTP();								//Sets Mailer to send message using SMTP
	$mail->Host = 'smtp.mailtrap.io';		//Sets the SMTP hosts of your Email hosting, this for Godaddy
	$mail->Port = '587';								//Sets the default SMTP server port
	$mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables
	$mail->Username = '9a71cead9af9ba';					//Sets SMTP username
	$mail->Password = '7397269acf0581';					//Sets SMTP password
	$mail->SMTPSecure = '';							//Sets connection prefix. Options are "", "ssl" or "tls"
	$mail->FromName = utf8_decode($_POST["name"]);				//Sets the From name of the message
	$mail->AddAddress('baoquyhuy@gmail.com', 'Bao Quy Huy');		//Adds a "To" address
	$mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
	$mail->IsHTML(true);							//Sets message type to HTML
	$mail->AddAttachment($path);					//Adds an attachment from a path on the filesystem
	$mail->Subject = 'Application for Programmer Registration';				//Sets the Subject of the message
	$mail->Body = $message;							//An HTML or plain text message body
	if($mail->Send())								//Send an Email. Return true on success or false on error
	{
		$message = '<div class="alert alert-success">Application Successfully Submitted</div>';
		unlink($path);
	}
	else
	{
		$message = '<div class="alert alert-danger">There is an Error</div>';
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Bài tập</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<div class="row">
				<div class="col-md-8" style="margin:0 auto; float:none;">
					<h3 align="center">Nộp bài tập</h3>
					<br />
					<h4 align="center">Điền đầy đủ thông tin trong biểu mẫu</h4><br />
					<?php print_r($message); ?>
					<form method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Họ và tên</label>
									<input type="text" name="name" placeholder="Họ và tên" class="form-control" required />
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Lớp</label>
									<select name="class" class="form-control" required>
										<option value="">Chọn lớp</option>
										<option value="10/2">10/2</option>
										<option value="10/3">10/3</option>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Trường</label>
									<input type="text" name="school" placeholder="Nhập trường" class="form-control" required />
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Chọ file đính kèm</label>
									<input type="file" name="resume" accept=".doc,.docx, .pdf, .png, .jpg, .jpeg" required />
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Ghi chú</label>
									<textarea name="additional_information" placeholder="Ghi chú" class="form-control" required rows="8"></textarea>
								</div>
							</div>
						</div>
						<div class="form-group" align="center">
							<input type="submit" name="submit" value="Gửi" class="btn btn-info" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>





