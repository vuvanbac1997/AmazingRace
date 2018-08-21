<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\TeamRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;
use App\Http\Requests\Admin\TeamRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\AdminUserRepositoryInterface;
use App\Services\AdminUserServiceInterface;

class TeamController extends Controller
{

    /** @var \App\Repositories\TeamRepositoryInterface */
    protected $teamRepository;

    /** @var \App\Repositories\CompanyRepositoryInterface */
    protected $companyRepository;

    /** @var \App\Repositories\AdminUserRepositoryInterface */
    protected $adminuserRepository;

    /** @var \App\Services\AdminUserServiceInterface */
    protected $adminUserService;

    public function __construct(
        TeamRepositoryInterface $teamRepository,
        CompanyRepositoryInterface $companyRepository,
        AdminUserRepositoryInterface $adminUserRepository,
        AdminUserServiceInterface   $adminUserService
    )
    {
        $this->teamRepository = $teamRepository;
        $this->companyRepository = $companyRepository;
        $this->adminuserRepository = $adminUserRepository;
                $this->adminUserService     = $adminUserService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     * @return \Response
     */
    public function index(PaginationRequest $request)
    {
        $paginate['limit']      = $request->limit();
        $paginate['offset']     = $request->offset();
        $paginate['order']      = $request->order();
        $paginate['direction']  = $request->direction();
        $paginate['baseUrl']    = action( 'Admin\TeamController@index' );

        $count = $this->teamRepository->count();
        $teams = $this->teamRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.teams.index',
            [
                'teams'    => $teams,
                'count'         => $count,
                'paginate'      => $paginate,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {

        return view(
            'pages.admin.' . config('view.admin') . '.teams.edit',
            [
                'isNew'     => true,
                'team' => $this->teamRepository->getBlankModel(),
                'companies'=> $this->companyRepository->all(),
                'coachs'    => $this->adminUserService->getAllCoach()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(TeamRequest $request)
    {
        $input = $request->only(['username','display_name','password','id_coach','id_company','api_access_token','is_activated','remember_token']);

        $input['is_enabled'] = $request->get('is_enabled', 0);
        $team = $this->teamRepository->create($input);

        if (empty( $team )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\TeamController@index')
            ->with('message-success', trans('admin.messages.general.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Response
     */
    public function show($id)
    {
        $team = $this->teamRepository->find($id);
        if (empty( $team )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.teams.edit',
            [
                'isNew' => false,
                'team' => $team,
                'companies'=> $this->companyRepository->all(),
                'coachs'    => $this->adminUserService->getAllCoach()
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param      $request
     * @return \Response
     */
    public function update($id, TeamRequest $request)
    {
        /** @var \App\Models\Team $team */
        $team = $this->teamRepository->find($id);
        if (empty( $team )) {
            abort(404);
        }
        $input = $request->only(['username','display_name','password','id_coach','id_company','api_access_token','is_activated','remember_token']);

        $input['is_enabled'] = $request->get('is_enabled', 0);
        $this->teamRepository->update($team, $input);

        return redirect()->action('Admin\TeamController@show', [$id])
                    ->with('message-success', trans('admin.messages.general.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Response
     */
    public function destroy($id)
    {
        /** @var \App\Models\Team $team */
        $team = $this->teamRepository->find($id);
        if (empty( $team )) {
            abort(404);
        }
        $this->teamRepository->delete($team);

        return redirect()->action('Admin\TeamController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
