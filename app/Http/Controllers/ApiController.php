<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Subsystem\Api\Traits\HasResourceTransformer;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Response;

abstract class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, HasResourceTransformer;

    /**
     * toResource
     *
     * @param  mixed $data
     * @param  mixed $resourceTransformer
     * @param  mixed $response
     * @return JsonResource
     */
    protected function toResource($data)
    {
        $is_resourceable = is_a($data, 'Illuminate\Pagination\LengthAwarePaginator') || is_a($data, 'Illuminate\Database\Eloquent\Collection');

        return call_user_func_array(array($this->getTransformer(), $is_resourceable ? 'collection' : 'make'), [$data]);
    }
}
