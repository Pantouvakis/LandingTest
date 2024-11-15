<?php
  $receiving_email_address = 'info@karpadu.com';

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    die( 'Unable to load the "PHP Email Form" Library!');
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;
  
  $contact->to = $receiving_email_address;
  $contact->from_name = $_POST['name'];
  $contact->from_email = $_POST['email'];
  $contact->subject = $_POST['subject'];

  require 'vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

  $contact->smtp = array(
    'host' => getenv('SMTP_HOST'),
    'username' => getenv('SMTP_USERNAME'),
    'password' => getenv('SMTP_PASSWORD'),
    'port' => '587'
  );
  

  $contact->add_message( $_POST['name'], 'From');
  $contact->add_message( $_POST['email'], 'Email');
  $contact->add_message( $_POST['message'], 'Message', 10);

 try {
    echo $contact->send();
} catch (Exception $e) {
    die('Error: Unable to send the email. Please try again later.');
}
?>
