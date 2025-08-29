<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome     = $_POST['nome'] ?? '';
    $data     = $_POST['data'] ?? '';
    $problema = $_POST['problema'] ?? '';
    $mensagem = $_POST['msg'] ?? '';

    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor
        $mail->isSMTP();
        $mail->Host       = 'mail.rsweb.com.br'; // SMTP do seu provedor
        $mail->SMTPAuth   = true;
        $mail->Username   = 'comercial@rsweb.com.br'; // E-mail de envio
        $mail->Password   = 'nisexandi2';               // Senha do e-mail
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        // Remetente e destinatário
        $mail->setFrom('comercial@rsweb.com.br', 'Formulário de Triagem');
        $mail->addAddress('comercial@rsweb.com.br', 'Comercial');

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = "Nova triagem: $problema - $nome";
        $mail->Body    = "
            <strong>Nome:</strong> $nome<br>
            <strong>Data do Voo:</strong> $data<br>
            <strong>Problema:</strong> $problema<br>
            <strong>Mensagem:</strong><br>$mensagem
        ";

        $mail->send();
                // Alerta e redirecionamento
        echo "<script>
            alert('E-mail enviado com sucesso, em breve nossos advogados entrarão em contato.');
            window.location.href = 'index.php';
        </script>";
        exit;
    } catch (Exception $e) {
        echo "<script>
            alert('Erro ao enviar e-mail: {$mail->ErrorInfo}');
            window.location.href = 'index.php';
        </script>";
        exit;
    }
}
?>