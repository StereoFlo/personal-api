<?php

namespace App\Controller;

use App\Commands\UserRegisterCommand;
use App\Entity\ApiToken;
use App\Repository\User\UserReadInterface;
use App\Repository\User\UserWriteInterface;
use HttpInvalidParamException;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
     * @var UserReadInterface
     */
    private $userRead;

    /**
     * @var UserWriteInterface
     */
    private $userWrite;

    /**
     * @var AbstractController
     */
    private $controller;

    /**
     * AuthController constructor.
     *
     * @param CommandBus         $bus
     * @param UserReadInterface  $userRead
     * @param UserWriteInterface $userWrite
     * @param AbstractController $controller
     */
    public function __construct(CommandBus $bus, UserReadInterface $userRead, UserWriteInterface $userWrite, AbstractController $controller)
    {
        $this->bus            = $bus;
        $this->userRead       = $userRead;
        $this->userWrite      = $userWrite;
        $this->controller     = $controller;
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

        $user = $this->userRead->getByEmail($email);

        return $this->controller->json($user, 'user-public', 202);
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
            throw new HttpInvalidParamException('form.input.empty');
        }

        $user = $this->userRead->getByEmail($email);

        if (!$user) {
            throw new UnauthorizedHttpException('login.not.found');
        }

        if (!\password_verify($password, $user->getPassword())) {
            throw new UnauthorizedHttpException('invalid.password');
        }

        $this->userWrite->save($user->setLastLogin()->setApiToken());

        return $this->controller->json($user, 'user-public', 202);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws HttpInvalidParamException
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->request->get('token');
        if (empty($token)) {
            throw new HttpInvalidParamException('token.empty');
        }
        $user = $this->userRead->getByToken(new ApiToken($token));
        if (empty($user)) {
            return $this->controller->acceptJson('logged.out');
        }
        $user->setApiToken(true);
        $this->userWrite->save($user);

        return $this->controller->acceptJson('logged.out');
    }
}