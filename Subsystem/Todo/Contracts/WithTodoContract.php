<?php

namespace Subsystem\Todo\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 *
 * WithTodoContract
 *
 * @category Contracts
 * @package  Subsystem\Todo
 * @author   Allen Jay Desamparado <allen.desamparado@monstar-lab.com>
 */
interface WithTodoContract
{

    /**
     * todos
     *
     * @return HasMany
     */
    public function todos(): HasMany;

    /**
     * getIncompleteTodos
     *
     * @return Collection
     */
    public function getIncompleteTodos(): Collection;

    /**
     * getCompletedTodos
     *
     * @return Collection
     */
    public function getCompletedTodos(): Collection;

}
