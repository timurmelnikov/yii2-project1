<?php

namespace app\classes;

/**
 * Класс текстовых меток.
 * Содержит все текстовые сообщения и надписи, кроме атрибутов моделей и имени приложения.
 * Использование - Caption::PARAM_NAME
 */
class Caption {

    //Диалоговые сообщения MESSAGE_
    const MESSAGE_ERROR_NAME_CURRENCY = 'Необходимо заполнить поле «Валюта»!';
    const MESSAGE_ERROR_GET_CURRENCY = 'Не удалось получить курс валюты...';
    //Всплывающие сообщения FLASH_
    //Удаление записей FLASH_DELETE_
    const FLASH_TITLE_ERROR = 'Ошибка!';
    const FLASH_TITLE_SUCCESS = 'Готово!';
    const FLASH_CREATE_SUCCESS = 'Запись успешно создана.';
    const FLASH_UPDATE_SUCCESS = 'Запись успешно изменена.';
    //const FLASH_SAVE_SUCCESS = 'Запись успешно сохранена.'; //не используется
    const FLASH_CREATE_TEMPLATE_SUCCESS = 'Шаблон успешно создан с наименованием - ';
    const FLASH_DELETE_SUCCESS = 'Запись успешно удалена.';
    const FLASH_DELETE_ERROR_RELATION = 'Невозможно удалить запись, она связана с другими объектами!';
    const FLASH_DELETE_ERROR_USER_ROOT = 'Пользователя "root" нельзя удалить!';
    const FLASH_DELETE_ERROR_USER_SELF = 'Пользователь не может удалить самого себя!';
    //Откат операций FLASH_ROLLBACK_
    const FLASH_ROLLBACK_SUCCESS = 'Откат успешно выполнен.';
    const FLASH_ROLLBACK_NOT_POSSIBLE = 'Откат операции не возможен!';
    //Надписи разделов SECTION_
    
    const SECTION_MAIN = 'Главная';
    const SECTION_OPERATION = 'Операции';
    const SECTION_REPORT = 'Отчеты';
    const SECTION_DICTIONARY = 'Словари';
    const SECTION_MANAGAMENT = 'Управление';
    const SECTION_INCOME = 'Доходы';
    const SECTION_EXPENSE = 'Расходы';
    const SECTION_ACCOUNT = 'Счета (кошельки)';
    const SECTION_ACCOUNT_MOVE = 'Перемещения';
    const SECTION_EXPENSE_CATEGORY = 'Категории расходов';
    const SECTION_EXPENSE_TEMPLATE = 'Шаблоны расходов';
    const SECTION_CURRENCY_EXCHANGE = 'Курсы валют';
    const SECTION_INCOME_CATEGORY = 'Категории доходов';
    const SECTION_UNIT = 'Единицы измерения';
    const SECTION_USER = 'Пользователи';
    const SECTION_SETTING = 'Настройки';
    const SECTION_LOGIN = 'Войти в систему';
    const SECTION_LOGOUT = 'Выйти';
    const SECTION_CONTACT = 'Контакт';
    const SECTION_ABOUT = 'О программе...';
    const SECTION_DEBT = 'Долги';
    const SECTION_SHEDULER = 'Планирование';
    const SECTION_USER_PASSWORD = 'Изменение пароля пользователя';
    const SECTION_USER_PERMISSION = 'Назначение ролей пользователю';
    const SECTION_SHOPPING_LIST = 'Списки покупок';
    const SECTION_SHOPPING_LIST_MY = 'Мои списки покупок';
    const SECTION_MY_BALANCE = 'Мои остатки';
    const SECTION_CONTROL_BALANCE = 'Контроль баланса';
    
    //Действия (кнопки, ссылки) ACTION_
    const ACTION_OK = 'OK';
    const ACTION_CREATE = 'Создать';
    const ACTION_IN_SECTION = 'В раздел';
    const ACTION_FROM_TEMPLATE = 'Шаблон';
    const ACTION_CREATE_CURRENT = 'Создать в текущей';
    const ACTION_SAVE = 'Сохранить';
    const ACTION_CANCEL = 'Отмена';
    const ACTION_UPDATE = 'Изменить';
    const ACTION_BACK = 'Вернуться назад';
    const ACTION_NEW_CATEGORY = 'Новая категория';
    //const ACTION_UNDO = 'Отмена';
    const ACTION_SEARCH = 'Поиск';
    const ACTION_SEARCH_ADVANCED = 'Расширенный поиск';
    const ACTION_RESET = 'Сброс';
    const ACTION_SEND = 'Отправить';
    const ACTION_DELETE = 'Удалить';
    const ACTION_USER_PASSWORD = 'Измененить пароль';
    const ACTION_USER_ROLE = 'Назначить роли';
    const ACTION_USER_ROLE_ADD = 'Дать роль';
    const ACTION_USER_ROLE_REMOVE = 'Отобрать роль';
    const ACTION_GO_ROOT = 'Перейти в корень';
    const ACTION_ROLLBACK = 'Откатить операцию';
    const ACTION_CREATE_TEMPLATE = 'Создать шаблон операции';
    const ACTION_GO_TEMPLATE = 'Перейти к шаблонам';
    const ACTION_CHANGE_TEMPLATE = 'Изменить шаблон';
    //Текстовые метки LABEL_
    const LABEL_ACTIONS = 'Действия';
    const LABEL_TEMPLATE_CONTENT = 'Содержание шаблона';
    const LABEL_ROLE = 'Роль';
    const LABEL_ROLE_APPOINTED = 'Назначена';
   
    //Ошибки ERROR_
    const ERROR_METHOD_NOT_ALLOWED = 'Это действие, нельзя вызвать из адресной строки! Можно использовать только метод: ';
    const ERROR_NOT_FOUND = 'Запрашиваемый объект не найден.';
    const ERROR_NOSCRIPT = 'Для работы приложения, необходима поддержка JavaScript браузером.';
    //Подтверждения CONFIRM_
    const CONFIRM_DELETE = 'Вы действительно хотите удалить объект?';
    const CONFIRM_ROLLBACK = 'Вы действительно хотите откатить операцию?';
    const CONFIRM_CREATE_TEMPLATE = 'Создать на основе данной записи шаблон операции?';
    //Приглашения (подсказки) PROMPT_
    const PROMPT_SELECT = 'Выберите...';
    const PROMPT_GET_CURRENCY = 'Получить на сегодня...';
    //Состояния STATE_
    const STATE_ACTIVE = 'Активен';
    const STATE_BAN = 'Заблокирован';
    const STATE_CLOSE = 'Закрыт';
    const STATE_YES = 'Да';
    const STATE_NO = 'Нет';
    
    
    // Ошибки валидации модели VALIDATION_
    const VALIDATION_EXPENSE_TEMPLATE_UNIQUE_NAME = 'Имя такого шаблона уже существует.';
    const VALIDATION_EXPENSE_TEMPLATE_UNIQUE_OPERATION = 'Шаблон такой операции уже существует.';
    const VALIDATION_LOGIN_FORM_INCORRECT_PASSWORD = 'Неправильное имя пользователя или пароль.';
    const VALIDATION_EXPENSE_CATEGORY_MOVE_SELF = 'Нельзя переносить категорию в текушую.';
    const VALIDATION_EXPENSE_CATEGORY_MOVE_CHILD = 'Нельзя переносить категорию в дочернюю.';
    const VALIDATION_CURRENCY_EXCHANGE_UNOQUE_DATE = 'Курс такой валюты, на заданную дату уже существует.';
    const VALIDATION_INCOME_CATEGORY_UNIQUE = 'У текущего пользователя уже есть такая категория.';
    const VALIDATION_EXPENSE_SUM_ACCOUNT = 'На счете, не достаточно средств для совершения операции.';

    //const VALIDATION_EXPENSE_COUNT_UNIT = 'Количество не может быть нулевым.'; //Заменено стандартным валидатором 'double'
}
