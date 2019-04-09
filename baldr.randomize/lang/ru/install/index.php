<?php
$MESS["I_BALDR_RANDOMIZE_MODULE_NAME"] = "Randomize";
$MESS["I_BALDR_RANDOMIZE_MODULE_DESC"] = "Модуль розыгрыша призов";
$MESS["I_BALDR_RANDOMIZE_PARTNER_NAME"] = "Иван Семин";
$MESS["I_BALDR_RANDOMIZE_PARTNER_URI"] = "https://zakazhi.website/";

$MESS["I_BALDR_RANDOMIZE_DENIED"] = "Доступ закрыт";
$MESS["I_BALDR_RANDOMIZE_REGISTRATION"] = "Доступ к регистрации в розыгрыше";
$MESS["I_BALDR_RANDOMIZE_MODERATION"] = "Доступ к модерации участников";
$MESS["I_BALDR_RANDOMIZE_FULL"] = "Полный доступ";

$MESS["I_BALDR_RANDOMIZE_INSTALL_TITLE"] = "Установка модуля";
$MESS["I_BALDR_RANDOMIZE_INSTALL_ERROR_VERSION"] = "Версия главного модуля ниже 14. Не поддерживается технология D7, необходимая модулю. Пожалуйста обновите систему.";
$MESS["I_BALDR_RANDOMIZE_INSTALL_ERROR_AI_DEP"] = "Отсутствует модуль API AdminHelper <https://github.com/DigitalWand/digitalwand.admin_helper/>. Данный модуль необходим для работы админ. части модуля.";

$MESS["I_BALDR_RANDOMIZE_MAIL_REG_FORM_E_T"] = "Регистрация участника розыгрыша";
$MESS["I_BALDR_RANDOMIZE_MAIL_REG_FORM_E_D"] = "#EMAIL_MEMBER# - E-mail зарегистрированного участника
#EMAIL_MODER# - E-mail модератора
#FULL_NAME# - ФИО участника
#PHONE# - телефон участника
#COMPANY_NAME# - название компании подавшей заявку
#LOTTERY_NAME# - название розыгрыша
#LOTTERY_ID# - id розыгрыша";

$MESS["I_BALDR_RANDOMIZE_MAIL_REG_FORM_T_T"] = "#SITE_NAME#: Заявка на участие в розыгрыше принята";
$MESS["I_BALDR_RANDOMIZE_MAIL_REG_FORM_T_D"] = "Уважаемый, #FULL_NAME#

Ваша заявка на участие в розыгрыше «#LOTTERY_NAME#» принята и отправлена на модерацию.
О ходе регистрации Вам будет сообщено дополнительно по указанному при регистрации e-mail’у.

Спасибо за проявленный интерес к Бонусной программе «Оптималоги».

Еще раз ознакомиться с условиями участия в розыгрыше, а также узнать подробнее о бонусной программе
 «Оптималоги» можно на странице сайта Оптимальной логистики в разделе: <a href='https://#SERVER_NAME#/optimalogi/'>https://#SERVER_NAME#/optimalogi/</a>

Если у вас остались вопросы адресуйте их на электронный адрес <a href='mailto:anna@optimalog.ru'>anna@optimalog.ru</a>";

$MESS["I_BALDR_RANDOMIZE_MAIL_REG_MODER_T_T"] = "#SITE_NAME#: Новая заявка на участие в розыгрыше";
$MESS["I_BALDR_RANDOMIZE_MAIL_REG_MODER_T_D"] = "Подана новая заявка на участие в розыгрыше «#LOTTERY_NAME#»

Заявку от компании #COMPANY_NAME# подал:
 #FULL_NAME# 
 e-mail: #EMAIL_MEMBER#
 телефон: #PHONE#

Необходимо <a href='https://#SERVER_NAME#/bitrix/admin/admin_helper_route.php?lang=ru&module=baldr.randomize&view=company_lottery_list&entity=member&set_filter=Y&find_LOTTERY_ID=#LOTTERY_ID#'>провести модерацию этой заявки</a>";

$MESS["I_BALDR_RANDOMIZE_MAIL_REJECT_E_T"] = "Оклонение заявки на участие в розыгрыше";
$MESS["I_BALDR_RANDOMIZE_MAIL_REJECT_E_D"] = "#EMAIL_MEMBER# - E-mail зарегистрированного участника
#EMAIL_MODER# - E-mail модератора
#REASON# - причина отклонения заявки
#FULL_NAME# - ФИО участника
#PHONE# - телефон участника
#COMPANY_NAME# - название компании подавшей заявку
#LOTTERY_NAME# - название розыгрыша";

$MESS["I_BALDR_RANDOMIZE_MAIL_REJECT_T_T"] = "#SITE_NAME#: Заявка на участие в розыгрыше отклонена";
$MESS["I_BALDR_RANDOMIZE_MAIL_REJECT_T_D"] = "Уважаемый, #FULL_NAME#

Ваша заявка на участие в розыгрыше «#LOTTERY_NAME#» отклонена по причине: #REASON#.
Спасибо за проявленный интерес к Бонусной программе «Оптималоги».
Следить за ходом и результатами розыгрыша, еще раз ознакомиться с условиями участия в розыгрыше и узнать подробнее
 о бонусной программе «Оптималоги» можно на странице сайта Оптимальной логистики: <a href='https://#SERVER_NAME#/optimalogi/'>https://#SERVER_NAME#/optimalogi/</a>

Если у вас остались вопросы адресуйте их на электронный адрес <a href='mailto:anna@optimalog.ru'>anna@optimalog.ru</a>";

$MESS["I_BALDR_RANDOMIZE_MAIL_REJECT_M_E_T"] = "Оповещение модератора при автоматическом отклонение заявки на участие в розыгрыше";
$MESS["I_BALDR_RANDOMIZE_MAIL_REJECT_M_E_D"] = "#EMAIL_MEMBER# - E-mail зарегистрированного участника
#EMAIL_MODER# - E-mail модератора
#REASON# - причина отклонения заявки
#FULL_NAME# - ФИО участника
#PHONE# - телефон участника
#COMPANY_NAME# - название компании подавшей заявку
#LOTTERY_NAME# - название розыгрыша";

$MESS["I_BALDR_RANDOMIZE_MAIL_REJECT_M_T_T"] = "#SITE_NAME#: Оповещение об автоматическом отклонении заявки на участие в розыгрыше";
$MESS["I_BALDR_RANDOMIZE_MAIL_REJECT_M_T_D"] = "Произошло автоматическое отклонение заявки на участие в розыгрыше «#LOTTERY_NAME#»

Заявку от компании #COMPANY_NAME# подавал:
ФИО: #FULL_NAME# 
e-mail: #EMAIL_MEMBER#
телефон: #PHONE#
 
Причина отклонения: #REASON#";

$MESS["I_BALDR_RANDOMIZE_MAIL_CONFIRM_E_T"] = "Подтверждение заявки на участие в розыгрыше";
$MESS["I_BALDR_RANDOMIZE_MAIL_CONFIRM_E_D"] = "#EMAIL_MEMBER# - E-mail зарегистрированного участника
#FULL_NAME# - ФИО участника
#LOTTERY_NAME# - название розыгрыша
#LOTTERY_DATA# - дата проведения розыгрыша
#LOT_COMP_ID# - id присвоенный участнику розыгрыша";

$MESS["I_BALDR_RANDOMIZE_MAIL_CONFIRM_T_T"] = "#SITE_NAME#: Заявка на участие в розыгрыше одобрена";
$MESS["I_BALDR_RANDOMIZE_MAIL_CONFIRM_T_D"] = "Уважаемый, #FULL_NAME#

Ваша заявка на участие в розыгрыше «#LOTTERY_NAME#» одобрена.
Вам присвоен следующий номер участника: #LOT_COMP_ID#
Данный Номер (ID) будет участвовать в розыгрыше.

Розыгрыш состоится #LOTTERY_DATA#

Спасибо за проявленный интерес к Бонусной программе «Оптималоги».
Следить за ходом и результатами розыгрыша, ознакомиться еще раз с условиями участия в розыгрыше и узнать подробнее
о бонусной программе «Оптималоги» можно на странице сайта Оптимальной логистики: <a href='https://#SERVER_NAME#/optimalogi/'>https://#SERVER_NAME#/optimalogi/</a>

Если у вас остались вопросы адресуйте их на электронный адрес <a href='mailto:anna@optimalog.ru'>anna@optimalog.ru</a>";

$MESS["I_BALDR_RANDOMIZE_MAIL_WIINNER_E_T"] = "Оповещение победителя";
$MESS["I_BALDR_RANDOMIZE_MAIL_WINNER_E_D"] = "#EMAIL_MEMBER# - E-mail зарегистрированного участника
#FULL_NAME# - ФИО участника
#PRIZE_NAME# - Название приза";

$MESS["I_BALDR_RANDOMIZE_MAIL_WINNER_T_T"] = "#SITE_NAME#: УРА! Вы стали победителем розыгрыша!";
$MESS["I_BALDR_RANDOMIZE_MAIL_WINNER_T_D"] = "Уважаемый, #FULL_NAME#

УРА! ВЫ СТАЛИ ПОБЕДИТЕЛЕМ РОЗЫГРЫША

Ваш ID вошел в число победителей призов. Ваш приз: #PRIZE_NAME#
В самое ближайшее время с вами свяжутся и уточнят дату и время получения приза 
Спасибо за проявленный интерес к Бонусной программе «Оптималоги».

Следить за новостями клубной бонусной программе «Оптималоги», накапливайте бонусный баллы и участвуйте
в новых акциях от «Оптимальной логистики» 
Спасибо, что выбрали нашу компанию! 
«Оптимальная логистика» -«Объединяем континенты для и ради Клиентов»

Если у вас остались вопросы адресуйте их на электронный адрес <a href='mailto:anna@optimalog.ru'>anna@optimalog.ru</a>";