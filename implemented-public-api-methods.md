# Список реализованных методов публичного API

* https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/

[Card. Методы для работы с картами](https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Cards/)

* Возвращает список карт текущего клиента и все операции по ним
* Генерирует QR-код для карты по ее внутреннему идентификатору

[CustomerEmail. Методы для работы с email клиента](https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Email/)

Методы, доступные через клиентскую авторизацию
* Запускает процесс изменения email. Указание нового email
* Завершает процесс изменения email
* Отменяет процесс изменения email

[History. Методы для работы с историческими данными](https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/History/)

* Возвращает историю операций клиента
* Возвращает сумму покупок, сумму начисленных и списанных бонусов в рамках покупок

[Merchants. Методы для работы с торговыми точками](https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Merchants/)

* Возвращает информацию о торговых точках (фильтр по внешним идентификаторам торговых точек)
* Возвращает информацию о торговых точках (фильтр по внутренним идентификаторам торговых точек)

[Notification. Методы для работы с уведомлениями](https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Notification/)

* Возвращает список оповещений
* Возвращает количество оповещений
* Отмечает оповещение как прочитанное
* Отмечает все оповещения прочитанными

[Offer. Методы для работы с таргетированным контентом](https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Offer/)

* Возвращает информацию о таргетированном контенте
* Возвращает информацию о таргетированном контенте по внутреннему идентификатору
* Возвращает список магазинов (торговых точек), для которых действует таргетированный контент

[Password. Методы для работы с паролем](https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Password/)

* Устанавливает пароль клиенту

[PushNotification. Методы для работы с push-уведомлениями](https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Pushes/)

* Отправляет push-токен для регистрации мобильного устройства

[Registration. Методы для работы с регистрацией клиентов](https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/registration/)

* Запускает регистрацию клиента
* Завершает процесс регистрации клиента

[Customer. Методы для работы с клиентами](https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/)

* Возвращает информацию о клиенте
* Возвращает список логинов клиента
* Возвращает список необходимых шагов регистрации
* Возвращает информацию о балансе клиента
* Возвращает информацию о детализированном балансе клиента
* Обновляет ответы на вопросы анкеты
* Оформляет принятие оферты

[UserPhone. Методы для работы с номером телефона](https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/PhoneNumber/)

* Возвращает информацию о номере телефона клиента
* Начинает процесс привязки номера телефона
* Завершает процесс привязки номера телефона
* Повторно отправляет код подтверждения на новый номер телефона
* Отменяет процесс привязки номера телефона

[User/Subscriptions. Методы для работы с подписками](https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/Subscriptions/)

* Возвращает список подписок клиента
* Обновляет информацию о подписках клиента
* Оформляет подписку на все типы рассылок при регистрации нового клиента
* Оформляет отказ от всех типов подписок

[UserStatus. Методы для работы со статусами клиентов](https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/Status/)

* Возвращает клиенту подробную информацию о его статусах в статусных системах

## Дополнительные модули

[CommunicationService. Персональные предложения с использованием механик Machine Learning](https://docs.loymax.net/xwiki/bin/view/Main/Installation_and_configuration/Extra_modules/CommunicationService_ML/)

* Получение информации о персональном предложении
