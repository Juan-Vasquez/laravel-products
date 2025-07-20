@extends('layouts.app')

@section('content')

    <div>
        <h1>Productos</h1>
    </div>
    <div>
        <table>
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
    </div>

@endsection
@push('scripts')
    <script src="{{ asset('js/products.js') }}"></script>
@endpush