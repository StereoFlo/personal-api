<?php

namespace App\Controller;

use App\Commands\UserRegisterCommand;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthController
 * @package App\Controller
 */
class AuthController
{
    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * AuthController constructor.
     *
     * @param CommandBus $bus
     */
    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $email    = $request->request->get('email');
        $username = $request->request->get('username');
        $password = $request->request->get('email');

        $this->bus->handle(new UserRegisterCommand($username, $email, $password));

        return new JsonResponse(['success' => true, 'message' => 'success registred']);
    }
}