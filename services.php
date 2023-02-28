<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

/**
 * Class Mailer
 */
class Mailer
{
    /**
     * @var string $host
     */
    private string $host;

    /**
     * @var bool $smtpAuth
     */
    private bool $smtpAuth;

    /**
     * @var string $username
     */
    private string $username;

    /**
     * @var string $password
     */
    private string $password;

    /**
     * @var string $smtpSecure
     */
    private string $smtpSecure;

    /**
     * @var int $port
     */
    private int $port;

    /**
     * Mailer constructor.
     * @param string $host
     * @param bool $smtpAuth
     * @param string $username
     * @param string $password
     * @param string $smtpSecure
     * @param int $port
     */
    public function __construct($host, $smtpAuth,  $username,  $password,  $smtpSecure, int $port)
    {
        $this->host = $host;
        $this->smtpAuth = $smtpAuth;
        $this->username = $username;
        $this->password = $password;
        $this->smtpSecure = $smtpSecure;
        $this->port = $port;
    }

    /**
     * @param  $from
     * @param  $to
     * @param  $body
     * @throws Exception
     */
    public function send($from,  $to,  $body)
    {
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

if(isset($_POST["submit"])){
    $mailer = new Mailer('smtp.gmail.com', true, 'gauravrocksd5@gmail.com', 'aoculiwjcnrqixfv', 'ssl', 465);

    $from = 'gauravrocksd5@gmail.com';
    $to = $_POST["email"];
    $body = $_POST["message"];

    $mailer->send($from, $to, $body);

    echo "
    <script>
    alert('Sent successfullly');
    document.location.href = 'i.php';
    </script>
    ";
}
