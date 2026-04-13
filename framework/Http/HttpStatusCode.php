<?php

declare(strict_types=1);

namespace Framework\Http;

final class HttpStatusCode
{

    public const OK = 200;//хорошо
    public const CREATED = 201;//создано

    public const MOVED_PERMANENTLY = 301;//перемещено навсегда
    public const FOUNT = 302;//найдено
    public const NOT_MODIFIED = 304;//не изменялось

    public const BAD_REQUEST = 400;//неправильный, некорректный запрос
    public const UNAUTHORIZED = 401;//не авторизован
    public const FORBIDDEN = 403;//запрещено
    public const NOT_FOUND = 404;//не найдено
    public const UNPROCESSABLE_ENTITY = 422;//необрабатываемый экземпляр
    public const TOO_MANY_REQUESTS = 429;//слишком много запросов

    public const INTERNAL_SERVER_ERROR = 500;//внутренняя ошибка сервера
    public const SERVICE_UNAVAILABLE = 503;//сервис недоступен

}
