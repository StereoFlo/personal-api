<?php

namespace App\Controller;

use App\Commands\UserRegisterCommand;
use App\Repository\UserInterface;
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

    private $userRepository;

    /**
     * AuthController constructor.
     *
     * @param CommandBus    $bus
     * @param UserInterface $userRepository
     */
    public function __construct(CommandBus $bus, UserInterface $userRepository)
    {
        $this->bus = $bus;
        $this->userRepository = $userRepository;
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
        $password = $request->request->get('password');

        $this->bus->handle(new UserRegisterCommand($username, $email, $password));

        return new JsonResponse(['success' => true, 'message' => 'success registred']);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function login(Request $request): JsonResponse
    {
        $email    = $request->request->get('email');
        $password = $request->request->get('password');

        if (empty($email) || empty($password)) {
            throw new \Exception('form.input.empty');
        }

        $user = $this->userRepository->getByEmail($email);

        if (!$user) {
            throw new \Exception('login.not.found');
        }

        if (!\password_verify($password, $user->getPassword())) {
            throw new \Exception('invalid.password');
        }

        $this->userRepository->save($user->setUpdatedAt());

        return new JsonResponse(['success' => true, 'message' => 'success logged in', 'data' => ['token' => $user->getApiToken()->getKey()]]);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        return JsonResponse::create(['success' => true]);
    }
}