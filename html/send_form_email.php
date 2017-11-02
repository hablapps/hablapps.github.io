<?php

  require_once "recaptchalib.php";

  // Finalizacion con mensaje de error.
  function died($error) {
    echo "<html><body><h1>Ops!</h1>";
    echo "We are sorry, there exist some mistakes in the data you introduced.<br />";
    echo "Details:<br /><br />";
    echo $error."<br /><br />";
    echo "Please, <a href='#' onclick='window.history.back();return false;'>correct this mistakes and try again.</a>";
    echo "</body></html>";
    http_response_code(500);
  }

  // Validacion de campos obligatorios
  function checkMandatoryFieldsAndExit(&$first, &$last, &$email, &$mess) {
    if(empty($first) || empty($last) || empty($email) || empty($mess)) {
      died('&nbsp;&nbsp; * You must fill all required fields: firstname:*'. $_POST['first_name'] .'*, lastname:*'. $_POST['last_name'] .'*, email:*'. $_POST['email'] .'*, telephone:*'. $_POST['telephone'] .'*, message:*'. $_POST['message'] .'* <br />');
    }
  }

  function auxAssignIfNonEmpty(&$item, $default){
    return (!empty($item)) ? $item : $default;
  }

  function sendMail($first_name, $last_name, $email_from, $telephone, $message){

    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }

    // Constantes
    // $email_to = "info@hablapps.com";
    $email_to = "juanmanuel.serrano.hidalgo@gmail.com";
    $email_subject = "Request to contact from hablapps.com";

    //Contenido
    $email_message = "<html><body><h1>Contact data:</h1>";
    $email_message .= "<b>Name: </b>".clean_string($first_name)."<br />";
    $email_message .= "<b>Family name: </b>".clean_string($last_name)."<br />";
    $email_message .= "<b>Email: </b>".clean_string($email_from)."<br />";
    $email_message .= "<b>Phone number: </b>".clean_string($telephone)."<br />";
    $email_message .= "<b>Message: </b><br />".clean_string($message)."<br /></body></html>";

    //Cabeceras //
    $headers = 'Reply-To: '.$email_from."\r\n".
      'Content-type: text/html; charset=iso-8859-1'."\r\n".
      'X-Mailer: PHP/'.phpversion();

    $mail = mail($email_to, $email_subject, $email_message, $headers);
    if(!$mail){
      echo "<html><body><h1>Ops!</h1>";
      echo "This server is experiencing technical problems.<br />";
      echo "</body></html>";
      http_response_code(500);
    }
  }

  // Alla vamos!

  // $lang = "en";
  $resp = null;
  // $error = null;
  $reCaptcha = new ReCaptcha("6LdLri8UAAAAAIGRw7BoAJDooRTTs8p9jP325SNP");
  if ($_POST["g-recaptcha-response"]) {
    $resp = $reCaptcha->verifyResponse(
      $_SERVER["REMOTE_ADDR"],
      $_POST["g-recaptcha-response"]
    );
  } else {
    died("Recaptcha Not submitted");
  }
  if ($resp != null && $resp->success) {
    echo "Recaptcha Verification Success";

    // Antes de procesar, aseguramos obligatorios
    checkMandatoryFieldsAndExit($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['message']);

    // Parametros
    // Obligatorios
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email_from = $_POST['email'];
    $message = $_POST['message'];
    // Opcionales
    $telephone = auxAssignIfNonEmpty($_POST['telephone'], 'Undefined');

    //Envio del email
    sendMail($first_name, $last_name, $email_from, $telephone, $message);
  } else {
    died("Recaptcha Verification Error");
  }
?>
