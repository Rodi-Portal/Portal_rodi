<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>

<body style="margin:0; padding:0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" bgcolor="#F0F0F0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<!-- 100% background wrapper (grey background) -->
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0" style="border-spacing: 0;">
  <tr>
    <td align="center" valign="top" bgcolor="#F0F0F0" style="background-color: #F0F0F0;">
      <br>
      <table border="0" width="600" cellpadding="0" cellspacing="0" class="container" style="width:600px;max-width:600px;border-spacing: 0;">
        <tr>
          <td class="container-padding header" align="center" style="padding-bottom:12px;color:#DF4726;padding-left:24px;padding-right:24px; border-collapse: collapse;">
            <img src="https://i.ibb.co/fdyb04r/logo.png" alt="RODI" title="Servicios de Recursos Humanos" style="-ms-interpolation-mode: bicubic;" >
          </td>
        </tr>
        <tr>
          <td class="container-padding content" align="left" style="padding-left:24px;padding-right:24px;padding-top:7px;padding-bottom:12px;background-color:#ffffff; border-collapse: collapse;">
            <br>

            <div class="body-text" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:black;">
              <?php echo $cliente.' has started a process through our platform.' ?> Please, register your data in this <b><a href="rodicontrol.rodi.com.mx" style="font-size: 13px;">form</a>.</b>
              <br><br>
              Your access credentials are: <br>
              Email: <strong><?php echo $email; ?></strong><br>
              Password: <strong><?php echo $password; ?></strong>
              <br><br>
              Your information are required in two steps: <br>
              <ul>
                <li>1) You must log in the platform with your credentials and complete the form. At the time the form is completed and send, you must clic on "Go to documents upload" button , </li>
                <li>2) Then, you must upload your documents and if all required data is completed, you can clic on "finish all" button .</li>
                <li>Note: You will have access until complete your information. If you clic on "finish all" button, you will log out of the platform automatically and if you need to access again, you must ask for a new password.</li>
              </ul>
              <br><br>
              Please answer this form as soon as possible. If you experience any problem to access or while filling the form, please let us know, and we will gladly help you. lgonzalez@rodi.com.mx
            </div>

          </td>
        </tr>
        <tr>
          <td class="container-padding footer-text" align="left" style="font-family:Helvetica, Arial, sans-serif;font-size:12px;line-height:16px;color:black;padding-left:24px;padding-right:24px; border-collapse: collapse;">
            <br><br>
            &copy; <?php echo date('Y'); ?> RODI. All rights reserved.
            <br><br>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>


</body>
</html>