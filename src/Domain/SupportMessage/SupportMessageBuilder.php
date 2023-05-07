<?php

declare(strict_types=1);

namespace Look\Domain\SupportMessage;

use Look\Application\Builder\AbstractBuilder;
use Look\Application\Builder\UseId\HasId;
use Look\Domain\SupportMessage\Interface\SupportMessageBuilderInterface;
use Look\Domain\SupportMessage\Interface\SupportMessageInterface;
use Look\Domain\Value\Factory\ValueFactoryInterface;

class SupportMessageBuilder extends AbstractBuilder implements SupportMessageBuilderInterface
{
    use HasId;

    protected array $required = ['client_id', 'context', 'message'];

    public function __construct(
        protected ValueFactoryInterface $valueFactory
    ) {
    }

    public function setClientId(int $clientId): SupportMessageBuilderInterface
    {
        $this->values['client_id'] = $clientId;
        return $this;
    }

    public function setContext(string $context): SupportMessageBuilderInterface
    {
        $this->values['context'] = $context;
        return $this;
    }

    public function setMessage(string $message): SupportMessageBuilderInterface
    {
        $this->values['message'] = $message;
        return $this;
    }

    public function setResolved(bool $resolved): SupportMessageBuilderInterface
    {
        $this->values['resolved'] = $resolved;
        return $this;
    }

    public function make(): SupportMessageInterface
    {
        $this->checkRequired();

        $supportMessage = (new SupportMessage())
            ->setClientId($this->valueFactory->makeId($this->getValue('client_id')))
            ->setContext($this->getValue('context', ''))
            ->setMessage($this->valueFactory->makeMessage($this->getValue('message', '')))
            ->setResolved($this->getValue('resolved', false));

        if ($this->hasValue('id')) {
            $supportMessage->setId($this->valueFactory->makeId($this->getValue('id')));
        }

        $this->reset();

        return $supportMessage;
    }
}
