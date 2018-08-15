<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\ResidentRepositoryInterface;
use App\Http\Requests\Admin\ResidentRequest;
use App\Http\Requests\PaginationRequest;
use  App\Repositories\BuildingRepositoryInterface;
use App\Services\FileUploadServiceInterface;

class ResidentController extends Controller
{
    /** @var \App\Repositories\ResidentRepositoryInterface */
    protected $residentRepository;

    /** @var \App\Repositories\BuildingRepositoryInterface */
    protected $buildingRepository;

    /** @var \App\Services\FileUploadServiceInterface */
    protected $fileUploadService;

    public function __construct(
        ResidentRepositoryInterface $residentRepository,
        BuildingRepositoryInterface $buildingRepository,
        FileUploadServiceInterface  $fileUploadService
    )
    {
        $this->residentRepository   = $residentRepository;
        $this->buildingRepository   = $buildingRepository;
        $this->fileUploadService    = $fileUploadService;
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
        $paginate['baseUrl']    = action( 'Admin\ResidentController@index' );

        $count = $this->residentRepository->count();
        $residents = $this->residentRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.residents.index',
            [
                'residents' => $residents,
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
            'pages.admin.' . config('view.admin') . '.residents.edit',
            [
                'isNew'     => true,
                'resident'  => $this->residentRepository->getBlankModel(),
                'buildings' => $this->buildingRepository->all()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(ResidentRequest $request)
    {
        $input = $request->only(['code','name','telephone','email','address','device_code','television_code','electric_code','water_code','internet_code']);
        
        $input['building_id'] = $request->get('building_id', 0);

        $resident = $this->residentRepository->create($input);

        if (empty( $resident )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');

            $image = $this->fileUploadService->upload(
                'resident_cover_image',
                $file,
                [
                    'entity_type' => 'resident_cover_image',
                    'entity_id'   => $resident->id,
                    'title'       => $request->input('name', ''),
                ]
            );

            if (!empty($image)) {
                $this->buildingRepository->update($resident, ['cover_image_id' => $image->id]);
            }
        }

        return redirect()->action('Admin\ResidentController@index')
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
        $resident = $this->residentRepository->find($id);
        if (empty( $resident )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.residents.edit',
            [
                'isNew'     => false,
                'resident'  => $resident,
                'buildings' => $this->buildingRepository->all()
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
    public function update($id, ResidentRequest $request)
    {
        /** @var \App\Models\Resident $resident */
        $resident = $this->residentRepository->find($id);
        if (empty( $resident )) {
            abort(404);
        }
        $input = $request->only(['code','name','telephone','email','address','device_code','television_code','electric_code','water_code','internet_code']);
        
        $input['building_id'] = $request->get('building_id', 0);

        if ($request->hasFile('cover_image')) {
            $currentImage = $resident->coverImage;
            $file = $request->file('cover_image');

            $newImage = $this->fileUploadService->upload(
                'resident_cover_image',
                $file,
                [
                    'entity_type' => 'resident_cover_image',
                    'entity_id'   => $resident->id,
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

        $this->residentRepository->update($resident, $input);

        return redirect()->action('Admin\ResidentController@show', [$id])
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
        /** @var \App\Models\Resident $resident */
        $resident = $this->residentRepository->find($id);
        if (empty( $resident )) {
            abort(404);
        }
        $this->residentRepository->delete($resident);

        return redirect()->action('Admin\ResidentController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
