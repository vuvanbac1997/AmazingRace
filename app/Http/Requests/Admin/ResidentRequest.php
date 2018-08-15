<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\ResidentRepositoryInterface;

class ResidentRequest extends BaseRequest
{

    /** @var \App\Repositories\ResidentRepositoryInterface */
    protected $residentRepository;

    public function __construct(ResidentRepositoryInterface $residentRepository)
    {
        $this->residentRepository = $residentRepository;
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
        return $this->residentRepository->rules();
    }

    public function messages()
    {
        return $this->residentRepository->messages();
    }

}
