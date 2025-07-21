let tBody = document.getElementById('product-tbody');
let tPagination = document.querySelector('.pagination');
let tSort = document.querySelector('.sort');
let currentPage = 1;
let totalPages = 0;
let totalItems = 0;

// Variables para modales
let createModal = document.getElementById('createModal');
let isModalEdit = false;
let productToDelete = null;
let productEditId = null;

let currentSortField = '-entry_date';
let currentSortDirection = 'desc';

async function getProducts(page) {

    const getProducts = await fetch(`/api/v1/getProducts`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            page_limit: 15,
            page: page,
            sort: currentSortField
        })
    });
    const response = await getProducts.json();

    if( response.data.length === 0 ) {

        tPagination.innerHTML = `<p class="py-8 text-center text-gray-700 text-sm">No hay productos disponibles.</p>`;
        return;

    }

    loadTable(response.data);
    loadPagination(response.pagination);

}

function loadTable(products){

    tBody.innerHTML = ''

    products.forEach(product => {

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product.id}</td>
            <td>${product.code_product}</td>
            <td>${product.name_product}</td>
            <td>${product.quantity}</td>
            <td>${product.currency}${product.price}</td>
            <td>${product.entry_date}</td>
            <td>${product.expiration_date}</td>
            <td><img src="${product.photo_product}" alt="Imagen del producto" class="w-16 h-16 object-cover rounded"/></td>
            <td>
                <div class="flex items-center justify-center space-x-2">
                    <button onclick="openModalEditProduct(${product.id})" class="px-3 py-1 rounded bg-green-200 text-gray-700 hover:bg-gray-300 transition">
                        Editar
                    </button>
                    <button onclick="openModalDeleteProduct(${product.id})" class="px-3 py-1 rounded bg-red-200 text-gray-700 hover:bg-gray-300 transition">
                        Eliminar
                    </button>
                </div>
            </td>
        `;

        tBody.appendChild(row);

    });

}

function loadPagination(pagination){

    const { total_items, total_pages } = pagination;
    tPagination.innerHTML = '';

    totalPages = total_pages;
    totalItems = total_items;

    if (currentPage === 1 && totalPages > 1) {
        tPagination.innerHTML = `
            <div class="flex items-center justify-center space-x-2 mt-4">
                <span class="px-4 py-1 text-sm text-gray-700 font-medium">
                    Página ${currentPage} de ${totalPages}
                </span>
                <button 
                    onclick="nextPage()" 
                    aria-label="Siguiente"
                    class="px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 transition"
                >
                    &raquo;
                </button>
            </div>
        `;
    } else if (currentPage === totalPages && totalPages > 1) {
        tPagination.innerHTML = `
            <div class="flex items-center justify-center space-x-2 mt-4">
                <button 
                    onclick="previosPage()" 
                    aria-label="Anterior"
                    class="px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 transition"
                >
                    &laquo;
                </button>
                <span class="px-4 py-1 text-sm text-gray-700 font-medium">
                    Página ${currentPage} de ${totalPages}
                </span>
            </div>
        `;
    } else if (currentPage === 1 && totalPages === 1) {
        tPagination.innerHTML = `
            <div class="flex items-center justify-center mt-4">
                <span class="px-4 py-1 text-sm text-gray-700 font-medium">
                    Página ${currentPage} de ${totalPages}
                </span>
            </div>
        `;
    } else {
        tPagination.innerHTML = `
            <div class="flex items-center justify-center space-x-2 mt-4">
                <button 
                    onclick="previosPage()" 
                    aria-label="Anterior"
                    class="px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 transition"
                >
                    &laquo;
                </button>
                <span class="px-4 py-1 text-sm text-gray-700 font-medium">
                    Página ${currentPage} de ${totalPages}
                </span>
                <button 
                    onclick="nextPage()" 
                    aria-label="Siguiente"
                    class="px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 transition"
                >
                    &raquo;
                </button>
            </div>
        `;
    }


}

function previosPage(){

    if( currentPage > 1){

        currentPage--;
        getProducts(currentPage);

    }


}

function nextPage(){

    if( currentPage < totalPages ){

        currentPage++;
        getProducts(currentPage);

    }

}

function sortTable(field){

    if( currentSortDirection === 'asc' ){

        currentSortField = '-'+field;
        currentSortDirection = 'desc';

    }else{

        currentSortField = field;
        currentSortDirection = 'asc';

    }

    currentPage = 1;

    getProducts(currentPage);

}

function openModalCreateProduct(){

    cleanErrors();

    isModalEdit = false;
    document.getElementById('modalTitle').textContent = 'Crear Producto';
    document.getElementById('saveProductBtn').textContent = 'Guardar';
    document.getElementById('saveProductForm').reset();

    const preview = document.getElementById('productImagePreview');
    if (preview) {
        preview.src = '';
        preview.classList.add('hidden');
    }

    document.getElementById('productModal').classList.remove('hidden');

}

async function openModalEditProduct(idProduct){

    cleanErrors();
    isModalEdit = true;
    productEditId = idProduct;
    document.getElementById('modalTitle').textContent = 'Actualizar Producto';
    document.getElementById('saveProductBtn').textContent = 'Actualizar';
    document.getElementById('saveProductForm').reset();

    const response = await fetch(`/api/v1/products/${idProduct}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });

    const product = await response.json();

    if( product.code === 200 ){
        
        document.getElementById('code_product').value = product.data.code_product;
        document.getElementById('name_product').value = product.data.name_product;
        document.getElementById('quantity').value = product.data.quantity;
        document.getElementById('price').value = product.data.price;
        document.getElementById('currency').value = product.data.currency;
        document.getElementById('entry_date').value = product.data.entry_date;
        document.getElementById('expiration_date').value = product.data.expiration_date;
        // document.getElementById('photo_product').value = product.data.photo_product;

        const preview = document.getElementById('productImagePreview');

        if (preview) {

            if( product.data.photo_product === null || product.data.photo_product === '' ){
                preview.src = '/images/default.png';
            }else{
                preview.src = product.data.photo_product;
            }


            preview.classList.remove('hidden');

        }

    }

    document.getElementById('productModal').classList.remove('hidden');
}

function closeModal(){
    document.getElementById('saveProductForm').reset();
    document.getElementById('productModal').classList.add('hidden');
}

function openModalDeleteProduct(idProduct){

    productToDelete = idProduct;

    document.getElementById('deleteStatus').classList.add('hidden');
    document.getElementById('confirmDeleteModal').classList.remove('hidden');

}

function closeModalDelete(){

    productToDelete = null;
    document.getElementById('confirmDeleteModal').classList.add('hidden');
    document.getElementById('deleteSpinner').classList.add('hidden');
    document.getElementById('deleteBtnText').textContent = 'Eliminar';

}

document.getElementById('confirmDeleteBtn').addEventListener('click', async (e) => {

    if (!productToDelete) return;

    const spinner = document.getElementById('deleteSpinner');
    const btnText = document.getElementById('deleteBtnText');
    const status = document.getElementById('deleteStatus');

    spinner.classList.remove('hidden');
    btnText.textContent = 'Eliminando...';

    try{

        const dataResponse = await fetch(`/api/v1/products/`+productToDelete, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })

        const response = await dataResponse.json();

        if( response.code !== 200 ) throw new Error('Error al eliminar el producto');

        status.textContent = '✅ Producto eliminado exitosamente.';
        status.classList.remove('hidden');
        status.classList.add('text-green-600');

        setTimeout(() => {
            closeModalDelete();
            currentPage = 1;
            getProducts(currentPage);
        }, 500);

    }catch (err) {

        status.textContent = '❌ Error al eliminar el producto.';
        status.classList.remove('hidden');
        status.classList.remove('text-green-600');
        status.classList.add('text-red-500');

    }finally {

        spinner.classList.add('hidden');
        btnText.textContent = 'Eliminar';

    }

});

document.addEventListener('DOMContentLoaded', async () => {

    getProducts(currentPage);

    document.getElementById('saveProductForm').addEventListener('submit', async (e) => {

        e.preventDefault();

        if( !isModalEdit ){
            //CREAR NUEVO PRODUCTO
            
            const codeProduct = document.getElementById('code_product').value;
            const nameProduct = document.getElementById('name_product').value;
            const quantity = document.getElementById('quantity').value;
            const price = document.getElementById('price').value;
            const currency = document.getElementById('currency').value;
            const entryDate = document.getElementById('entry_date').value;
            const expirationDate = document.getElementById('expiration_date').value;
            const photoProduct = document.getElementById('photo_product').files[0];

            let cleanBase64 = '';

            if( photoProduct ){
                const imageBase64 = await toBase64(photoProduct);
                cleanBase64 = imageBase64.split(',')[1];
            }
    
                
            const response = await fetch('/api/v1/products', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    code_product: codeProduct,
                    name_product: nameProduct,
                    quantity: quantity,
                    price: price,
                    currency: currency,
                    entry_date: entryDate,
                    expiration_date: expirationDate,
                    photo_product: cleanBase64
                })
            });

            if( response.status === 422 ){

                const errors = await response.json();

                cleanErrors();

                Object.entries(errors.errors).forEach(([field, message]) => {
                    const elementError = document.getElementById('error-'+field);
                    elementError.textContent = message.join(' ');
                });

                return;
            }
    
            const data = await response.json();
    
            if( data.code === 200 ){
    
                currentPage = 1;
                getProducts(currentPage);
    
                closeModal();
            }

        }else{
        
            const codeProduct = document.getElementById('code_product').value;
            const nameProduct = document.getElementById('name_product').value;
            const quantity = document.getElementById('quantity').value;
            const price = document.getElementById('price').value;
            const currency = document.getElementById('currency').value;
            const entryDate = document.getElementById('entry_date').value;
            const expirationDate = document.getElementById('expiration_date').value;
            const photoProduct = document.getElementById('photo_product').files[0];
            
            let cleanBase64 = '';

            if( photoProduct ){
                const imageBase64 = await toBase64(photoProduct);
                cleanBase64 = imageBase64.split(',')[1];
            }
    
                
            const response = await fetch('/api/v1/products/'+productEditId, {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    code_product: codeProduct,
                    name_product: nameProduct,
                    quantity: quantity,
                    price: price,
                    currency: currency,
                    entry_date: entryDate,
                    expiration_date: expirationDate,
                    photo_product: cleanBase64
                })
            });

            if( response.status === 422 ){

                const errors = await response.json();

                cleanErrors();

                Object.entries(errors.errors).forEach(([field, message]) => {
                    const elementError = document.getElementById('error-'+field);
                    elementError.textContent = message.join(' ');
                });

                return;
            }
    
            const data = await response.json();
    
            if( data.code === 200 ){
    
                currentPage = 1;
                getProducts(currentPage);
    
                closeModal();
            }

        }


    });

})

function cleanErrors(){

    const inputErrors = ['code_product', 'name_product', 'quantity', 'price', 'currency', 'entry_date', 'expiration_date'];

    inputErrors.forEach(field => {
        const elementError = document.getElementById('error-'+field);

        if( elementError ){
            elementError.textContent = '';
        }

    })

}

function toBase64(file) {

    return new Promise((resolve, reject) => {
        const reader = new FileReader();

        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result); 
        
        reader.onerror = error => reject(error);

    });

}