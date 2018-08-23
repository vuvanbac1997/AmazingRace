<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\ChallengeRepositoryInterface;

class ChallengeRequest extends BaseRequest
{

    /** @var \App\Repositories\ChallengeRepositoryInterface */
    protected $challengeRepository;

    public function __construct(ChallengeRepositoryInterface $challengeRepository)
    {
        $this->challengeRepository = $challengeRepository;
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
        return $this->challengeRepository->rules();
    }

    public function messages()
    {
        return $this->challengeRepository->messages();
    }

}
