@extends('layouts.app')

@section('content')

<div class="px-4 sm:px-6 lg:px-8 min-h-full overflow-x-auto w-full bg-cover">

        <div class="w-full text-center">
            <h1>Productos</h1>
        </div>
        <div class="px-4 py-2 mt-4">
            <button onclick="openModalCreateProduct()" class="px-3 py-1 rounded bg-blue-200 text-white hover:bg-gray-300 transition">Nuevo producto</button>
            @include('modals.product-form')
        </div>

        {{-- <div>
            <table class="border-collapse border border-gray-400 w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Codigo</th>
                        <th>Nombre el Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th onclick="sortTable('entry_date')">Fecha de Ingreso</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="product-tbody">
                </tbody>
            </table>
            <div class="pagination">
        
            </div>
        </div> --}}

    <table class="min-w-full divide-y divide-gray-200 border-collapse md:border-separate">
        <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Id</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Codigo</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Producto</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Cantidad</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Precio</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Fecha de ingreso</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Fecha Vencimiento</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Acciones</th>
        </tr>
        </thead>
        <tbody id="product-tbody" class="divide-y divide-gray-200"></tbody>
    </table>
    <div class="pagination"></div>
</div>


@endsection
@push('scripts')
    <script src="{{ asset('js/products.js') }}"></script>
@endpush