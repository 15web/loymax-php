<?php

declare(strict_types=1);

namespace Studio15\Loymax\Modules\CommunicationService\Response;

/**
 * Тип предложения
 */
enum OfferType: string
{
    /**
     * Скидка, % на чек
     */
    case CheckAmountDiscountNoLimit = 'CheckAmountDiscountNoLimit';

    /**
     * Баллы, % на чек
     */
    case CheckAmountCashbackNoLimit = 'CheckAmountCashbackNoLimit';

    /**
     * Скидка, % на чек от суммы чека
     */
    case CheckAmountDiscount = 'CheckAmountDiscount';

    /**
     * Баллы, % на чек от суммы чека
     */
    case CheckAmountCashback = 'CheckAmountCashback';

    /**
     * Скидка, % на категорию
     */
    case DiscountPercentCategory = 'DiscountPercentCategory';

    /**
     * Баллы, % на категорию
     */
    case CashbackPercentCategory = 'CashbackPercentCategory';

    /**
     * Скидка, % на товар
     */
    case DiscountPercentGoods = 'DiscountPercentGoods';

    /**
     * Баллы, % на товар
     */
    case CashbackPercentGoods = 'CashbackPercentGoods';

    /**
     * Скидка N на чек от суммы чека M
     */
    case CheckAmountFixDiscountNoLimit = 'CheckAmountFixDiscountNoLimit';

    /**
     * Баллы N на чек от суммы чека M
     */
    case CheckAmountFixCashbackNoLimit = 'CheckAmountFixCashbackNoLimit';

    /**
     * Фиксированная цена товара
     */
    case PricePerUnit = 'PricePerUnit';
}
