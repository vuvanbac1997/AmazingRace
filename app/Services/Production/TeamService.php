<?php namespace App\Services\Production;

use App\Repositories\OauthClientRepositoryInterface;
use App\Repositories\TeamRepositoryInterface;
use App\Repositories\UserPasswordResetRepositoryInterface;
use App\Services\TeamServiceInterface;

class TeamService extends AuthenticatableService implements TeamServiceInterface
{
    /** @var \App\Repositories\OauthClientRepositoryInterface */
    protected $oauthClientRepository;

    /** @var string $resetEmailTitle */
    protected $resetEmailTitle = 'Reset Password';

    /** @var string $resetEmailTemplate */
    protected $resetEmailTemplate = 'emails.user.reset_password';

    public function __construct(
        TeamRepositoryInterface                 $userRepository,
        OauthClientRepositoryInterface          $oauthClientRepository
    )
    {
        $this->authenticatableRepository    = $userRepository;
        $this->oauthClientRepository        = $oauthClientRepository;
    }

    public function getGuardName()
    {
        return 'api';
    }
}
