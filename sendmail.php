<?php
/**
 * Отправка почты через gmail.com, с использованием существующего аккаунта 
 */

/**
 * Class SendMail
 */
class SendMail
{
    /**
     * Email, от которого будет отправлятся email
     */
    const EMAIL = '<YOUR_GMAIL_EMAIL>';

    /**
     * Пароль от  email
     */
    const PASS = '<YOUR_GMAIL_PASS>';

    /**
     * Ссылка на скрипт Google App Script отправляющий email
     */
    const SCRIPT_URL = '<PATH_TO_GOOGLE_APPS_SCRIPT>';

    /**
     * Отправить сообщение через Google Apps Script
     *
     * @link  https://developers.google.com/apps-script/reference/mail/mail-app#sendemailrecipient-subject-body-options
     *
     * @param string $subject           Тема письма
     * @param string $message           Текст письма
     * @param string $email             Email получателя
     * @param string $additionalHeaders Дополнительные заголовки //todo добавить обработку дополнительных заголовков
     *
     * @return bool
     */
    public static function sendMail($subject, $message, $email, $additionalHeaders = '')
    {
        $ch = curl_init(self::SCRIPT_URL . '?r=' . urlencode($email) . '&s=' . urlencode($subject) . '&m=' . urlencode($message));

        curl_setopt($ch, CURLOPT_MUTE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/xml']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $res = curl_exec($ch);

        return $res !== false;
    }

    /**
     * Отправить сообщение через SMTP Google
     *
     * @param string $subject           Тема письма
     * @param string $message           Текст письма
     * @param string $email             Email получателя
     * @param string $additionalHeaders Дополнительные заголовки //todo добавить обработку дополнительных заголовков
     *
     * @return bool
     */
    public static function sendMail2($subject, $message, $email, $additionalHeaders = '')
    {
        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
            ->setUsername(self::EMAIL)
            ->setPassword(self::PASS);

        $mailer = Swift_Mailer::newInstance($transport);

        $obMessage = Swift_Message::newInstance($subject)
            ->setFrom([self::EMAIL])
            ->setTo([$email])
            ->setReplyTo([self::EMAIL])
            ->setBody($message)->setContentType('text/html');

        /** @var Swift_Mime_Message $obMessage  */
        $result = $mailer->send($obMessage);

        return $result === 1;
    }
}