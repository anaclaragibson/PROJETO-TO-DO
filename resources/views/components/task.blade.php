<div class="task {{$data['is_done'] ? 'task_done' : 'task_pending'}} "
        onclick="atualizarModal({!!$data!!})" data-bs-toggle = "modal" data-bs-target="#viewTaskModal">
        <div class="title">
            <input type="checkbox" onchange="taskUpdate(this)" data-id="{{$data['id']}}"
                @if($data && $data['is_done'])
                    checked
                @endif
            />
            <div class="task_title">
                {{$data['title'] ?? ''}}
            </div>
        </div>

        <div class="priority">
            <div class="sphere"></div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="{{$data['category']->color ?? '#00000'}}" viewBox="0 0 256 256"><path d="M232,128A104,104,0,1,1,128,24,104.13,104.13,0,0,1,232,128Z"></path></svg>
                {{$data['category']->name ?? ''}}
            </div>
        </div>
        <div class="actions">
            <a href="{{route('task.edit', ['id' => $data['id']])}}">
                <img src="assets/images/icon-edit.png">
            </a>
            <a href="{{route('task.delete', ['id' => $data['id']])}}">
                <img src="assets/images/icon-delete.png">
            </a>
        </div>
</div>
