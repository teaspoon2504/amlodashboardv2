<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadFeedbackRequest;
use App\Http\Requests\LeadSetTargetRequest;
use App\Http\Requests\OfficerUpdateTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\BranchOffice;
use App\Models\Officer;
use App\Models\RegionalOffice;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\TeamLead;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(private readonly TaskService $taskService)
    {
    }

    // ========== OFFICER: View own tasks ==========
    public function myTasks()
    {
        $tasks = Task::with(['taskCategory', 'branchOffice'])
            ->where('officer_id', auth()->user()->officer_id)
            ->orderByDesc('id')
            ->get();

        return view('tasks.my', compact('tasks'));
    }

    // ========== LEAD: View team tasks ==========
    public function teamTasks()
    {
        $tasks = Task::with(['taskCategory', 'officer', 'branchOffice'])
            ->where('team_lead_id', auth()->user()->team_lead_id)
            ->orderByDesc('id')
            ->get();

        return view('tasks.team', compact('tasks'));
    }

    // ========== OFFICER: Update own task ==========
    public function officerUpdate(OfficerUpdateTaskRequest $request, Task $task)
    {
        $this->taskService->officerUpdate($task, $request->validated());

        return redirect()->route('dashboard.officer')->with('success', 'Task updated successfully');
    }

    // ========== LEAD: Give feedback & set targets ==========
    public function leadFeedback(LeadFeedbackRequest $request, Task $task)
    {
        $this->taskService->leadFeedback($task, $request->validated());

        return back()->with('success', 'Feedback submitted');
    }

    public function leadSetTarget(LeadSetTargetRequest $request, Task $task)
    {
        $this->taskService->leadSetTarget($task, $request->validated());

        return back()->with('success', 'Target updated');
    }

    // ========== HO: Full CRUD ==========
    public function index(Request $request)
    {
        $tasks = $this->taskService->getFilteredTasks($request);
        $regionalOffices = RegionalOffice::all();
        $taskCategories = TaskCategory::all();

        return view('tasks.index', compact('tasks', 'regionalOffices', 'taskCategories'));
    }

    public function create()
    {
        return view('tasks.create', $this->taskService->getFormData());
    }

    public function store(StoreTaskRequest $request)
    {
        Task::create($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task created');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', array_merge(
            ['task' => $task],
            $this->taskService->getFormData()
        ));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task updated');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted');
    }
}