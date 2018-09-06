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
        TeamRepositoryInterface                 $teamRepository,
        UserPasswordResetRepositoryInterface    $teamPasswordResetRepository,
        OauthClientRepositoryInterface          $oauthClientRepository
    )
    {
        $this->authenticatableRepository    = $teamRepository;
        $this->passwordResettableRepository = $teamPasswordResetRepository;
        $this->oauthClientRepository        = $oauthClientRepository;
    }

    public function getGuardName()
    {
        return 'api';
    }

    public function setAPIAccessToken($user)
    {
        $user->setAPIAccessToken();
        $this->authenticatableRepository->save($user);

        return $user;
    }
//
    public function signUp($input)
    {
        // TODO: Implement signUp() method.
        $existingUser = $this->authenticatableRepository->findByUsername(array_get($input, 'username'));
        if ( !empty($existingUser) ) {
            return null;
        }

        /** @var \App\Models\AuthenticatableBase $user */
        $team = $this->authenticatableRepository->create($input);
        if (empty($team)) {
            return false;
        }
        $guard = $this->getGuard();
        $guard->setUser($team);

        return $guard->user();
    }

    public function signUpByAPI($input)
    {
        // TODO: Implement signUpByAPI() method.
        /** @var \App\Models\AuthenticatableBase $user */
        $team = $this->signUp($input);
        if (empty($team)) {
            return null;
        }

        return $this->setAPIAccessToken($team);
    }
}
