<x-layout page="Registrar-se">

    <x-slot:btn>
        <a href="{{route('login')}}" class="btn btn-primary">
            Login
        </a>
    </x-slot:btn>
        <section id="task_section">

            <h1> Criar conta </h1>

             @if($errors->any())
                <ul class="alert alert-error">
                    @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{route('user.register_action')}}">
                @csrf

                <x-form.text_input
                name="name"
                label="Seu Nome"
                placeholder="Seu nome"
                required='required'
                />

                <x-form.text_input
                name="email"
                type="email"
                label="Seu Email"
                placeholder="Seu email"
                required='required'
                />

                <x-form.text_input
                name="password"
                type="password"
                label="Sua Senha"
                placeholder="Sua senha"
                required='required'
                />

                <x-form.text_input
                name="password_confirmation"
                type="password"
                label="Confirmar Senha "
                placeholder="Confirme sua senha"
                required='required'
                />

                <div class="inputArea">
                    <x-form.button type='reset'>Limpar</x-form.button>
                    <x-form.button type='submit'>Registrar-se</x-form.button>
                </div>
            </form>
    </section>
</x-layout>
