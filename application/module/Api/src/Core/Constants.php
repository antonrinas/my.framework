<?php

namespace Api\Core;

class Constants
{
    const OK_STATUS = 'ok';
    const INFO_STATUS = 'info';
    const WARNING_STATUS = 'warning';
    const ERROR_STATUS = 'error';

    const GENERAL_ERROR_MESSAGE = 'Во время выполнения операции возникла ошибка';
    const GENERAL_LOGIN_ERROR = 'Неверное имя пользователя или пароль';

    const FORBIDEN_STATUS_CODE = 403;
    const USER_ROLE_ID = 1;
    const ADMIN_ROLE_ID = 2;
}