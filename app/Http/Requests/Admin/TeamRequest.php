<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\TeamRepositoryInterface;

class TeamRequest extends BaseRequest
{

    /** @var \App\Repositories\TeamRepositoryInterface */
    protected $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
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
        return $this->teamRepository->rules();
    }

    public function messages()
    {
        return $this->teamRepository->messages();
    }

}
