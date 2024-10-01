<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Offer\Request;

/**
 * Тип акции
 */
enum OfferType: string
{
    /**
     * Обычная
     */
    case Original = 'Original';

    /**
     * Персональные товары
     */
    case PersonalGoods = 'PersonalGoods';

    /**
     * Персональное предложение
     */
    case PersonalOffer = 'PersonalOffer';

    /**
     * Все
     */
    case All = 'All';
}
