<?php

namespace App\Services\Production;

use App\Models\AdminUserRole;
use App\Repositories\AdminUserRepositoryInterface;
use App\Repositories\AdminPasswordResetRepositoryInterface;
use App\Services\AdminUserServiceInterface;
use App\Repositories\AdminUserRoleRepositoryInterface;

class AdminUserService extends AuthenticatableService implements AdminUserServiceInterface
{
    /** @var string $resetEmailTitle */
    protected $resetEmailTitle = 'Reset Password';

    /** @var string $resetEmailTemplate */
    protected $resetEmailTemplate = 'emails.admin.reset_password';

    /** @var \App\Repositories\AdminUserRoleRepositoryInterface */
    protected $adminUserRoleRepository;

    public function __construct(
        AdminUserRepositoryInterface            $adminUserRepository,
        AdminPasswordResetRepositoryInterface   $adminPasswordResetRepository,
        AdminUserRoleRepositoryInterface        $adminUserRoleRepository
    ) {
        $this->authenticatableRepository    = $adminUserRepository;
        $this->passwordResettableRepository = $adminPasswordResetRepository;
        $this->adminUserRoleRepository      = $adminUserRoleRepository;
    }

    public function getGuardName()
    {
        return 'admins';
    }

    public function getAllCoach()
    {
        // pluck trả về giá trị 1 cột
        $coachIds = $this->adminUserRoleRepository->getBlankModel()->where('role', AdminUserRole::ROLE_COACH)->get()->pluck('admin_user_id')->toArray();

        $coachs = $this->authenticatableRepository->getBlankModel()->whereIn('id', $coachIds)->get();

        return $coachs;
    }
}
