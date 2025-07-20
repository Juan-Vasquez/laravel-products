<div id="productModal" class="fixed inset-0 flex items-center justify-center z-50 shadow-xl hidden">
{{-- <div id="productModal" class="fixed inset-0 min-h-full h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8 bg-cover"> --}}
    <div>
        <form id="saveProductForm" class="bg-white rounded-lg shadow-xl p-10 w-full max-w-md">
            <div>
                <h2 id="modalTitle" class="text-2xl text-center mb-4"></h2>
            </div>

            <div>
                <label for="code_product" class="block text-sm font-medium text-gray-700">Codigo de producto</label>
                <div class="mt-1">
                    <input id="code_product" type="text" name="code_product" required autocomplete="code_product" autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <p id="error-code_product" class="text-red-500 text-sm mt-1"></p>
                </div>
            </div>

            <div>
                <label for="name_product" class="block text-sm font-medium text-gray-700">Nombre de producto</label>
                <div class="mt-1">
                    <input id="name_product" type="text" name="name_product" required autocomplete="name_product" autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <p id="error-name_product" class="text-red-500 text-sm mt-1"></p>
                </div>
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">cantidad</label>
                <div class="mt-1">
                    <input id="quantity" type="number" name="quantity" required autocomplete="quantity" autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <p id="error-quantity" class="text-red-500 text-sm mt-1"></p>
                </div>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Precio</label>
                <div class="mt-1">
                    <input id="price" type="number" name="price" required autocomplete="price" autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <p id="error-price" class="text-red-500 text-sm mt-1"></p>
                </div>
            </div>

            <div>
                <label for="currency" class="block text-sm font-medium text-gray-700">Moneda</label>
                <select name="currency" id="currency" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900" value="GTQ">GTQ</option>
                    <option class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900" value="USD">USD</option>
                </select>
                <p id="error-currency" class="text-red-500 text-sm mt-1"></p>
            </div>

            <div>
                <label for="entry_date" class="block text-sm font-medium text-gray-700">Fecha de ingreso</label>
                <div class="mt-1">
                    <input id="entry_date" type="date" name="entry_date" required autocomplete="entry_date" autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <p id="error-entry_date" class="text-red-500 text-sm mt-1"></p>
                </div>
            </div>

            <div>
                <label for="expiration_date" class="block text-sm font-medium text-gray-700">Fecha de Vencimiento</label>
                <div class="mt-1">
                    <input id="expiration_date" type="date" name="expiration_date" required autocomplete="expiration_date" autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <p id="error-expiration_date" class="text-red-500 text-sm mt-1"></p>
                </div>
            </div>

            <div>
                <label for="photo_product" class="block text-sm font-medium text-gray-700">Subir una imagen</label>
                <div class="mt-1">
                    <input id="photo_product" type="file" name="photo_product" autocomplete="photo_product" autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <p id="error-photo_product" class="text-red-500 text-sm mt-1"></p>
                </div>
            </div>

            <div>
                <div class="mt-1">
                    <img id="productImagePreview" class="w-32 h-auto mb-3 hidden" alt="Vista previa" \>
                </div>
            </div>

            <div>
                <button id="saveProductBtn" type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"></button>
                <button type="button" onclick="closeModal()" class="w-full flex justify-center py-2 my-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-300 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Cancelar</button>
            </div>

        </form>
    </div>
</div>

<div id="confirmDeleteModal" class="fixed inset-0 bg-opacity-20 flex items-center justify-center z-50 hidden">
    <div>
        <div class="bg-white rounded-lg shadow-xl p-10 w-full max-w-md">
            <h2 class="text-2xl text-center mb-4">¿Estás seguro de que deseas eliminar este producto?</h2>
            <div id="deleteStatus" class="text-center text-sm text-gray-600 mb-3 hidden"></div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModalDelete()" class="w-full flex justify-center py-2 my-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-300 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Cancelar</button>
                <button id="confirmDeleteBtn" type="button" class="w-full flex justify-center py-2 my-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-200 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <span id="deleteBtnText">Eliminar</span>
                    <span id="deleteSpinner" class="hidden animate-spin ml-2 border-2 border-t-transparent border-white rounded-full w-4 h-4"></span>
                </button>
            </div>
        </div>
    </div>
</div>