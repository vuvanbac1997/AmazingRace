<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\ChallengeRepositoryInterface;
use App\Http\Requests\Admin\ChallengeRequest;
use App\Http\Requests\PaginationRequest;

class ChallengeController extends Controller
{

    /** @var \App\Repositories\ChallengeRepositoryInterface */
    protected $challengeRepository;


    public function __construct(
        ChallengeRepositoryInterface $challengeRepository
    )
    {
        $this->challengeRepository = $challengeRepository;
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
        $paginate['baseUrl']    = action( 'Admin\ChallengeController@index' );

        $count = $this->challengeRepository->count();
        $challenges = $this->challengeRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.challenges.index',
            [
                'challenges'    => $challenges,
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
            'pages.admin.' . config('view.admin') . '.challenges.edit',
            [
                'isNew'     => true,
                'challenge' => $this->challengeRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(ChallengeRequest $request)
    {
        $input = $request->only(['title','content','score','answer']);
        
        $input['is_enabled'] = $request->get('is_enabled', 0);
        $challenge = $this->challengeRepository->create($input);

        if (empty( $challenge )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\ChallengeController@index')
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
        $challenge = $this->challengeRepository->find($id);
        if (empty( $challenge )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.challenges.edit',
            [
                'isNew' => false,
                'challenge' => $challenge,
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
    public function update($id, ChallengeRequest $request)
    {
        /** @var \App\Models\Challenge $challenge */
        $challenge = $this->challengeRepository->find($id);
        if (empty( $challenge )) {
            abort(404);
        }
        $input = $request->only(['title','content','score','answer']);
        
        $input['is_enabled'] = $request->get('is_enabled', 0);
        $this->challengeRepository->update($challenge, $input);

        return redirect()->action('Admin\ChallengeController@show', [$id])
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
        /** @var \App\Models\Challenge $challenge */
        $challenge = $this->challengeRepository->find($id);
        if (empty( $challenge )) {
            abort(404);
        }
        $this->challengeRepository->delete($challenge);

        return redirect()->action('Admin\ChallengeController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
