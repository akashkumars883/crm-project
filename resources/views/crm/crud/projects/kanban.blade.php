<style>
    .kanban-board { display: flex; gap: 1rem; overflow-x: auto; padding-bottom: 1rem; }
    .kanban-column { flex: 1; min-width: 300px; background: #f8f9fa; border-radius: 8px; padding: 1rem; }
    .kanban-column-header { font-weight: bold; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #dee2e6; }
    .kanban-task { background: #fff; padding: 1rem; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 1rem; cursor: grab; transition: transform 0.2s; border-left: 4px solid #007bff; }
    .kanban-task:active { cursor: grabbing; transform: scale(0.98); }
    .kanban-task.status-in-progress { border-left-color: #ffc107; }
    .kanban-task.status-done { border-left-color: #28a745; }
    .task-ghost { opacity: 0.4; }
</style>

<div class="container-fluid border border-bottom border-5 mb-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Project Tasks (Kanban)</h5>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#taskModal">Add Task</button>
                        </div>
                    </div>

                    <div class="kanban-board">
                        <!-- To Do Column -->
                        <div class="kanban-column" id="kanban-todo" data-status="To Do">
                            <div class="kanban-column-header text-primary"><i class="ti ti-list"></i> To Do</div>
                            <div class="kanban-tasks-container" style="min-height: 200px;">
                                @foreach($projectTasks->where('status', 'To Do') as $task)
                                    <div class="kanban-task" data-id="{{ $task->id }}">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $task->title }}</strong>
                                            <form action="{{ route('project-tasks.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete task?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </div>
                                        <p class="text-muted small mb-2">{{ Str::limit($task->description, 50) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-light text-dark"><i class="ti ti-user"></i> {{ $task->assignee->name ?? 'Unassigned' }}</span>
                                            @if($task->due_date)
                                                <small class="text-muted"><i class="ti ti-calendar"></i> {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- In Progress Column -->
                        <div class="kanban-column" id="kanban-inprogress" data-status="In Progress">
                            <div class="kanban-column-header text-warning"><i class="ti ti-loader"></i> In Progress</div>
                            <div class="kanban-tasks-container" style="min-height: 200px;">
                                @foreach($projectTasks->where('status', 'In Progress') as $task)
                                    <div class="kanban-task status-in-progress" data-id="{{ $task->id }}">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $task->title }}</strong>
                                            <form action="{{ route('project-tasks.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete task?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </div>
                                        <p class="text-muted small mb-2">{{ Str::limit($task->description, 50) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-light text-dark"><i class="ti ti-user"></i> {{ $task->assignee->name ?? 'Unassigned' }}</span>
                                            @if($task->due_date)
                                                <small class="text-muted"><i class="ti ti-calendar"></i> {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Done Column -->
                        <div class="kanban-column" id="kanban-done" data-status="Done">
                            <div class="kanban-column-header text-success"><i class="ti ti-check"></i> Done</div>
                            <div class="kanban-tasks-container" style="min-height: 200px;">
                                @foreach($projectTasks->where('status', 'Done') as $task)
                                    <div class="kanban-task status-done" data-id="{{ $task->id }}">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $task->title }}</strong>
                                            <form action="{{ route('project-tasks.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete task?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </div>
                                        <p class="text-muted small mb-2">{{ Str::limit($task->description, 50) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-light text-dark"><i class="ti ti-user"></i> {{ $task->assignee->name ?? 'Unassigned' }}</span>
                                            @if($task->due_date)
                                                <small class="text-muted"><i class="ti ti-calendar"></i> {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Task Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('project-tasks.store') }}" method="POST">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="To Do">To Do</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Due Date</label>
                            <input type="date" name="due_date" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Assign To</label>
                        <select name="assignee_id" class="form-select">
                            <option value="">Unassigned</option>
                            @foreach($assignees as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include SortableJS for Drag and Drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const containers = document.querySelectorAll('.kanban-tasks-container');
        containers.forEach(container => {
            new Sortable(container, {
                group: 'kanban', // set both lists to same group
                animation: 150,
                ghostClass: 'task-ghost',
                onEnd: function (evt) {
                    const itemEl = evt.item;  // dragged HTMLElement
                    const toColumn = evt.to.closest('.kanban-column');
                    const newStatus = toColumn.getAttribute('data-status');
                    const taskId = itemEl.getAttribute('data-id');

                    // Update visual classes based on status
                    itemEl.classList.remove('status-in-progress', 'status-done');
                    if(newStatus === 'In Progress') itemEl.classList.add('status-in-progress');
                    if(newStatus === 'Done') itemEl.classList.add('status-done');

                    // Make AJAX call to update status in backend
                    fetch(`/project-tasks/${taskId}/update-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ status: newStatus })
                    }).then(response => response.json())
                    .then(data => {
                        if(!data.success) {
                            console.error('Failed to update task status');
                        }
                    });
                },
            });
        });
    });
</script>
