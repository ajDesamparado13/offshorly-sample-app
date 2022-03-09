<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Resources\Json\JsonResource;
use Subsystem\Status\Contracts\WithStatusContract;
use Subsystem\Status\Traits\HasStatusTrait;

/**
 * Todo
 *
 * @category Models
 * @package  App
 * @author  Allen Jay Desamparado <allen.desamparado@monstar-lab.com>
 */
class Todo extends Model implements WithStatusContract
{
    use HasFactory;
    use HasStatusTrait;

    protected $fillable = [
        'user_id',
        'subject',
        'status_id',
        'body',
    ];

    protected $appends = [
        'is_completed'
    ];

    /**
     * getStatusId
     *
     * @return int
     */
    public function getStatusId(): int
    {
        return $this->status_id;
    }

    /**
     * setStatusId
     *
     * @param  int $id
     * @return self
     */
    public function setStatusId(int $id)
    {
        $this->status_id = $id;
        return $this;
    }

    /**
     * user
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * toResource
     *
     * @return JsonResource
     */
    public function toResource()
    {
        return new \App\Http\Resources\Todo($this);
    }
}
