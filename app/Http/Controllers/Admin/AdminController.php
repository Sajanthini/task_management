<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->role->name == "Admin") {

            $users = User::count();
            $projects = Project::count();
            $tasks = Task::count();
            $completedTasks = Task::whereCompleted(true)->count();

            return view('admin.index', compact('users', 'projects', 'tasks', 'completedTasks'));
        } elseif (auth()->user()->role->name == "Employee") {

            $tasks = Task::where('assigned_to_user_id', auth()->id())->count();
            $completedTasks = Task::whereCompleted(true)->where('assigned_to_user_id', auth()->id())->count();

            return view('admin.index', compact('tasks', 'completedTasks'));
        }
    }
}
