<?php

namespace Subsystem\Todo\Traits;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Subsystem\Status\Constants\StatusConst;

/**
 *
 * HasTodoTrait
 *
 * @category Traits
 * @package  Subsystem\Todo
 * @author   Allen Jay Desamparado <allen.desamparado@monstar-lab.com>
 */
trait HasTodoTrait
{

    /**
     * todos
     *
     * @return HasMany
     */
    abstract public function todos(): HasMany;


    /**
     * getIncompleteTodos
     *
     * @return Collection
     */
    public function getIncompleteTodos(): Collection
    {
        return $this->todos()->whereStatusId(StatusConst::INCOMPLETE_STATUS_ID);
    }

    /**
     * getCompletedTodos
     *
     * @return Collection
     */
    public function getCompletedTodos(): Collection
    {
        return $this->todos()->whereStatusId(StatusConst::COMPLETED_STATUS_ID);
    }
}
