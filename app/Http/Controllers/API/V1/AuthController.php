<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\PsrServerRequest;
use App\Http\Requests\API\V1\RefreshTokenRequest;
use App\Http\Requests\API\V1\SignInRequest;
use App\Http\Requests\API\V1\SignUpRequest;
use App\Services\UserServiceInterface;
use App\Services\APIUserServiceInterface;
use App\Repositories\UserRepositoryInterface;
use League\OAuth2\Server\AuthorizationServer;
use Zend\Diactoros\Response as Psr7Response;
use App\Http\Responses\API\V1\Response;
use App\Repositories\TeamRepositoryInterface;
use App\Services\TeamServiceInterface;

class AuthController extends Controller
{
    /** @var \App\Services\UserServiceInterface */
    protected $userService;

    /** @var \App\Repositories\UserRepositoryInterface */
    protected $userRepository;

    /** @var \App\Repositories\TeamRepositoryInterface */
    protected $teamRepository;

    /** @var AuthorizationServer */
    protected $server;

    /** @var \App\Services\TeamServiceInterface */
    protected $teamService;

    public function __construct(
        UserServiceInterface        $userService,
        UserRepositoryInterface     $userRepository,
        AuthorizationServer         $server,
        teamRepositoryInterface     $teamRepository,
        teamServiceInterface        $teamService
    )
    {
        $this->userService          = $userService;
        $this->userRepository       = $userRepository;
        $this->server               = $server;
        $this->teamRepository       = $teamRepository;
        $this->teamService          = $teamService;
    }

    public function signIn(SignInRequest $request)
    {
        $data = $request->only(
            [
                'username',
                'password',
                'grant_type',
                'client_id',
                'client_secret'
            ]
        );
        $data['grant_type'] = 'password';

        $check = $this->userService->checkClient($request);
        if( !$check ) {
            return Response::response(40101);
        }

        $team = $this->teamRepository->checkTeam($data['username']);
        //return $team;
        if (!$team){
            return Response::response(40101);
        }
        //data
//        $data['username'] = $data['username'];
//        $data['password'] = $data['password'];


        $serverRequest = PsrServerRequest::createFromRequest($request, $data);

        return $this->server->respondToAccessTokenRequest($serverRequest, new Psr7Response);
    }

    public function signUp(SignUpRequest $request)
    {
        $data = $request->only(
            [
                // 'name',
                'username',
                'password',
                'display_name',
                'grant_type',
                'client_id',
                'client_secret',
//                'telephone',
//                'birthday',
//                'locale',
            ]
        );

        $check = $this->userService->checkClient($request);
        if( !$check ) {
            return Response::response(40101);
        }
        $userDeleted = $this->teamRepository->findByUsername($data['username'], true);
        if (!empty($userDeleted)) {
            return Response::response(40002);
        }

        $this->teamService->signUp($data);

        $data['username'] = $data['username'];
        $serverRequest = PsrServerRequest::createFromRequest($request, $data);
        
        $response = $this->server->respondToAccessTokenRequest($serverRequest, new Psr7Response);
        return $response->withStatus(201);
    }

    public function refreshToken(RefreshTokenRequest $request)
    {
        $this->userService->checkClient($request);
        $serverRequest = PsrServerRequest::createFromRequest($request);

        return $this->server->respondToAccessTokenRequest($serverRequest, new Psr7Response);
    }
}
