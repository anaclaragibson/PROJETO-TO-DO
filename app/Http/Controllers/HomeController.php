<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
     public function index(Request $request) {
        $filteredDate = $request->date ?? date('Y-m-d');
        $filter = $request->filter ?? 'all_tasks';

        $data['AuthUser'] = Auth::user();

        $carbonDate = Carbon::createFromDate($filteredDate);
        $data['filtered_date'] = $filteredDate;
        $data['date_prev_button'] = $carbonDate->addDay(-1)->format('Y-m-d');
        $data['date_next_button'] = $carbonDate->addDay(2)->format('Y-m-d');

        $tasksData = Task::whereDate('due_date', $filteredDate)->where('user_id', Auth::id())->orderBy('is_done');

        if ($filter === 'task_pending') {
            $tasksData->where('is_done', false);
        } elseif ($filter === 'task_done') {
            $tasksData->where('is_done', true);
        }

        $countData = clone $tasksData;

        $data['tasks'] = $tasksData->paginate(5)->appends(['date' => $filteredDate, 'filter' => $filter]);

        $data['filter'] = $filter;

        $data['tasks_count'] = $countData->count();
        $data['undone_tasks_count'] = Task::whereDate('due_date', $filteredDate)->where('user_id', Auth::id())->where('is_done', false)->count();
        $data['done_tasks_count'] = Task::whereDate('due_date', $filteredDate)->where('user_id', Auth::id())->where('is_done', true)->count();

        $data['chart_data'] = Task::selectRaw("(CASE WHEN is_done = false THEN 'UNDONE'
        WHEN is_done = true THEN 'DONE'
        END) as status, COUNT(*) as count")
        ->whereDate('due_date', $filteredDate)
        ->where('user_id', Auth::id())
        ->groupBy('status')
        ->get();

        return view('home', $data);
    }

}
