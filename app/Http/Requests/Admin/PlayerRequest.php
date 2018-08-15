<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\PlayerRepositoryInterface;

class PlayerRequest extends BaseRequest
{

    /** @var \App\Repositories\PlayerRepositoryInterface */
    protected $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
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
        return $this->playerRepository->rules();
    }

    public function messages()
    {
        return $this->playerRepository->messages();
    }

}
