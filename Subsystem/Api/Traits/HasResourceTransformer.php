<?php

namespace Subsystem\Api\Traits;

use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * HasResourceTransformer
 *
 * @category Traits
 * @package  Subsystem\Api
 * @author   Allen Jay Desamparado <allen.desamparado@monstar-lab.com>
 */
trait HasResourceTransformer
{

    /**
     * The Transformer instance
     *
     * @var JsonResource|null
     */
    protected $transformer;

    /**
     * makeTransformer
     *
     * @return JsonResource
     */
    public function makeTransformer(): JsonResource
    {
        $transformer = $this->transformer();

        if (is_string($transformer)) {
            $transformer = app()->make($transformer,['resource' => []]);
        }

        if (!($transformer instanceof JsonResource)) {
            throw new Exception("Class " . get_class($transformer) . " must be an instance of " . JsonResource::class);
        }

        return $this->transformer = $transformer;
    }

    /**
     * hasTransformer
     *
     * @return bool
     */
    protected function hasTransformer(): bool
    {
        return !empty($this->transformer) && $this->transformer instanceof JsonResource;
    }

    /**
     * getTransformer
     *
     * @return JsonResource
     */
    protected function getTransformer(): JsonResource
    {
        return $this->hasTransformer() ? $this->transformer : $this->makeTransformer();
    }

    /**
     * transformer
     *
     * @return string
     */
    abstract public function transformer(): string;
}
