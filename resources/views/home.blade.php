
<x-layout>

    <x-slot:btn>
        <div class="col-8 ps-3 align-content-center ">
             <b class="nameUser">Bem vindo, {{$AuthUser->name}}</b>
        </div>
        <div class="col-4 justify-content-end d-flex" >
            <a href="{{route('task.create')}}" class="btn btn-primary">
                Criar Tarefa
            </a>
            <a href="{{route('logout')}}" class="btn btn-primary">
                Sair
            </a>
        </div>
    </x-slot:btn>


    <section class="graph">
        <div class="graph_header">
            <h2> Progresso Do Dia </h2>
            <div class="graph_header-line">

            </div>
            <div class="graph_header-date">
                <a href="{{route('home', array_merge(\Request::query(),['date' => $date_prev_button]))}}">
                    <img src="assets/images/icon-prev.png">
                </a>
                    <form method="GET" action="{{ route('home') }}">
                        @foreach(request()->query() as $key => $value)
                            @if($key !== 'date')
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <input name="date" type="date" value="{{ $filtered_date }}" onchange="this.form.submit()" />
                    </form>

                <a href="{{route('home', array_merge(\Request::query(),['date' => $date_next_button]))}}">
                    <img src="assets/images/icon-next.png">
                </a>
            </div>
        </div>
        <div class="graph_header-subtitle">
            Tarefas: <b>{{$done_tasks_count}}/{{$tasks_count}}</b>
        </div>
        <div class="graph-placeholder">
            <canvas id="myChart"  width="400px" height="400px"></canvas>
        </div>

        <div class="tasks_left_footer">
            <img src="assets/images/icon-info.png">
            Restam {{$undone_tasks_count}} tarefas para serem realizadas
        </div>
    </section>
    <section class="list">
        <div class="list_header">
            <select class="list_header-select" onChange="changeTaskStatusFilter(this)">
                <option value="all_tasks" {{ request('filter') === 'all_tasks' ? 'selected' : '' }}>Todas as tarefas</option>
                <option value="task_pending" {{ request('filter') === 'task_pending' ? 'selected' : '' }}>Tarefas Pendentes</option>
                <option value="task_done" {{ request('filter') === 'task_done' ? 'selected' : '' }}>Tarefas Realizadas</option>
            </select>
        </div>
        <div class="list_task">
            @foreach ($tasks as $task)
                <x-task :data=$task/>
            @endforeach
            <div class="mt-3">
                {{$tasks->links()}}
            </div>
        </div>

    </section>


    <div class="modal fade" id="viewTaskModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTaskModalLabel">Detalhes da Tarefa</h5>
                </div>

                <form method="GET" action="">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" />

                        <div class="inputArea">
                            <label>Titulo da Task</label>
                            <span type="text" id="title" ></span>
                        </div>

                        <div class="inputArea">
                            <input type="checkbox"
                            id="is_done"
                            label="Tarefa Realizada?"
                            />
                        </div>

                        <div class="inputArea">
                            <label>Data de Realização</label>
                            <span type="date-time-local" id="due_date" name='due_date'></span>
                        </div>
                        <div class="inputArea">
                            <label>Descrição</label>
                            <span type="text" id="description" name='description'></span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        function changeTaskStatusFilter(select) {
            const filter = select.value;
            const url = new URL(window.location.href);
            url.searchParams.set('filter', filter);
            window.location.href = url.toString();
        }
    </script>

    <script>
        async function taskUpdate(element) {
           let status = element.checked
           let taskId = element.dataset.id
           let url = '{{route('task.update')}}'
           let rawResult = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-type': 'aplication/json',
                'accept': 'application/json'
            },
            body: JSON.stringify({status, taskId , _token: '{{ csrf_token()}}'})
           });

           result = await rawResult.json();
           if (result.success) {
            window.location.reload();
           } else {
            element.checked =! status;
           }
        }
    </script>

    @php
        $done = $chart_data->firstWhere('status', 'DONE')?->count ?? 0;
        $undone = $chart_data->firstWhere('status', 'UNDONE')?->count ?? 0;
    @endphp

    @push('scripts')
    <script>
    const data = {
        labels: [
            'Feitas',
            'A fazer',
        ],
        datasets: [{
            label: 'Status',
            data: [{{ $done }}, {{ $undone }}],
            backgroundColor: [
                '#6143FF',
                '#C1BCEC',
            ],
            hoverOffset: 4,
            borderColor:'#F6F5FF',

        }],
    };

    const centerTextPlugin = {
        id: 'centerText',
        beforeDraw(chart) {
            const {width} = chart;
            const {height} = chart;
            const ctx = chart.ctx;
            ctx.restore();

            const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
            const percentage = total === 0 ? '0%' : Math.round((chart.data.datasets[0].data[0] / total) * 100) + '% Completo';

            ctx.font = 'bold 25px Rubik';
            ctx.textBaseline = 'middle';
            ctx.textAlign = 'center';
            ctx.fillStyle = '#6143FF';
            ctx.fillText(percentage, width / 2, height / 2);
            ctx.save();
        }
    };

    const config = {
        type: 'doughnut',
        data: data,
        options: {
            cutout: '70%',
        },
        plugins: [centerTextPlugin],
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
    </script>
    @endpush

    <script>
        let titulo = document.getElementById('title');
        let descricao = document.getElementById('description');
        let feito = document.getElementById('is_done');
        let data_feito = document.getElementById('due_date');

        function atualizarModal(data) {
                titulo.innerHTML = data.title;
                descricao.innerHTML = data.description;
                data_feito.innerHTML = data.due_date;
                feito.checked = data.is_done ?  true : false;

        }

    </script>

</x-layout>
