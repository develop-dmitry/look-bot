<?php

declare(strict_types=1);

namespace Look\Application\SupportMessage\CreateSupportMessage;

use Look\Application\Builder\Exception\NoRequiredPropertiesException;
use Look\Application\Dictionary\DictionaryInterface;
use Look\Application\SupportMessage\CreateSupportMessage\Interface\CreateSupportMessageInterface;
use Look\Application\SupportMessage\CreateSupportMessage\Interface\CreateSupportMessageRequestInterface;
use Look\Application\SupportMessage\CreateSupportMessage\Interface\CreateSupportMessageResponseInterface;
use Look\Domain\Exception\RepositoryException;
use Look\Domain\SupportMessage\Interface\SupportMessageBuilderInterface;
use Look\Domain\SupportMessage\Interface\SupportMessageInterface;
use Look\Domain\SupportMessage\Interface\SupportMessageRepositoryInterface;
use Look\Domain\Value\Exception\InvalidValueException;

class CreateSupportMessageUseCase implements CreateSupportMessageInterface
{
    public function __construct(
        protected SupportMessageRepositoryInterface $supportMessageRepository,
        protected SupportMessageBuilderInterface $supportMessageBuilder,
        protected DictionaryInterface $dictionary
    ) {
    }

    public function createSupportMessage(CreateSupportMessageRequestInterface $request): CreateSupportMessageResponseInterface
    {
        try {
            $this->supportMessageRepository->createSupportMessage($this->makeEntity($request));

            return new CreateSupportMessageResponse(true);
        } catch (RepositoryException) {
            $error = $this->dictionary->getTranslate('common.errors.network_error');
        } catch (InvalidValueException) {
            $error = $this->dictionary->getTranslate('common.errors.invalid_value');
        } catch (NoRequiredPropertiesException) {
            $error = $this->dictionary->getTranslate('common.errors.required_properties');
        }

        return new CreateSupportMessageResponse(false, $error);
    }

    /**
     * @throws InvalidValueException
     * @throws NoRequiredPropertiesException
     */
    protected function makeEntity(CreateSupportMessageRequestInterface $request): SupportMessageInterface
    {
        return $this->supportMessageBuilder
            ->setClientId($request->getClientId())
            ->setContext($request->getContext())
            ->setMessage($request->getMessage())
            ->make();
    }
}
