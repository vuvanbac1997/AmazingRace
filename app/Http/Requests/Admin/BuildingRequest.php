<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\BuildingRepositoryInterface;

class BuildingRequest extends BaseRequest
{

    /** @var \App\Repositories\BuildingRepositoryInterface */
    protected $buildingRepository;

    public function __construct(BuildingRepositoryInterface $buildingRepository)
    {
        $this->buildingRepository = $buildingRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->buildingRepository->rules();
    }

    public function messages()
    {
        return $this->buildingRepository->messages();
    }

}
