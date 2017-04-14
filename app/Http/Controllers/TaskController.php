<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    
    /**
     *  Create a new task
     *  @param 
     */
    public function create_task(Request $request) {
        // TODO: validate request
        return Task::create($request->input());
    }

    /**
     * Retrieve task by id
     * @param string $_id
     */
    public function get_task_by_id(Request $request, $_id) {
        // Get task by id (only one record)
        if (!empty($_id)) {
            return Task::find($_id);
        }
        return null;
    }

    /**
     * Retrieve tasks by filter
     *
     * @param Request $request
     * @return void
     */
    public function get_tasks(Request $request) {
        return Task::where(function ($q) use ($request) {
            // Filter by requester's id
            $requester_id = $request->query('rid');
            if ($requester_id != null) {
                $q->where('requester_id', '=', $requester_id);
            }
            // Filter by fetcher's id
            $fetcher_id = $request->query('fid');
            if ($fetcher_id != null) {
                $q->where('fetcher_id', '=', $fetcher_id);
            }
            // TODO: add limit
        })->get();
    }

    /**
     * Update tasks information
     *
     * @param Request $request
     * @param string $_id
     * @return void
     */
    public function update_tasks(Request $request, $_id) {
        $tasks = Task::find($_id);
        $tasks->fill($request->input());
        $tasks->save();

        return Task::find($_id);
    }
}
