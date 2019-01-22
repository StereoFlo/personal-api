<?php

namespace Controller;

use Domain\Commands\User\UserRegisterCommand;
use Domain\User\Repository\UserReadInterface;
use Domain\User\Repository\UserRepository;
use Domain\User\Repository\UserWriteInterface;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Class AuthApiController
 * @package Controller
 */
class AuthApiController extends AbstractApiController
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
     * AuthApiController constructor.
     *
     * @param CommandBus         $bus
     * @param UserRepository     $userRead
     * @param UserRepository     $userWrite
     */
    public function __construct(CommandBus $bus, UserRepository $userRead, UserRepository $userWrite)
    {
        $this->bus            = $bus;
        $this->userRead       = $userRead;
        $this->userWrite      = $userWrite;
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

        return $this->json($user, 'user-public', 202);
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

        $user = $this->userRead->getByEmail($email);

        if (!$user) {
            throw new UnauthorizedHttpException('login.not.found');
        }

        if (!\password_verify($password, $user->getPassword())) {
            throw new UnauthorizedHttpException('invalid.password');
        }

        $this->userWrite->save($user->setLastLogin()->setApiToken());

        return $this->json($user, 'user-public', 202);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->request->get('token');
        if (empty($token)) {
            throw new \Exception('token.empty');
        }
        $user = $this->userRead->getByToken($token);
        if (empty($user)) {
            return $this->acceptJson('logged.out');
        }
        $user->setApiToken(true);
        $this->userWrite->save($user);

        return $this->acceptJson('logged.out');
    }
}