<?php namespace App\Http\Controllers\API\V1;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Responses\API\V1\Response;
use App\Models\File;
use App\Repositories\TeamRepositoryInterface;
use App\Http\Requests\Admin\TeamRequest;
use App\Http\Requests\PaginationRequest;
use App\Services\FileUploadServiceInterface;
use App\Repositories\ImageRepositoryInterface;
use phpDocumentor\Reflection\Types\This;

class TeamController extends Controller
{

    /** @var \App\Repositories\TeamRepositoryInterface */
    protected $teamRepository;

    protected $fileUploadService;

    protected $imageRepository;

    public function __construct(
        TeamRepositoryInterface $teamRepository,
        FileUploadServiceInterface $fileUploadService,
        ImageRepositoryInterface $imageRepository
    )
    {
        $this->teamRepository = $teamRepository;
        $this->fileUploadService = $fileUploadService;
        $this->imageRepository = $imageRepository;
    }

    public function lists(){
    }

    public function detail($id){
        $team = $this->teamRepository->find($id);
        if (empty($team)){
            return Response::response(20004);
        }
        return Response::response(200, $team->toAPIArray());
    }
}