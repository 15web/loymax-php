<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Тип аттрибута клиента
 */
enum AttributeType: string
{
    /**
     * Строка
     */
    case StringValue = 'Loymax.Common.Contract.Model.UserInfo.StringValueModel, Loymax.Common.Contract';

    /**
     * Дата
     */
    case DateValue = 'Loymax.Common.Contract.Model.UserInfo.DateValueModel, Loymax.Common.Contract';

    /**
     * Список строк
     */
    case FixedAnswers = 'Loymax.Common.Contract.Model.UserInfo.FixedAnswersModel, Loymax.Common.Contract';
}
