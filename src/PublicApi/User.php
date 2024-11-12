<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\Authorization\Response\AccessTokenData;
use Studio15\Loymax\PublicApi\User\AcceptTenderOffer;
use Studio15\Loymax\PublicApi\User\ChangePassword;
use Studio15\Loymax\PublicApi\User\ConfirmSubscriptions;
use Studio15\Loymax\PublicApi\User\Email\ChangeEmail;
use Studio15\Loymax\PublicApi\User\Email\ConfirmEmail;
use Studio15\Loymax\PublicApi\User\Email\EmailCancelChange;
use Studio15\Loymax\PublicApi\User\Email\GetEmail;
use Studio15\Loymax\PublicApi\User\Email\Request\ConfirmEmailRequest;
use Studio15\Loymax\PublicApi\User\Email\Response\Email as EmailStatus;
use Studio15\Loymax\PublicApi\User\Email\Response\EmailChanged;
use Studio15\Loymax\PublicApi\User\GetBalance;
use Studio15\Loymax\PublicApi\User\GetDetailedBalance;
use Studio15\Loymax\PublicApi\User\GetLogins;
use Studio15\Loymax\PublicApi\User\GetRegistrationActions;
use Studio15\Loymax\PublicApi\User\GetStatus;
use Studio15\Loymax\PublicApi\User\GetSubscriptions;
use Studio15\Loymax\PublicApi\User\GetUser;
use Studio15\Loymax\PublicApi\User\PhoneNumber\ChangePhoneNumber;
use Studio15\Loymax\PublicApi\User\PhoneNumber\ConfirmPhoneNumber;
use Studio15\Loymax\PublicApi\User\PhoneNumber\GetPhoneNumber;
use Studio15\Loymax\PublicApi\User\PhoneNumber\PhoneNumberCancelChange;
use Studio15\Loymax\PublicApi\User\PhoneNumber\Request\ConfirmPhoneRequest;
use Studio15\Loymax\PublicApi\User\PhoneNumber\Response\PhoneNumberChanged;
use Studio15\Loymax\PublicApi\User\PhoneNumber\Response\PhoneNumberState;
use Studio15\Loymax\PublicApi\User\PhoneNumber\SendConfirmCode;
use Studio15\Loymax\PublicApi\User\RejectSubscriptions;
use Studio15\Loymax\PublicApi\User\Request\Answer;
use Studio15\Loymax\PublicApi\User\Request\ChangePasswordRequest;
use Studio15\Loymax\PublicApi\User\Request\GetSubscriptionRequest;
use Studio15\Loymax\PublicApi\User\Request\GetUserPayload;
use Studio15\Loymax\PublicApi\User\Request\SetPasswordRequest;
use Studio15\Loymax\PublicApi\User\Response\AnswerErrors;
use Studio15\Loymax\PublicApi\User\Response\Balance;
use Studio15\Loymax\PublicApi\User\Response\DetailedBalance;
use Studio15\Loymax\PublicApi\User\Response\Logins;
use Studio15\Loymax\PublicApi\User\Response\RegistrationActionList;
use Studio15\Loymax\PublicApi\User\Response\StatusSystem;
use Studio15\Loymax\PublicApi\User\Response\Subscription;
use Studio15\Loymax\PublicApi\User\Response\SubscriptionExternalId;
use Studio15\Loymax\PublicApi\User\Response\UpdatedSubscription;
use Studio15\Loymax\PublicApi\User\Response\User as UserResponse;
use Studio15\Loymax\PublicApi\User\SendAnswers;
use Studio15\Loymax\PublicApi\User\SetPassword;
use Studio15\Loymax\PublicApi\User\UpdateSubscriptions;
use Studio15\Loymax\PublicApi\User\ValueObject\Email;
use Studio15\Loymax\PublicApi\User\ValueObject\Phone;

/**
 * User. Методы для работы с клиентами
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/
 */
final readonly class User
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * Возвращает информацию о клиенте
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#01
     *
     * @param list<GetUserPayload|non-empty-string> $payload
     *
     * @throws ApiClientException
     */
    public function getUser(array $payload = []): UserResponse
    {
        $getUser = new GetUser(
            apiClient: $this->apiClient
        );

        return ($getUser)($payload);
    }

    /**
     * Получение списка логинов пользователя
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#02
     *
     * @throws ApiClientException
     */
    public function getLogins(): Logins
    {
        $getLogins = new GetLogins(
            apiClient: $this->apiClient
        );

        return ($getLogins)();
    }

    /**
     * Возвращает информацию о балансе клиента
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#04
     *
     * @return list<Balance>
     *
     * @throws ApiClientException
     */
    public function getBalance(): array
    {
        $getBalance = new GetBalance(
            apiClient: $this->apiClient,
        );

        return ($getBalance)();
    }

    /**
     * Возвращает информацию о детализированном балансе клиента
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#08
     *
     * @return list<DetailedBalance>
     *
     * @throws ApiClientException
     */
    public function getDetailedBalance(): array
    {
        $getDetailedBalance = new GetDetailedBalance(
            apiClient: $this->apiClient
        );

        return ($getDetailedBalance)();
    }

    /**
     * Оформляет принятие оферты
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#11
     *
     * @throws ApiClientException
     */
    public function acceptTenderOffer(): void
    {
        $acceptTenderOffer = new AcceptTenderOffer(
            apiClient: $this->apiClient,
        );

        ($acceptTenderOffer)();
    }

    /**
     * Возвращает клиенту подробную информацию о его статусах в статусных системах
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/Status/#H41243E43743244043044943043544243A43B43843543D44244343F43E43444043E43143D44344E43843D44443E44043C43044643844E43E43543343E44144243044244344143044543244144243044244344143D44B44544143844144243543C430445
     *
     * @return list<StatusSystem>
     *
     * @throws ApiClientException
     */
    public function getStatus(): array
    {
        $getStatus = new GetStatus(
            apiClient: $this->apiClient
        );

        return ($getStatus)();
    }

    /**
     * Возвращает текущий статус email клиента
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Email/?srid=NJuz5jjt#H41243E43743244043044943043544244243543A443449438439441442430442443441email43A43B43843543D442430
     *
     * @throws ApiClientException
     */
    public function getEmail(): EmailStatus
    {
        $getEmail = new GetEmail(
            apiClient: $this->apiClient
        );

        return ($getEmail)();
    }

    /**
     * Запускает процесс изменения email. Указание нового email
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Email/#H41743043F44344143A43043544243F44043E44643544144143843743C43543D43543D43844FA0email.42343A43043743043D43843543D43E43243E43343Eemail
     *
     * @param non-empty-string $email Новый email
     *
     * @throws ApiClientException
     */
    public function changeEmail(string $email): EmailChanged
    {
        $changeEmail = new ChangeEmail(
            apiClient: $this->apiClient
        );

        return ($changeEmail)(new Email($email));
    }

    /**
     * Завершает процесс изменения email
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Email/#H41743043243544044843043544243F44043E44643544144143843743C43543D43543D43844Femail
     *
     * @param non-empty-string $confirmCode Код подтверждения
     * @param non-empty-string $password Пароль пользователя
     *
     * @throws ApiClientException
     */
    public function confirmEmail(
        string $confirmCode,
        string $password,
    ): void {
        $confirmEmail = new ConfirmEmail(
            apiClient: $this->apiClient
        );

        ($confirmEmail)(
            new ConfirmEmailRequest(
                confirmCode: $confirmCode,
                password: $password,
            )
        );
    }

    /**
     * Отменяет процесс изменения email
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Email/#H41E44243C43543D44F43544243F44043E44643544144143843743C43543D43543D43844Femail
     *
     * @throws ApiClientException
     */
    public function emailCancelChange(): void
    {
        $emailCancelChange = new EmailCancelChange(
            apiClient: $this->apiClient
        );

        ($emailCancelChange)();
    }

    /**
     * Возвращает информацию о номере телефона клиента
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/PhoneNumber/?srid=tnpSfw8N#H41243E43743244043044943043544243843D44443E44043C43044643844E43E43D43E43C43544043544243543B43544443E43D43043A43B43843543D442430
     *
     * @throws ApiClientException
     */
    public function getPhoneNumber(): PhoneNumberState
    {
        $getPhoneNumber = new GetPhoneNumber(
            apiClient: $this->apiClient,
        );

        return ($getPhoneNumber)();
    }

    /**
     * Начинает процесс привязки номера телефона
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/PhoneNumber/#H41D43044743843D43043544243F44043E44643544144143F44043843244F43743A43843D43E43C43544043044243543B43544443E43D430
     *
     * @param non-empty-string $phoneNumber Новый номер телефона
     *
     * @throws ApiClientException
     */
    public function changePhoneNumber(string $phoneNumber): PhoneNumberChanged
    {
        $phone = new Phone($phoneNumber);

        $changePhoneNumber = new ChangePhoneNumber(
            apiClient: $this->apiClient,
        );

        return ($changePhoneNumber)($phone);
    }

    /**
     * Повторно отправляет код подтверждения на новый номер телефона
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/PhoneNumber/?srid=tnpSfw8N#H41F43E43244243E44043D43E43E44243F44043043243B44F43544243A43E434A043F43E43444243243544043643443543D43844F43D43043D43E43244B43943D43E43C43544044243543B43544443E43D430
     *
     * @throws ApiClientException
     */
    public function phoneNumberSendConfirmCode(): void
    {
        $changePhoneNumber = new SendConfirmCode(
            apiClient: $this->apiClient,
        );

        ($changePhoneNumber)();
    }

    /**
     * Завершает процесс привязки номера телефона
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/PhoneNumber/#H41743043243544044843043544243F44043E44643544144143F44043843244F43743A43843D43E43C435440430A044243543B43544443E43D430
     *
     * @param non-empty-string $confirmCode Код подтверждения
     * @param non-empty-string $password Пароль пользователя
     *
     * @throws ApiClientException
     */
    public function confirmPhoneNumber(
        string $confirmCode,
        string $password
    ): AccessTokenData {
        $request = new ConfirmPhoneRequest(
            confirmCode: $confirmCode,
            password: $password,
        );

        $confirmPhoneNumber = new ConfirmPhoneNumber($this->apiClient);

        return ($confirmPhoneNumber)($request);
    }

    /**
     * Отменяет процесс привязки номера телефона
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/PhoneNumber/#H41E44243C43543D44F43544243F44043E44643544144143F44043843244F43743A43843D43E43C43544043044243543B43544443E43D430
     *
     * @throws ApiClientException
     */
    public function phoneNumberCancelChange(): void
    {
        $phoneNumberCancelChange = new PhoneNumberCancelChange($this->apiClient);

        ($phoneNumberCancelChange)();
    }

    /**
     * Устанавливает пароль клиенту
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Password/#H42344144243043D43043243B43843243043544243F43044043E43B44C43A43B43843543D442443
     *
     * @param non-empty-string $newPassword Новый пароль
     *
     * @throws ApiClientException
     */
    public function setPassword(string $newPassword): AccessTokenData
    {
        $setPasswordRequest = new SetPasswordRequest($newPassword);

        $setPassword = new SetPassword(
            apiClient: $this->apiClient,
        );

        return ($setPassword)($setPasswordRequest);
    }

    /**
     * Обновляет пароль клиента
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Password/#H41E43143D43E43243B44F43544243F43044043E43B44C43A43B43843543D442430
     *
     * @param non-empty-string $oldPassword Старый пароль
     * @param non-empty-string $newPassword Новый пароль
     *
     * @throws ApiClientException
     */
    public function changePassword(string $oldPassword, string $newPassword): AccessTokenData
    {
        $request = new ChangePasswordRequest(
            oldPassword: $oldPassword,
            newPassword: $newPassword,
        );

        $changePassword = new ChangePassword(
            apiClient: $this->apiClient
        );

        return ($changePassword)($request);
    }

    /**
     * Оформляет подписку на все типы рассылок при регистрации нового клиента
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/Subscriptions/#H41E44443E44043C43B44F43544243F43E43443F43844143A44343D43043244143544243843F44B44043044144144B43B43E43A43F44043844043543343844144244043044643843843D43E43243E43343E43A43B43843543D442430
     *
     * @throws ApiClientException
     */
    public function confirmSubscriptions(): void
    {
        $confirmSubscriptions = new ConfirmSubscriptions(
            apiClient: $this->apiClient
        );

        ($confirmSubscriptions)();
    }

    /**
     * Возвращает список подписок клиента
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/Subscriptions/#H41243E43743244043044943043544244143F43844143E43A43F43E43443F43844143E43A43A43B43843543D442430
     *
     * @param non-empty-list<SubscriptionExternalId> $subscriptionExternalIds
     *
     * @return list<Subscription>
     *
     * @throws ApiClientException
     */
    public function getSubscriptions(array $subscriptionExternalIds): array
    {
        $getSubscriptionsRequest = new GetSubscriptionRequest(
            subscriptionExternalIds: $subscriptionExternalIds,
        );

        $getSubscriptions = new GetSubscriptions(
            apiClient: $this->apiClient
        );

        return ($getSubscriptions)($getSubscriptionsRequest);
    }

    /**
     * Обновляет информацию о подписках клиента
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/Subscriptions/#H41E43143D43E43243B44F435442A043843D44443E44043C43044643844E43E43F43E43443F43844143A43044543A43B43843543D442430
     *
     * @param non-empty-list<UpdatedSubscription> $updatingSubscriptions
     *
     * @throws ApiClientException
     */
    public function updateSubscriptions(array $updatingSubscriptions): void
    {
        $updateSubscriptions = new UpdateSubscriptions(
            apiClient: $this->apiClient
        );

        ($updateSubscriptions)($updatingSubscriptions);
    }

    /**
     * Оформляет отказ от всех типов подписок
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/Subscriptions/#H41E44443E44043C43B44F43544243E44243A43043743E44243244143544544243843F43E43243F43E43443F43844143E43A
     *
     * @throws ApiClientException
     */
    public function rejectSubscriptions(): void
    {
        $rejectSubscriptions = new RejectSubscriptions(
            apiClient: $this->apiClient
        );

        ($rejectSubscriptions)();
    }

    /**
     * Возвращает список необходимых шагов регистрации
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#03
     *
     * @throws ApiClientException
     */
    public function getRegistrationActions(): RegistrationActionList
    {
        $getRegistrationActions = new GetRegistrationActions(
            apiClient: $this->apiClient
        );

        return ($getRegistrationActions)();
    }

    /**
     * Обновляет ответы на вопросы анкеты
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#10
     *
     * @param list<Answer> $answers
     *
     * @throws ApiClientException
     */
    public function sendAnswers(array $answers): AnswerErrors
    {
        $sendAnswers = new SendAnswers(
            apiClient: $this->apiClient,
        );

        return ($sendAnswers)($answers);
    }
}
