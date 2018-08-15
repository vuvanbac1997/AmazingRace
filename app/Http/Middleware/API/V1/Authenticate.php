<?php
namespace App\Http\Middleware\API\V1;

use App\Exceptions\APIErrorException;
use App\Http\Responses\API\V1\Response;
use App\Services\APIUserServiceInterface;
use Closure;
use Illuminate\Http\Request;

class Authenticate
{
    /** @var APIUserServiceInterface */
    protected $userService;

    /**
     * Create a new filter instance.
     *
     * @param APIUserServiceInterface $userService
     */
    public function __construct(APIUserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty($this->userService->isSignedIn())) {
            return Response::response(40101);
        }

        return $next($request);
    }
}
