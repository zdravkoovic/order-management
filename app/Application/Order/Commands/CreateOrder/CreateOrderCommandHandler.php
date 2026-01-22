<?php

namespace App\Application\Order\Commands\CreateOrder;

use App\Application\Abstraction\BaseCommandHandler;
use App\Application\Abstraction\ICommand;
use App\Application\Command\CommandResult;
use App\Application\Errors\DomainToAppErrorTranslator;
use App\Application\Order\Expiration\GuestOrderExpirationPolicy;
use App\Application\Order\Expiration\RegisteredOrderExpirationPolicy;
use App\Application\UnitOfWork\IUnitOfWork;
use App\Domain\IAggregateRoot;
use App\Domain\Interfaces\IOrderRepository;
use App\Domain\OrderAggregate\CustomerId;
use App\Domain\OrderAggregate\Order;
use App\Domain\OrderAggregate\OrderBuilder;
use App\Domain\OrderAggregate\OrderId;
use App\Domain\OrderAggregate\OrderState;
use App\Domain\Shared\Uuid;
use DomainException;
use Symfony\Component\Clock\Clock;

final class CreateOrderCommandHandler extends BaseCommandHandler
{
    private ?Order $createdOrder;
    private ?OrderId $orderId;

    public function __construct(
        private IOrderRepository $orderRepository,
        private GuestOrderExpirationPolicy $guestOrderExpirationPolicy,
        private RegisteredOrderExpirationPolicy $registeredOrderExpirationPolicy,
        private DomainToAppErrorTranslator $translator,
        private Clock $clock,
        // IDomainEventDispatcher $domainEventDispatcher,
    ){
        parent::__construct();
    }

    protected function Execute(ICommand $command): CommandResult
    {
        /** @var CreateOrderCommand $command */
        $policy = $command->isGuest
            ? $this->guestOrderExpirationPolicy
            : $this->registeredOrderExpirationPolicy;
        // $existingOrderState = $this->orderRepository->FindOrderStateForCustomer(
        //     CustomerId::fromString($command->customerId)
        // );
        $this->createdOrder = OrderBuilder::draft()
            ->forCustomer(CustomerId::fromString($command->customerId))
            ->withExpirationTime($policy->expiresAt($this->clock->now()))
            ->build();
        $this->orderId = $this->orderRepository->Add($this->createdOrder);
        return CommandResult::success($this->orderId->getId());
    }

    protected function GetAggregateRoot(): IAggregateRoot | null
    {
        return $this->createdOrder ?? null;
    }

    protected function ClearAggregateState(): void
    {
        $this->createdOrder = null;
        $this->orderId = null;
    }
}