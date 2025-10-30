## 🙋‍♂️ Autor

<div align="center">
  <img src="https://avatars.githubusercontent.com/ninomiquelino" width="100" height="100" style="border-radius: 50%">
  <br>
  <strong>Onivaldo Miquelino</strong>
  <br>
  <a href="https://github.com/ninomiquelino">@ninomiquelino</a>
</div>

---

# 🔐 Secure PHP Mailer

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![PHPMailer](https://img.shields.io/badge/PHPMailer-SMTP-6B46C1.svg?style=for-the-badge)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-yellow.svg)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-CSS-38B2AC.svg)
![License MIT](https://img.shields.io/badge/License-MIT-green)
![Status Stable](https://img.shields.io/badge/Status-Stable-success)
![Version 1.0.0](https://img.shields.io/badge/Version-1.0.0-blue)
![GitHub stars](https://img.shields.io/github/stars/NinoMiquelino/secure-php-mailer?style=social)
![GitHub forks](https://img.shields.io/github/forks/NinoMiquelino/ecure-php-mailer?style=social)
![GitHub issues](https://img.shields.io/github/issues/NinoMiquelino/secure-php-mailer)

Sistema web moderno e seguro para envio de emails através de SMTP com PHPMailer. Interface responsiva construída com Tailwind CSS e backend robusto com proteções avançadas de segurança.

## ✨ Funcionalidades

### 🎨 **Interface Moderna**
- **Design Responsivo** - Optimizado para mobile e desktop
- **Tailwind CSS** - Interface moderna e profissional
- **UX Melhorada** - Feedback visual em tempo real
- **Upload de Anexos** - Suporte a múltiplos tipos de arquivo

### 🔒 **Segurança Avançada**
- **Rate Limiting** - Proteção contra spam e abuso
- **Validação de Entrada** - XSS e SQL Injection protection
- **Sanitização de Dados** - Filtragem completa de inputs
- **Configuração Segura** - Credenciais SMTP protegidas
- **Validação de Arquivos** - Tipo e tamanho limitados

### 📧 **Recursos de Email**
- **Múltiplos Destinatários** - Suporte a lista de emails
- **HTML e Texto** - Conteúdo em formato dual
- **Anexos** - Suporte a arquivos até 5MB
- **Template Profissional** - Layout HTML responsivo
- **Reply-To Configurável** - Respostas direcionadas

### ⚙️ **Configuração Flexível**
- **Multi-provedor SMTP** - Gmail, Outlook, Yahoo, etc.
- **Variáveis de Ambiente** - Configuração segura
- **Tratamento de Erros** - Mensagens amigáveis ao usuário

## 🚀 Começando Rápido

### Pré-requisitos
- PHP 8.0 ou superior
- Composer (para instalar dependências)
- Servidor SMTP (Gmail, SendGrid, etc.)

### Instalação Rápida

1. **Clone o repositório**
```bash
git clone https://github.com/NinoMiquelino/secure-php-mailer.git
cd secure-php-mailer
```

1. Instale as dependências

```bash
composer require phpmailer/phpmailer
```

1. Configure o SMTP

Variáveis de Ambiente (Recomendado)

Crie um arquivo .env (não versionado):

```env
SMTP_HOST=smtp.gmail.com
SMTP_USER=seuemail@gmail.com
SMTP_PASS=sua-app-password
SMTP_PORT=587
SMTP_ENCRYPTION=tls
ReplyTo_EMAIL=seuemail@gmail.com
SYS_NAME=Seu Sistema
```

1. Acesse o sistema

```bash
# Abra no navegador:
http://localhost/secure-php-mailer
```

🛠️ Configuração Detalhada

Configuração SMTP para Gmail

1. Ative a verificação em duas etapas
   · Acesse https://myaccount.google.com/security
   · Ative "Verificação em duas etapas"
2. Gere uma Senha de App
   · Acesse https://myaccount.google.com/apppasswords
   · Selecione "Email" e gere uma senha
   · Use a senha de 16 caracteres no código
3. Configuração no código

```php
$mail->Host = 'smtp.gmail.com';
$mail->Username = 'seuemail@gmail.com';
$mail->Password = 'abcd efgh ijkl mnop'; // App Password
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
```

Configuração para Outros Provedores

Outlook/Office 365:

```php
$mail->Host = 'smtp.office365.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
```

SendGrid:

```php
$mail->Host = 'smtp.sendgrid.net';
$mail->Username = 'apikey';
$mail->Password = 'SG.sua_chave_api';
```

📁 Estrutura do Projeto

```
secure-php-mailer/
│
├── index.html                 # Interface principal
├── process.php               # Backend de processamento
├── cache/                    # Cache de rate limiting
├── README.md
└── LICENSE            # Arquivo de Licença  da aplicação
```

🔧 Configuração de Segurança

Configurações de Segurança Implementadas

· Rate Limiting: 10 requisições por minuto por IP
· Validação de Arquivos: Tipos e tamanhos limitados
· Sanitização: Todos os inputs são validados e sanitizados
· Headers de Segurança: Proteção XSS, Clickjacking, etc.

🎯 Uso do Sistema

Envio Básico de Email

1. Preencha o destinatário (múltiplos separados por vírgula)
2. Adicione um assunto claro
3. Escreva a mensagem (suporte a formatação)
4. Opcional: Anexe um arquivo (até 5MB)
5. Clique em "Enviar Email"

Recursos Avançados

Múltiplos Destinatários:

```
usuario1@email.com, usuario2@email.com, usuario3@email.com
```

Template HTML Automático:

```html
<!-- O sistema aplica automaticamente um template profissional -->
```

Reply-To Configurável:

```php
// As respostas podem ser direcionadas para outro email
$mail->addReplyTo('suporte@empresa.com', 'Equipe de Suporte');
```

🐛 Solução de Problemas

Erros Comuns e Soluções

"SMTP Error: Could not connect to SMTP host"

· Verifique as credenciais SMTP
· Confirme a porta e encryption
· Gere App Password para Gmail
· Verifique firewall do servidor

"Unexpected end of JSON input"

· PHP está retornando erro antes do JSON
· Verifique syntax errors no código
· Confirme que PHPMailer está instalado

Email não chega no destinatário

· Verifique pasta de spam
· Confirme limites do provedor SMTP

Anexo não é enviado

· Tamanho máximo: 5MB
· Tipos permitidos: PDF, DOC, DOCX, JPG, PNG, TXT
· Verifique permissões de upload

Modo Debug

Ative o debug temporariamente em process.php:

```php
$mail->SMTPDebug = 2; // Nível de debug
$mail->Debugoutput = 'error_log'; // Saída do debug
```

🔍 Recursos de Segurança

Rate Limiting

O sistema impede spam através de limite de requisições:

· 10 requisições por minuto por IP
· Dados armazenados em cache temporário
· Proteção contra ataques de força bruta

Validação de Entrada

· Emails: Validação com filter_var()
· Arquivos: Verificação de tipo e tamanho
· Texto: Sanitização contra XSS
· CSRF Protection: Headers de segurança

Padrões de Código

· Siga PSR-12 para PHP
· Use ESLint para JavaScript

🛡️ Privacidade e Segurança

· Não armazenamos emails ou conteúdos enviados
· Credenciais SMTP são protegidas por variáveis de ambiente
· Comunicação com servidor SMTP usa encryption

---

## 🤝 Contribuições
Contribuições são sempre bem-vindas!  
Sinta-se à vontade para abrir uma [*issue*](https://github.com/NinoMiquelino/secure-php-mailer/issues) com sugestões ou enviar um [*pull request*](https://github.com/NinoMiquelino/secure-php-mailer/pulls) com melhorias.

---

## 💬 Contato
📧 [Entre em contato pelo LinkedIn](https://www.linkedin.com/in/onivaldomiquelino/)  
💻 Desenvolvido por **Onivaldo Miquelino**

---
