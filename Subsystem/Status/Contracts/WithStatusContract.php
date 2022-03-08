<?php

namespace Subsystem\Status\Contracts;

/**
 * WithStatusContract
 *
 * @category Contracts
 * @package  Subsystem\Status
 * @author   Allen Jay Desamparado <allen.desamparado@monstar-lab.com>
 */
interface WithStatusContract
{
    /**
     * getStatusId
     *
     * @return int
     */
    public function getStatusId(): int;

    /**
     * setStatusId
     *
     * @param  int $id
     *
     * @return self
     */
    public function setStatusId(int $id);

    /**
     * getStatusText
     *
     * @return string
     */
    public function getStatusText(): string;

    /**
     * complete
     *
     * @return void
     */
    public function complete();

    /**
     * incomplete
     *
     * @return void
     */
    public function incomplete();

    /**
     * hasCompleted
     *
     * @return bool
     */
    public function hasCompleted(): bool;
}
