<?php
/**
 * Sistema de Envio de Emails com PHPMailer
 */
 
 // Configurações de segurança
class SecurityConfig {
    const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
    const ALLOWED_FILE_TYPES = [
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'txt' => 'text/plain'
    ];
    
    const MAX_EMAILS_PER_REQUEST = 10;
    const RATE_LIMIT_REQUESTS = 10; // Máximo de requisições por minuto
    const RATE_LIMIT_TIME = 60; // 1 minuto
}
 
// Utilize desta forma se não estiver instalado via composer 
// Se foi instalado via composer comente estas duas linhas
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Classes necesarias para enviar o email
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';	
// Headers para JSON e CORS
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
try {
// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
// Verificar se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}
// Verificar se todos os campos obrigatórios estão presentes
if (empty($_POST['to']) || empty($_POST['subject']) || empty($_POST['message'])) {
    return ['success' => false, 'message' => 'Todos os campos são obrigatórios.'];
}
// Validar emails
$emails = explode(',', $_POST['to']);
$validEmails = [];  
foreach ($emails as $email) {
    $email = trim($email);
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validEmails[] = $email;
    }
}
if (empty($validEmails)) {
    return ['success' => false, 'message' => 'Nenhum email válido encontrado.'];
}
// Validar anexo se existir
$attachment = null;
if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
    $maxFileSize = 5 * 1024 * 1024; // 5MB
    if ($_FILES['attachment']['size'] > $maxFileSize) {
        return ['success' => false, 'message' => 'Arquivo muito grande. Tamanho máximo: 5MB.'];
    }
        
    $allowedTypes = [
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'jpg' => 'image/jpeg', 
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'txt' => 'text/plain'
    ];
        
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($fileInfo, $_FILES['attachment']['tmp_name']);
    finfo_close($fileInfo);
        
    if (!in_array($mimeType, $allowedTypes)) {
        return ['success' => false, 'message' => 'Tipo de arquivo não permitido.'];
    }
        
    $attachment = $_FILES['attachment'];
}
// Dados validados
$subject = trim($_POST['subject']);
$message = trim($_POST['message']);

// Carrega as variáveis de ambiente do .env
require_once __DIR__ . '/vendor/autoload.php'; // Caminho para autoload do Composer
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/'); // Aponta para a pasta raiz do projeto
$dotenv->load();

$serv_smtp=$_ENV['SMTP_HOST'] ?? ''; 
$serv_user=$_ENV['SMTP_USER'] ?? ''; 
$serv_pass=$_ENV['SMTP_PASS'] ?? ''; 
$serv_porta=$_ENV['SMTP_PORT'] ?? ''; 
$serv_tls=$_ENV['SMTP_ENCRYPTION'] ?? ''; 
$mail_ReplyTo=$_ENV['ReplyTo_EMAIL'] ?? ''; 
$sys_name=$_ENV['SYS_NAME'] ?? ''; 
 
} catch (\Throwable $e) {        
    $msgerro = 'ERRO: '  . $e->getMessage() . ' em ' . $e->getFile() . ' na linha ' . $e->getLine();
    error_log($msgerro);
    echo json_encode(['success' => false, 'message' => $msgerro]);
    exit;  
} 
 
try {
	$mail = new PHPMailer(true);    
    $mail->Encoding = 'quoted-printable';
    $mail->CharSet = PHPMailer::CHARSET_UTF8;    								
	$mail->isSMTP();											
	$mail->Host	 = $serv_smtp;					
	$mail->SMTPAuth = true;							
	$mail->Username = $serv_user;				
	$mail->Password = $serv_pass;						
	$mail->SMTPSecure = $serv_tls;							
	$mail->Port	 = $serv_porta;
	$mail->setFrom($serv_user, $sys_name);		    
    $mail->addReplyTo($mail_ReplyTo, $sys_name);
    
    // Configurações adicionais para melhor compatibilidade
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    
    // Destinatários
    foreach ($validEmails as $email) {
        $mail->addAddress($email, 'Nome do usuário');
    }
    
    // Anexo     
    if ($attachment) {
        $mail->addAttachment(
            $attachment['tmp_name'],
            $attachment['name']
        );
    } 
    
	$mail->isHTML(true);								
    $mail->Subject  = $subject;    
	
    // Template HTML melhorado
    $htmlMessage = "
        <!DOCTYPE html>
        <html lang='pt-BR'>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #4F46E5; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; border: 1px solid #e1e1e1; }
                .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #666; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h1>" . htmlspecialchars($subject) . "</h1>
            </div>
            <div class='content'>
                " . nl2br(htmlspecialchars($message)) . "
            </div>
            <div class='footer'>
                <p>Email enviado automaticamente pelo Sistema de Email</p>
                <p>© " . date('Y') . " - Todos os direitos reservados</p>
            </div>
        </body>
        </html>
    ";
        
    $mail->Body = $htmlMessage;
    $mail->AltBody = strip_tags($message); // Versão texto simples	
	$enviado=$mail->send();	
    echo json_encode([
                'success' => true,                 
                'message' => 'E-mail enviado com sucesso para ' . count($validEmails) . ' destinatário(s)!'
    ]);
} catch (Exception $e) {	
   $erroserv=$mail->ErrorInfo;
   error_log($erroserv);
   echo json_encode([
                'success' => false, 
                'message' => 'Email não enviado  ' .$erroserv
   ]);
}
exit;

/**
 * Implementa rate limiting básico
 */
function checkRateLimit() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $rateFile = __DIR__ . '/cache/rate_limiting.json';
    $currentTime = time();
    
    // Garante que o diretório de cache existe
    if (!is_dir(dirname($rateFile))) {
        mkdir(dirname($rateFile), 0755, true);
    }
    
    // Carrega dados existentes
    if (file_exists($rateFile)) {
        $rateData = json_decode(file_get_contents($rateFile), true) ?: [];
    } else {
        $rateData = [];
    }
    
    // Limpa registros antigos
    foreach ($rateData as $ipKey => $times) {
        $rateData[$ipKey] = array_filter($times, function($time) use ($currentTime) {
            return $time > ($currentTime - SecurityConfig::RATE_LIMIT_TIME);
        });
        
        if (empty($rateData[$ipKey])) {
            unset($rateData[$ipKey]);
        }
    }
    
    // Verifica rate limit para este IP
    if (!isset($rateData[$ip])) {
        $rateData[$ip] = [];
    }
    
    if (count($rateData[$ip]) >= SecurityConfig::RATE_LIMIT_REQUESTS) {
        return false;
    }
    
    // Adiciona nova requisição
    $rateData[$ip][] = $currentTime;
    
    // Salva dados
    file_put_contents($rateFile, json_encode($rateData), LOCK_EX);
    
    return true;
}
?>