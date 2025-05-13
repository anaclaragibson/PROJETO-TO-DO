<x-layout page="Criar tarefa">

    <x-slot:btn>
        <a href="{{route('home')}}" class="btn btn-primary">
            Voltar
        </a>
    </x-slot:btn>


    <section id="task_section">

            <h1> Criar Tarefa </h1>
            <form method="POST" action="{{route('task.create_action')}}">
                @csrf

                <x-form.text_input
                name="title"
                label="Título da Task"
                placeholder="Digite o título da tarefa"
                required='required'
                />

                <x-form.text_input
                name="due_date"
                type="datetime-local"
                label="Data de Realização"
                placeholder="Escolha a da tarefa"
                required='required'
                />

                <x-form.select_input
                name='category_id'
                label="Categoria"
                required='required'
                >
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
                </x-form.select_input>

                <x-form.textarea_input
                name="description"
                label="Descrição da Tarefa"
                placeholder="Digite a descrição da tarefa"
                required='required'
                >
                </x-form.textarea_input>

                <div class="inputArea">
                    <x-form.button type='reset'>Resetar</x-form.button>
                    <x-form.button type='submit'>Criar Tarefa</x-form.button>
                </div>
            </form>
    </section>
</x-layout>
