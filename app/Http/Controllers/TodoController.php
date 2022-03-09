<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexTodoRequest;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Subsystem\Status\Constants\StatusConst;

class TodoController extends ApiController
{
    public function __construct()
    {
        Todo::addGlobalScope(
            'user-data',
            function ($builder) {
                $builder->where('user_id', \Auth::user()->id);
            }
        );

    }
    /**
     * transformer
     *
     * @return string
     */
    public function transformer(): string
    {
        return \App\Http\Resources\Todo::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexTodoRequest $request)
    {
        if ($request->has('search')) {
            $search = $request->all()['search'];
            if (Arr::has($search, 'subject')) {
                Todo::addGlobalScope(
                    'filter-by-subject',
                    function ($builder) use ($search) {
                        $subject = Arr::get($search, 'subject', '');
                        return $builder->where('subject', 'like', "%$subject%");
                    }
                );
            }
            if (Arr::has($search, 'status')) {
                Todo::addGlobalScope(
                    'filter-by-status',
                    function ($builder) use ($search) {
                        $status_id = StatusConst::getId(Arr::get($search, 'status', ''));
                        return $builder->whereStatusId($status_id);
                    }
                );
            }
        }
        return $this->toResource(Todo::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTodoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTodoRequest $request)
    {
        $params = $request->validated();
        data_set($params, 'status_id', StatusConst::INCOMPLETE_STATUS_ID);
        data_set($params, 'user_id', \Auth::user()->id);
        $todo = Todo::create($params);
        return $this->toResource($todo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return $this->toResource($todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTodoRequest  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $todo->update($request->validated());
        return $this->toResource($todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json([], Response::HTTP_OK);
    }

    /**
     * complete
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function complete(Todo $todo)
    {
        $todo->complete();
        $todo->save();
        return $this->toResource($todo);
    }

    /**
     * complete
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function incomplete(Todo $todo)
    {
        $todo->incomplete();
        $todo->save();
        return $this->toResource($todo);
    }
}
