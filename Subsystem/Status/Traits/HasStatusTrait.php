<?php

namespace Subsystem\Status\Traits;

use Carbon\Carbon;
use Subsystem\Status\Constants\StatusConst;
use Subsystem\Status\Contracts\WithStatusContract;

/**
 * HasStatusTrait
 *
 * @category Traits
 * @package  Subsystem\Status
 * @author   Allen Jay Desamparado <allen.desamparado@monstar-lab.com>
 */
trait HasStatusTrait
{
    /**
     * initializeHasJobStatus
     *
     * @return void
     */
    public function initializeHasJobStatus()
    {
        $this->guarded[] = 'status_id';
        $this->guarded[] = 'completed_at';
    }

    /**
     * bootHasEmailTrait
     *
     * @return void
     */
    public static function bootHasStatusTrait()
    {
        static::creating(
            function (WithStatusContract $model) {
            }
        );
        static::saving(
            function (WithStatusContract $model) {
                if ($model->hasCompleted()) {
                    $model->complete();
                }
            }
        );
    }
    /**
     * getStatusId
     *
     * @return int
     */
    abstract public function getStatusId(): int;

    /**
     * setStatusId
     *
     * @return void
     */
    abstract public function setStatusId(int $id);


    /**
     * getStatusText
     *
     * @return string
     */
    public function getStatusText(): string
    {
        return StatusConst::getText($this->getStatusId());
    }

    /**
     * complete
     *
     * @return void
     */
    public function complete()
    {
        $this->setStatusId(StatusConst::COMPLETED_STATUS_ID);
        $this->completed_at = Carbon::now();
    }

    /**
     * incomplete
     *
     * @return void
     */
    public function incomplete()
    {
        $this->setStatusId(StatusConst::INCOMPLETE_STATUS_ID);
        $this->completed_at = null;
    }

    /**
     * hasCompleted
     *
     * @return bool
     */
    public function hasCompleted(): bool
    {
        return $this->getStatusId() == StatusConst::COMPLETED_STATUS_ID;
    }

    /**
     * getIsCompletedAttribute
     *
     * @return bool
     */
    public function getIsCompletedAttribute() : bool
    {
        return $this->hasCompleted();
    }
}
