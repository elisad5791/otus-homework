# otus-homework

Репозиторий для домашних работ по курсу Разработчик Битрикс24 в OTUS

Домашняя работа - Бизнес-процесс для обработки элементов инфоблока при создании 

Создан список Заявки на ремонт с полями 
- Название
- Сумма
- ИНН заказчика
- Вид работ
- Компания
- Сделка

Создано действие Поиск компании по ИНН в сервисе Dadata и создание компании

При создании элемента списка запускается БП, в котором 
- осуществляется проверка, есть ли в системе компания с указанным ИНН
- если есть, то она прикрепляется к заявке
- если компании нет, осуществляется ее поиск в сервисе Dadata и получение данных; затем компания создается и прикрепляется к заявке
- создается сделка по заявке и так же прикрепляется к заявке