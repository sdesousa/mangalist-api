<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Authorization\UserAuthorizationChecker;
use App\Entity\User;
use DateTimeImmutable;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserSubscriber implements EventSubscriberInterface
{
    private array $methodNotAllowed = [
        Request::METHOD_POST,
        Request::METHOD_GET,
    ];
    private UserAuthorizationChecker $userAuthorizationChecker;

    public function __construct(UserAuthorizationChecker $userAuthorizationChecker)
    {
        $this->userAuthorizationChecker = $userAuthorizationChecker;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['check', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function check(ViewEvent $event): void
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        if ($user instanceof User && !in_array($method, $this->methodNotAllowed, true)) {
            $this->userAuthorizationChecker->check($user, $method);
            $user->setUpdatedAt(new DateTimeImmutable());
        }
    }
}
