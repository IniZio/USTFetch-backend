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
        return response(array_merge(['success' => true, 'task' => Task::create(array_merge($request->input(), ['status' => 'PENDING']))]));
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
        $limit = 7;
        $page = 0;
        if ($request->query('page') > 0) {
            $page = $request->query('page');
        }
       return Task::where(function ($q) use ($request) {
            // Filter all relevant user's id (i.e. fetcher or requester)
            $relevant_id = $request->query('rfid');
            if ($relevant_id != null) {
                $q->where('requester_id', '=', $relevant_id)->orWhere('fetcher_id', '=', $relevant_id);
            } else {
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
            }

            $status = $request->query('status');
            if ($status != null) {
                $q->where('status', '=', $status);
            }
            $nstatus = $request->query('nstatus');
            if ($nstatus != null) {
                $q->where('status', '!=', $nstatus);
            }
            $keyword = $request->query('keyword');
            if ($keyword != null) {
                $q->where('objective', 'regex', '/.*'.$keyword.'.*/');
            }
        })->orderBy('updated_at', 'desc')->skip($page * $limit)->limit($limit)->get();
    }

    /**
     * Update tasks information
     *
     * @param Request $request
     * @param string $_id
     * @return void
     */
    public function update_task(Request $request, $_id) {
        $tasks = Task::find($_id);
        $tasks->update($request->input());

        return Task::find($_id);
    }
}
