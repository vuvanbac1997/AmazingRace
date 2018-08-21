<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\PlayerRepositoryInterface;
use App\Repositories\TeamRepositoryInterface;
use App\Http\Requests\Admin\PlayerRequest;
use App\Http\Requests\PaginationRequest;
use App\Services\FileUploadServiceInterface;

class PlayerController extends Controller
{

    /** @var \App\Repositories\PlayerRepositoryInterface */
    protected $playerRepository;

    /** @var \App\Repositories\TeamRepositoryInterface */
    protected $teamRepository;

    /** @var FileUploadServiceInterface $fileUploadService */
    protected $fileUploadService;

    public function __construct(
        PlayerRepositoryInterface $playerRepository,
        TeamRepositoryInterface $teamRepository,
        FileUploadServiceInterface $fileUploadService
    )
    {
        $this->playerRepository = $playerRepository;
        $this->teamRepository = $teamRepository;
        $this->fileUploadService = $fileUploadService;
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
        $paginate['baseUrl']    = action( 'Admin\PlayerController@index' );

        $count = $this->playerRepository->count();
        $players = $this->playerRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.players.index',
            [
                'players'    => $players,
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
            'pages.admin.' . config('view.admin') . '.players.edit',
            [
                'isNew'     => true,
                'player' => $this->playerRepository->getBlankModel(),
                'teams'  => $this->teamRepository->all()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(PlayerRequest $request)
    {
        $input = $request->only(['name','id_coach','id_team']);
        
        $input['is_enabled'] = $request->get('is_enabled', 0);
        $player = $this->playerRepository->create($input);

        if (empty( $player )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        if ($request->hasFile('cover-image')) {
            $file       = $request->file('cover-image');
            $image = $this->fileUploadService->upload(
                'player_cover_image',
                $file,
                [
                    'entity_type' => 'player_cover_image',
                    'entity_id'   => $player->id,
                    'title'       => $request->input('name', ''),
                ]
            );

            if (!empty($image)) {
                $this->playerRepository->update($player, ['cover_image_id' => $image->id]);
            }
        }

        return redirect()->action('Admin\PlayerController@index')
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
        $player = $this->playerRepository->find($id);
        if (empty( $player )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.players.edit',
            [
                'isNew' => false,
                'player' => $player,
                'teams'  => $this->teamRepository->all(),
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
    public function update($id, PlayerRequest $request)
    {
        /** @var \App\Models\Player $player */
        $player = $this->playerRepository->find($id);
        if (empty( $player )) {
            abort(404);
        }
        $input = $request->only(['name','id_coach','id_team']);
        
        $input['is_enabled'] = $request->get('is_enabled', 0);
        $this->playerRepository->update($player, $input);

        if ($request->hasFile('cover-image')) {
            $currentImage = $player->coverImage;
            $file = $request->file('cover-image');
            
            $newImage = $this->fileUploadService->upload(
                'player_cover_image',
                $file,
                [
                    'entity_type' => 'player_cover_image',
                    'entity_id'   => $player->id,
                    'title'       => $request->input('name', ''),
                ]
            );

            if (!empty($newImage)) {
                $input['cover_image_id'] = $newImage->id;

                if (!empty($currentImage)) {
                    $this->fileUploadService->delete($currentImage);
                }
            }
        }

        return redirect()->action('Admin\PlayerController@show', [$id])
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
        /** @var \App\Models\Player $player */
        $player = $this->playerRepository->find($id);
        if (empty( $player )) {
            abort(404);
        }
        $this->playerRepository->delete($player);

        return redirect()->action('Admin\PlayerController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
