<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Foundation\Application;


class TaskController extends Controller
{
    //
    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        return view('tasks', [
            'tasks' => Task::query()->orderBy('created_at', 'asc')->get()
        ]);
    }

    /**
     * @param Request $request
     * @return Redirector|RedirectResponse|Application
     */
    public function store(Request $request): Redirector|RedirectResponse|Application
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $task = new Task;
        $task->name = $request->name;
        $task->save();

        return redirect('/');
    }

    /**
     * @param Task $task
     * @return Redirector|Application|RedirectResponse
     */
    public function destroy(Task $task): Redirector|Application|RedirectResponse
    {
        $task->delete();
        return redirect('/');
    }

}
