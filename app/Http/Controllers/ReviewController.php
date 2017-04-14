<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;

class ReviewController extends Controller
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
     * Create review
     *
     * @param Request $request
     * @return void
     */
    public function create_review(Request $request) {
        // TODO: validate request
        return Review::create($request->input());
    }

    /**
     * Retrieve review by id
     *
     * @param Request $request
     * @param string $_id
     * @return void
     */
    public function get_review_by_id(Request $request, $_id) {
        if (!empty($_id)) {
            return Review::find($_id);
        }
        return null;
    }

    /**
     * Retrieve reviews by filter
     *
     * @param Request $request
     * @return void
     */
    public function get_reviews(Request $request) {
        return Review::where(function ($q) use ($request) {
            // Filter by reviewer's id
            $reviewer_id = $request->query('rrid');
            if ($reviewer_id != null) {
                $q->where('reviewer_id', '=', $reviewer_id);
            }
            // Filter by reviewee's id
            $reviewee_id = $request->query('reid');
            if ($reviewee_id != null) {
                $q->where('reviewee_id', '=', $reviewee_id);
            }
            // Filter by task's id
            $task_id = $request->query('tid');
            if ($task_id != null) {
                $q->where('task_id', '=', $task_id);
            }
        })->get();
    }
}
