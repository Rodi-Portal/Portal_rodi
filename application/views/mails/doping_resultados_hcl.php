<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Drug test results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        /* .card {
            max-width: 350px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f0f0f0;
            border: 1px solid #fff2;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        } */
        .card {
          margin: 0 auto;
          padding: 20px;
          width: 300px;
          border: 1px solid #8d8e8f;
          border-radius: 10px;
        }
        #logo {
            text-align: center;
            margin-bottom: 20px;
        }
        #message {
            text-align: justify;
            padding: 20px;
            border-radius: 10px;
        }
        #footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="card">
      <div id="logo">
          <img src="https://i.ibb.co/fdyb04r/logo.png" alt="Logo de la empresa" width="150px"/>
      </div>
      <div id="message">
          <p><b>Hello,</p>
          <p>We are pleased to inform you that we have received the results of <?php echo $candidato; ?>'s drug test and it is possible to consult them on our <a href="https://rodicontrol.rodi.com.mx">RODICONTROL platform</a>.</p>
          <p>We provide the following email accounts: bramirez@rodicontrol.com, lgonzalez@rodicontrol.com to receive your comments.</p>
      </div>
      <div id="footer">
          <p>&copy; <?php echo date('Y'); ?>  RODI - PERINTEX. All rights reserved.</p>
          <small>This email was sent automatically, do not reply to this email.</small>
      </div>
    </div>
</body>
</html>
