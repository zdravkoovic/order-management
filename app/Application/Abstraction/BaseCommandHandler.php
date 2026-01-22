<?php

namespace App\Application\Abstraction;

use App\Application\Command\CommandResult;
use App\Domain\IAggregateRoot;

abstract class BaseCommandHandler implements ICommandHandler
{
    public function __construct(
        private IDomainEventDispatcher $domainEventDispatcher
    ){}

    public function Handle(ICommand $command) : CommandResult
    {
        $result = $this->Execute($command);

        if(!$result instanceof CommandResult) {
            throw new \LogicException('Execute() must return CommandResult');
        }

        if(!$result->success) {
            $this->ClearAggregateState();
            return $result;
        }

        $aggregate = $this->GetAggregateRoot();
        if($aggregate != null)
        {
            foreach($aggregate->PopDomainEvents() as $event)
            {
                $this->domainEventDispatcher->Dispatch($event);
            }
        }

        return $result;
    }

    protected abstract function Execute(ICommand $command) : CommandResult;
    protected abstract function GetAggregateRoot() : IAggregateRoot | null;
    protected abstract function ClearAggregateState() : void;
}