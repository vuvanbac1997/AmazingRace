<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\BuildingRepositoryInterface;
use App\Http\Requests\Admin\BuildingRequest;
use App\Http\Requests\PaginationRequest;
use App\Services\AdminUserServiceInterface;
use App\Services\FileUploadServiceInterface;

class BuildingController extends Controller
{
    /** @var \App\Repositories\BuildingRepositoryInterface */
    protected $buildingRepository;

    /** @var \App\Services\AdminUserServiceInterface */
    protected $adminUserService;

    /** @var FileUploadServiceInterface $fileUploadService */
    protected $fileUploadService;

    public function __construct(
        BuildingRepositoryInterface     $buildingRepository,
        AdminUserServiceInterface       $adminUserService,
        FileUploadServiceInterface      $fileUploadService
    )
    {
        $this->buildingRepository       = $buildingRepository;
        $this->adminUserService         = $adminUserService;
        $this->fileUploadService        = $fileUploadService;
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
        $paginate['baseUrl']    = action( 'Admin\BuildingController@index' );

        $count = $this->buildingRepository->count();
        $buildings = $this->buildingRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.buildings.index',
            [
                'buildings' => $buildings,
                'count'     => $count,
                'paginate'  => $paginate,
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
            'pages.admin.' . config('view.admin') . '.buildings.edit',
            [
                'isNew'            => true,
                'building'         => $this->buildingRepository->getBlankModel(),
                'buildingManagers' => $this->adminUserService->getAllBuildingManager()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(BuildingRequest $request)
    {
        $input = $request->only(['code','name','address']);
        
        $input['admin_user_id'] = $request->get('admin_user_id', 0);

        $building = $this->buildingRepository->create($input);

        if (empty( $building )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');

            $image = $this->fileUploadService->upload(
                'building_cover_image',
                $file,
                [
                    'entity_type' => 'building_cover_image',
                    'entity_id'   => $building->id,
                    'title'       => $request->input('name', ''),
                ]
            );

            if (!empty($image)) {
                $this->buildingRepository->update($building, ['cover_image_id' => $image->id]);
            }
        }

        return redirect()->action('Admin\BuildingController@index')
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
        $building = $this->buildingRepository->find($id);
        if (empty( $building )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.buildings.edit',
            [
                'isNew'            => false,
                'building'         => $building,
                'buildingManagers' => $this->adminUserService->getAllBuildingManager()
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
    public function update($id, BuildingRequest $request)
    {
        /** @var \App\Models\Building $building */
        $building = $this->buildingRepository->find($id);
        if (empty( $building )) {
            abort(404);
        }
        $input = $request->only(['code','name','address']);
        
        $input['admin_user_id'] = $request->get('admin_user_id', 0);

        if ($request->hasFile('cover_image')) {
            $currentImage = $building->coverImage;
            $file = $request->file('cover_image');

            $newImage = $this->fileUploadService->upload(
                'building_cover_image',
                $file,
                [
                    'entity_type' => 'building_cover_image',
                    'entity_id'   => $building->id,
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

        $this->buildingRepository->update($building, $input);

        return redirect()->action('Admin\BuildingController@show', [$id])
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
        /** @var \App\Models\Building $building */
        $building = $this->buildingRepository->find($id);
        if (empty( $building )) {
            abort(404);
        }
        $this->buildingRepository->delete($building);

        return redirect()->action('Admin\BuildingController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
