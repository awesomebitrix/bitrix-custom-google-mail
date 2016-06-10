<?php
/**
 * фрагмент файла init.php
 */

/**
 * Отправка почты через сервис гугла
 *
 * @param string $to                Email получателя
 * @param string $subject           Тема письма
 * @param string $message           Текст письма
 * @param string $additionalHeaders Дополнительные заголовки
 *
 * @return bool
 */
function custom_mail($to, $subject, $message, $additionalHeaders = '')
{
    $res = SendMail::sendMail2($subject, $message, $to, $additionalHeaders);

    if (!$res) {
        $res = SendMail::sendMail($subject, $message, $to, $additionalHeaders);
    }

    return $res;
}

