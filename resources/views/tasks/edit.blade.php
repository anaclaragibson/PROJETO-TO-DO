<x-layout page="Editar tarefa">

    <x-slot:btn>
        <a href="{{route('home')}}" class="btn btn-primary">
            Voltar
        </a>
    </x-slot:btn>
    <section id="task_section">

            <h1> Editar Tarefa </h1>
            <form method="POST" action="{{route('task.edit_action')}}">
                @csrf
                <input type="hidden" name="id" value="{{$task->id}}" />

                <x-form.text_input
                name="title"
                label="Título da Task"
                placeholder="Digite o título da tarefa"
                required='required'
                value='{{$task->title}}'
                />

                <x-form.checkbox_input
                name="is_done"
                label="Tarefa Realizada?"
                checked='{{$task->is_done}}'
                />


                <x-form.text_input
                name="due_date"
                type="datetime-local"
                label="Data de Realização"
                required='required'
                value='{{$task->due_date}}'
                />

                <x-form.select_input
                name='category_id'
                label="Categoria"
                >
                @foreach ($categories as $category)
                    <option value="{{$category->id}}"
                        @if ($category->id == $task ->category_id)
                            selected
                        @endif
                    >{{$category->name}}</option>
                @endforeach
                </x-form.select_input>

                <x-form.textarea_input
                    name="description"
                    label="Descrição da Tarefa"
                    placeholder="Digite a descrição da tarefa"
                    value='{{$task->description}}'
                >
                </x-form.textarea_input>

                <div class="inputArea">
                    <x-form.button type='reset'>Resetar</x-form.button>
                    <x-form.button type='submit'>Atualizar Tarefa</x-form.button>
                </div>
            </form>
    </section>
</x-layout>
