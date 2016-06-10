/**
 * Обработка GET запроса для отправки письма.
 * 
 * @param e
 * @returns {*}
 */
function doGet(e) {
    if (
        e.parameter.s != null //Присуствует заголовок сообщения
        && e.parameter.r != null//Присуствуют получатели
        && e.parameter.m != null//Присуствует сообщение
    ) {
        //Получаем текущую квоту на отправку писем
        var emailQuotaRemaining = MailApp.getRemainingDailyQuota();

        //Отправка уведомления
        //https://developers.google.com/apps-script/reference/mail/mail-app#sendemailrecipient-subject-body-options
        MailApp.sendEmail({
            to: e.parameter.r,
            replyTo: '<YOUR_GMAIL_EMAIL>',//Отправка идет от этого аккаунта, поэтому отвечать будут ему
            subject: e.parameter.s,
            htmlBody: e.parameter.m,
        });

        //Получаем новое значение квоты и спавниваем его с плученным ранее
        emailQuotaRemaining = (emailQuotaRemaining - MailApp.getRemainingDailyQuota()) > 0;

        var error = {
            send: emailQuotaRemaining
        };

        //Формируем JSON ответ
        return ContentService.createTextOutput(JSON.stringify(error));
    }
    else {
        var error = {
            send: false
        };

        //Формируем JSON ответ
        return ContentService.createTextOutput(JSON.stringify(error));
    }
}