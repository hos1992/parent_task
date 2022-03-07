<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ProviderRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class ProvidersController extends Controller
{

    public function __invoke(Request $request, ProviderRepositoryInterface $repo)
    {
        try {
            // get the providers
            $providers = $repo->list($request->only([
                'provider', 'statusCode', 'balanceMin', 'balanceMax', 'currency',
            ]));

            // return success response
            return $this->successResponse($providers);

        } catch (Exception $e) {
            // Errors response
            return $this->errorResponse($e->getMessage());
        }
    }

}
