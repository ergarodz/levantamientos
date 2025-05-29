<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

require 'vendor/autoload.php';

class EmailController {

	public  function  guardarDatos() {
		$fup=$_REQUEST['fup'];
		$usuario=$_REQUEST['usuario'];
		$tipo=$_REQUEST['tipo'];
		$para=$_REQUEST['correo_destino'];
		$encabezado=''; 
        $tema='Asociado al FUP= '.$fup.' <br>Por el usuario: '.$usuario ;
		if($tipo=='Salida'){
			$encabezado='Se ha registrado una salida de equipo en el Sistema de Levantamientos Topográficos';
		}
        elseif($tipo=='Enviado a Topografía'){
            $encabezado='Se ha registrado un FUP como enviado al área de topografía';
        }
        else{
			$encabezado='Se ha registrado una entrega de equipo en el Sistema de Levantamientos Topográficos';			
		}

		$datosController = array("fup" => $fup, 
								 "usuario" => $usuario,
								 "encabezado" => $encabezado,
								 "para"=>$para,
								 "tema"=>$tema
								);		

		$senemail = EmailController::correo($datosController); //eviar correo 
        //return $senemail;
        return true;

		// if($senemail != 'error'){
		// 	echo '<script>
		// 			swal("Datos guardados, gracias por comunicarte con nosotros")
		// 			.then(() => {
		// 				window.location.href = "index.php";
		// 			});
		// 		 </script>';
		// }else{
		// 	echo '<script>
		// 			swal("Error")
		// 			.then(() => {
		// 				window.location.href = "index.php";
		// 			});
		// 		 </script>';
		// }	
	}

	public function correo($datos){
		date_default_timezone_set('America/Mexico_City');
        setlocale(LC_ALL,"es_ES");

		$fecha = date("d-m-Y");

		//$para = 'itzelsalas95@gmail.com'; //local
		//$para = "adriana.figueroa@igecem.gob.mx";	//producción cambiar
		$para=$datos["para"];
		
		$titulo  = 'Levantamientos Topográficos ('.$datos["fup"].')';
		$mensaje = '<html lang="es">
                        <head>
                            <title>IGECEM</title>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1">
                            <!--===============================================================================================-->  
                            
                            <!--===============================================================================================-->
                            <style type="text/css">
                                .container {
                                    /*padding: 1% 15% 1% 1%;
                                    margin: 1%;*/
                                    margin: 1% 5% 1% 3%;
                                    text-align: center;
                                    
                                }
                                .head {
                                    /*text-align: center;*/
                                    padding: 0% 1% 0% 1%;
                                    margin: 1%;
                                }
                                #imgtitle-1 {
                                    width: 12%;
                                    margin-right: 15%;
                                }

                                #imgtitle-2 {
                                    width: 22%;
                                    padding: 10px;
                                    margin-left: 15%;
                                }

                                #imgtitle-3  {
                                    width: 3%;
                                    padding-left: 10%;
                                }

                                #imgtitle-4 {
                                    width: 10%;
                                }

                                #linecolor {
                                    margin-left: -4%;
                                    width: 66%;
                                }

                                .date {
                                    /*text-align: justify;
                                    margin: 1% 15% 1% 19%; a la izquierda*/  
                                    text-align: right;
                                    margin: 1% 20% 1% 20%;
                                }

                                .date h3 {
                                    padding: 8px;
                                    font-size: 15px;
                                    margin-left: 2%;
                                }

                                .datos h3 {
                                    padding: 8px;
                                    font-size: 20px;
                                    margin-left: 2%;
                                    /*text-align: justify*/
                                }

                                .datos h2 {
                                    padding: 8px;
                                    font-size: 18px;
                                    margin-left: 2%;
                                }

                                .msg {
                                    margin: 3% 22% 7% 20%;
                                }

                                .msg p {
                                    text-align: justify;
                                    font-family: "arial";
                                }

                                #imgfooter {
                                    margin-left: 1%;
                                    padding: 1%;
                                    width: 62%;
                                }
                            </style>                            
                        </head>

                        <body>
                            <div class="container">
                                <div class="head">

                                    <img id="imgtitle-1" src="https://atencionigecem.edomex.gob.mx/img/escudo.png">
                                    <img id="imgtitle-2" src="https://atencionigecem.edomex.gob.mx/img/edomex_igecem.png">

                                    <!--<img id="imgtitle-3" src="https://atencionigecem.edomex.gob.mx/img/igecem.png">solo igecem para veda-->  
                                </div>
                                <img id="linecolor" src="https://atencionigecem.edomex.gob.mx/img/linea-colorOK23.png">
                
                                <section class="info">
                                    <div class="date">
                                        <h3>'.$fecha.'</h3>
                                    </div>

                                    <div class="datos">
                                        <h3>'.$datos["encabezado"].'</h3>                                        
                                    </div>

                                    <hr style="margin-left: 18%; width: 62%;">

                                    <div class="msg">
										<br><br>
                                        <h2>'.utf8_decode($datos["tema"]).'  </h2><br><br>
										<h3>Para seguimiento y más detalles entrar dando clic en: <br><a href="https://levantamientostopograficos.edomex.gob.mx/">Sistema de Levantamientos Topográficos</a> </h3>
										<hr>
                                        <br><br><br><br><br><br><br>
                                        <p><i>Este es un correo automatizado. Por favor no responda al mismo.</i></p>
                                    </div>
                                </section>
                                
                                <img id="linecolor" src="https://atencionigecem.edomex.gob.mx/img/linea-colorOK23.png">
                    
                            </div>
                        </body>
                    </html>';

		$mail = new PHPMailer();

		$mail->isSMTP();

		$mail->SMTPDebug = SMTP::DEBUG_OFF;

		$mail->Host = 'smtp.gmail.com';

		$mail->Port = 587;

		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

		$mail->SMTPAuth = true;

		$mail->AuthType = 'XOAUTH2';

		$mail->CharSet = 'UTF-8';

		/////datos de la cuenta donde se envía
		$email = 'igecem.informes@gmail.com';
		$clientId = '842100958471-35bmcvuav0qa9ljkfjkmoe1c3c6j9sau.apps.googleusercontent.com';
		$clientSecret = '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';

		$refreshToken = '1//0fhJhcmV3jEb0CgYIARAAGA8SNwF-L9IrxCB2j7ZqLMYn5OZ579ejPLPrrtlOxbvYCnHrgfMszFwGml6RYVL0wDhmleOiNwDsUZE';

		$provider = new Google(
			[
				'clientId' => $clientId,
				'clientSecret' => $clientSecret,
			]
		);

		$mail->setOAuth(
			new OAuth(
				[
					'provider' => $provider,
					'clientId' => $clientId,
					'clientSecret' => $clientSecret,
					'refreshToken' => $refreshToken,
					'userName' => $email,
				]
			)
		);

		$mail->setFrom($email, 'IGECEM (Sistema de Levantamientos Topográficos)');
		$mail->addAddress($para);
		$mail->isHTML(true);
		$mail->Subject = $titulo;
		$mail->Body = $mensaje;
		//send the message, check for errors
		if ( $mail->send()) {
			return true;
		} else {
			return false;
		}
	}


}