@extends('layouts.app')

@section('content')
<div class="min-h-full h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8 bg-cover">
    
    <div class="mt-2 w-full sm:mx-auto sm:max-w-[420px] z-10">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-gray-200">
            <div class="w-full text-center">
                <h2>Iniciar Sesión</h2>
            </div>
            
            <form class="space-y-6 py-8" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Correo electronico -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electronico</label>
                    <div class="mt-1">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <div class="mt-1">
                        <input id="password" type="password" name="password" value="{{ old('password') }}" required autocomplete="password" autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Ingresar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection