# otus-homework

Репозиторий для домашних работ по курсу Разработчик Битрикс24 в OTUS

[Домашняя работа № 2](https://github.com/elisad5791/otus-homework/tree/homework-2)

[Домашняя работа № 3](https://github.com/elisad5791/otus-homework/tree/homework-3)

#### Разработка простого приложения для работы со списками на D7

Два списка

Врачи (все свойства обязательные)

- NAME - ФИО
- SCHEDULE - График работы (строка)
- PHOTO - Фотография (файл)
- PROCEDURES - Проводимые процедуры (привязка к списку Процедуры, множественное)

Процедуры (все свойства обязательные)

- NAME - Название
- PRICE - Цена (строка)
- PICTURE - Изображение (файл)

Сделаны страницы

- Медицинские услуги (Главная)
- Врач
- Процедура
- Добавить врача
- Добавить процедуру

[Домашняя работа № 4](https://github.com/elisad5791/otus-homework/tree/homework-4)

#### Модуль данных для таблицы БД

Созданы:

- Таблица с моделью c_product (ProductTable) - товары на кондитерском складе
- Инфоблок Кладовщики (связь с товаром описана в модели через reference-поле)
- Инфоблок Поставщики (связь с товаром описана в модели через reference-поле)
- Инфоблок Счета-фактуры (связь создается динамически при выборке через runtime-поле)

Данные по товарам (и связанная информация) выведены в таблице с использованием компонента main.ui.grid

[Домашняя работа № 5](https://github.com/elisad5791/otus-homework/tree/homework-5)

#### Разработка собственного компонента

Разработан компонент, который показывает курс по умолчанию для некоторой валюты. 
Данные берутся из справочника валют модуля Валюты. 
Нужную валюту можно выбрать при настройке компонента.

[Домашняя работа № 6](https://github.com/elisad5791/otus-homework/tree/homework-6)

#### Разработка модуля для расширения стандартного модуля CRM

Разработан модуль elisad.module. 
Модуль добавляет вкладку в CRM и выводит в грид данные из созданной таблицы комментариев. 
Комментарии привязаны к сущностям CRM (лиды, сделки, контакты, компании).

В админ-панели создаются страница с описанием модуля и страница настроек модуля. 
Меню модуля находится в разделе Сервисы.

В настройках модуля можно выбрать в каких сущностях (лиды, сделки, контакты, компании) 
создавать новую вкладку, а в каких нет. 
По умолчанию создаются во всех.

[Домашняя работа № 7](https://github.com/elisad5791/otus-homework/tree/homework-7)

#### Создать свой тип поля для элементов инфоблока

Созданы списки

- Врачи (ФИО, Специализация, Запись на процедуры)
- Процедуры (Название)
- Бронирования (ФИО клиента, Процедура, Назначенное время)

Создано кастомное свойство, в выводе кастомного свойства показаны все процедуры, привязанные к врачу.

При клике на процедуру открывается попап BX.PopupWindowManager, 
в котором необходимо ввести ФИО клиента и выбрать время (использован BX.calendar).

При клике на кнопке Записаться создается бронирование, выполняется переход на список с бронированиями.

Сделана проверка на то, что выбранное время не занято.

[Домашняя работа № 8](https://github.com/elisad5791/otus-homework/tree/homework-8)

#### Модификация интерфейса на стороне клиента

Не совсем поняла формулировку задачи и комментарий в телеграме, поэтому сделала два варианта:

1. Добавлен текст с просьбой подтвердить изменение статуса рабочего дня в 
битриксовский попап над кнопкой Начать/продолжить рабочий день

2. При нажатии на кнопку Начать/продолжить рабочий день показывается модальное окно. 
В модальном окне кнопка Подтвердить. Рабочий день стартует только при нажатии на эту кнопку, 
иначе начало/продолжение рабочего дня отменяется.
На скринах кнопка Продолжить рабочий день, а не начать, 
т.к. после первого старта рабочего дня надпись меняется таким образом.

[Домашняя работа № 9](https://github.com/elisad5791/otus-homework/tree/homework-9)

#### Бизнес-процесс для обработки элементов инфоблока при создании

Создан список Заявки на ремонт с полями

- Название
- Сумма
- ИНН заказчика
- Вид работ
- Компания
- Сделка
- 
Создано действие Поиск компании по ИНН в сервисе Dadata и создание компании

При создании элемента списка 
- запускается БП, в котором
- осуществляется проверка, есть ли в системе компания с указанным ИНН
- если есть, то она прикрепляется к заявке
- если компании нет, осуществляется ее поиск в сервисе Dadata и получение данных; 
затем компания создается и прикрепляется к заявке
- создается сделка по заявке и так же прикрепляется к заявке

[Домашняя работа № 10](https://github.com/elisad5791/otus-homework/tree/homework-10)

#### Обработчик изменений в элементе инфоблок

Создан список Заявки на покупку мебели с полями

- Название
- Сумма
- Ответственный
- Сделка

Сделана обработка событий:

- При создании элемента списка создается сделка, в которую заносятся данные из элемента
- При обновлении элемента списка происходит обновление сделки
- При удалении элемента списка происходит удаление сделки
- При создании сделки происходит создание элемента списка
- При обновлении сделки происходит обновление элемента списка
- При удалении сделки происходит удаление элемента списка

[Домашняя работа № 11](https://github.com/elisad5791/otus-homework/tree/homework-11)

#### Локальное REST приложение дата последней коммуникации

Создано локальное приложение, которое при установке создает пользовательское поле 
для контактов Дата последней коммуникации типа Дата-Время.

К событию создания нового дела привязан обработчик, который проверяет является ли дело звонком 
или отправкой email-сообщения, а также привязано ли оно именно к сущности контакт.

Если да, то поле Дата последней коммуникации у соответствующего контакта обновляется,
в него записываются текущие дата-время.

[Домашняя работа № 12](https://github.com/elisad5791/otus-homework/tree/homework-12)

#### Собственные обработчики REST

Создана сущность Города (ID, TITLE)

Для этой сущности созданы методы REST:
- my.city.list - получить список городов
- my.city.add - добавить город
- my.city.update - обновить город
- my.city.delete - удалить город

Входные и выходные данные методов логируются в файл log.txt
Созданы входящие вебхуки для каждого метода, вебхуки протестированы через postman