<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

/**
 * Defines a Mailer class.
 */
class Mailer {

  /**
   * The SMTP host name.
   *
   * @var string
   */
  private string $host;

  /**
   * Indicates whether SMTP authentication is required.
   *
   * @var bool
   */
  private bool $smtpAuth;

  /**
   * The username used for SMTP authentication.
   *
   * @var string
   */
  private string $username;

  /**
   * The password used for SMTP authentication.
   *
   * @var string
   */
  private string $password;

  /**
   * The SMTP encryption type.
   *
   * @var string
   */
  private string $smtpSecure;

  /**
   * The SMTP port number.
   *
   * @var int
   */
  private int $port;

  /**
   * Mailer constructor.
   *
   * @param string $host
   *   The SMTP host name.
   * @param bool $smtpAuth
   *   Indicates whether SMTP authentication is required.
   * @param string $username
   *   The username used for SMTP authentication.
   * @param string $password
   *   The password used for SMTP authentication.
   * @param string $smtpSecure
   *   The SMTP encryption type.
   * @param int $port
   *   The SMTP port number.
   */
  public function __construct(string $host, bool $smtpAuth, string $username, string $password, string $smtpSecure, int $port) {
    $this->host = $host;
    $this->smtpAuth = $smtpAuth;
    $this->username = $username;
    $this->password = $password;
    $this->smtpSecure = $smtpSecure;
    $this->port = $port;
  }

  /**
   * Sends an email message.
   *
   * @param string $from
   *   The email address of the sender.
   * @param string $to
   *   The email address of the recipient.
   * @param string $body
   *   The message body.
   *
   * @throws Exception
   *   Thrown if an error occurs while sending the email.
   */
  public function send(string $from, string $to, string $body): void {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = $this->host;
    $mail->SMTPAuth = $this->smtpAuth;
    $mail->Username = $this->username;
    $mail->Password = $this->password;
    $mail->SMTPSecure = $this->smtpSecure;
    $mail->Port = $this->port;

    $mail->setFrom($from);
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Body = $body;

    $mail->send();
  }

}

if(isset($_POST["submit"])) {
  $mailer = new Mailer('smtp.gmail.com', true, 'gauravrocksd5@gmail.com', 'aoculiwjcnrqixfv', 'ssl', 465);

  $from = 'gauravrocksd5@gmail.com';
  $to = $_POST["email"];
  $body = $_POST["message"];

  $mailer->send($from, $to, $body);

  echo "
  <script>
  alert('Sent successfullly');
  </script>
    ";
}
?>
