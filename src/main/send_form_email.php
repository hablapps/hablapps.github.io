<?php

  // Finalizacion con mensaje de error.
  function died($error) {
    echo "<html><body><h1>Ops!</h1>";
    echo "We are sorry, there exist some mistakes in the data you introduced.<br />";
    echo "Details:<br /><br />";
    echo $error."<br /><br />";
    echo "Please, <a href='#' onclick='window.history.back();return false;'>correct this mistakes and try again.</a>";
    echo "</body></html>";
    die();
  }
 
  // Validacion de campos obligatorios
  function checkMandatoryFieldsAndExit(&$first, &$last, &$email, &$mess) {
    if(empty($first) || empty($last) || empty($email) || empty($mess)) {
      died('&nbsp;&nbsp; * You must fill all required fields. <br />');      
    }
  }

  // Validacion del email
  function checkEmail($email){
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    if(!preg_match($email_exp,$email)) {
      return '&nbsp;&nbsp; * The email address is not valid.<br />';
    } else {
      return '';
    }
  }

  // Validacion de caracteres en cadenas de texto
  function checkValidString($st, $error){
    $string_exp = "/^[A-Za-z .'-]+$/";
    if(!preg_match($string_exp,$st)) {
      return $error;
    } else {
      return '';
    }
  }

  // Validacion de la longitud del mensaje
  function checkMessageLong($message){
    if(strlen($message) < 2) {
      return '&nbsp;&nbsp; * The message format is not valid.<br />';
    } else {
      return '';
    }
  }

  function auxAssignIfNonEmpty(&$item, $default){
    return (!empty($item)) ? $item : $default;
  }
 
  function checkDataConstraints($errorFN, $errorLN, $errorEM, $errorML){
    $error_message = $errorFN. $errorLN. $errorEM. $errorML;
    if(strlen($error_message) > 0) {
      died($error_message);
    }
  }

  function sendMail($first_name, $last_name, $email_from, $telephone, $message){
    
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }

    // Constantes
    $email_to = "info@hablapps.com";
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
    if($mail){
      echo "<html><body><h1>Congratulations!</h1>";
      echo "Thank you. We will contact you as soon as possible.<br /><br />";
      echo "Go <a href='#' onclick='window.history.back();return false;'>back</a>";
      echo "</body></html>";
    } else {
      died("We can't send you're email, please try again in a few minutes."); 
    }
  }



  // Alla vamos!


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

  // Antes de seguir, comprobamos las validaciones
  checkDataConstraints(
    checkValidString($first_name, '&nbsp;&nbsp; * The name format is not valid<br />'),
    checkValidString($last_name, '&nbsp;&nbsp; * The family name format is not valid.<br />'),
    checkEmail($email_from),
    checkMessageLong($message));

  //Envio del email
  sendMail($first_name, $last_name, $email_from, $telephone, $message)
?>

  

