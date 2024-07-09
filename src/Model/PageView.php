<?php

namespace App\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class PageView
{
    public string $identifier;
    // Server
    public string $userAgent; // HTTP_USER_AGENT
    public string $ip; // REMOTE_ADDR
    public string $referer; // HTTP_REFERER
    public string $acceptLanguage; // HTTP_ACCEPT_LANGUAGE
    public string $platform; // HTTP_SEC_CH_UA_PLATFORM

    // Kernle
    public string $route; // kernel -> _route
    public array $options; // kernel -> _route_params

    // logged in user
    public ?UserInterface $user = null;

    public function __construct(Request $request, $identifier = null)
    {
        $this->identifier = $identifier ?? bin2hex(random_bytes(16));
        $this->userAgent = $request->headers->get('User-Agent') ?? '';
        $this->ip = match (true) {
            $request->server->has('HTTP_CLIENT_IP') => $request->server->get('HTTP_CLIENT_IP'),
            $request->server->has('HTTP_X_FORWARDED_FOR') => $request->server->get('REMOTE_ADDR'),
            default => $request->server->get('REMOTE_ADDR', ''),
        };
        $this->referer = $request->headers->get('Referer') ?? '';
        $this->acceptLanguage = $request->headers->get('Accept-Language') ?? '';
        $this->platform = $request->headers->get('Platform') ??
            $request->server->get('HTTP_SEC_CH_UA_PLATFORM') ?? '';
        $this->route = $request->attributes->get('_route') ?? '';
        $this->options = $request->attributes->get('_route_params') ?? [];
        //        $this->user = $request->getUser();

        if ($request->hasSession()) {
            $request->getSession()->set('pvkey', $this->identifier);
        }
    }

    public static function fromRequest(Request $request): self
    {
        if ($request->hasSession() && $request->getSession()->has('pvkey')) {
            return new self($request, $request->getSession()->get('pvkey'));
        }

        return new self($request);
    }
}
