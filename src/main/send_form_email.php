<?php

  // Finalizacion con mensaje de error.
  function died($error) {
    echo "We are sorry, there exist some mistakes in the data you introduced.<br />";
    echo "Details:<br /><br />";
    echo $error."<br /><br />";
    echo "Please, correct this mistakes and try again.";
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
    $email_to = "ssaugar@gmail.com"; //info@hablapps.com
    $email_subject = "Contacto desde web HablaComputing"; 

    //Contenido
    $email_message = "Content.\n\n";
    $email_message .= "Name: ".clean_string($first_name)."\n";
    $email_message .= "Family name: ".clean_string($last_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Phone number: ".clean_string($telephone)."\n";
    $email_message .= "Message: ".clean_string($message)."\n";
     
    //Cabeceras 
    $headers = 'From: '.$email_from."\r\n".
      'Reply-To: '.$email_from."\r\n".
      'Content-type: text/html; charset=iso-8859-1'."\r\n".
      'X-Mailer: PHP/'.phpversion();
 
    $mail = mail($email_to, $email_subject, $email_message, $headers);
    if($mail){
      echo "Thank you. We will contact you as soon as possible.";
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
  $telephone = auxAssignIfNonEmpty($_POST['telephone'], 'No facilitado');

  // Antes de seguir, comprobamos las validaciones
  checkDataConstraints(
    checkValidString($first_name, '&nbsp;&nbsp; * The name format is not valid<br />'),
    checkValidString($last_name, '&nbsp;&nbsp; * The family name format is not valid.<br />'),
    checkEmail($email_from),
    checkMessageLong($message));

  //Envio del email
  sendMail($first_name, $last_name, $email_from, $telephone, $message)
?>

  

