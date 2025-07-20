let tBody = document.getElementById('product-tbody');
let tPagination = document.querySelector('.pagination');
let tSort = document.querySelector('.sort');
let currentPage = 1;
let totalPages = 0;
let totalItems = 0;

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

        tPagination.innerHTML = `<p>No hay productos</p>`;
        return;

    }
    console.log(response);
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
            <td>${product.price}</td>
            <td>${product.created_at}</td>
            <td>${product.updated_at}</td>
            <td onclick="editProduct(${product.id})">Editar</td>
            <td onclick="deleteProduct(${product.id})">Eliminar</td>
        `;

        tBody.appendChild(row);

    });

}

function loadPagination(pagination){

    const { total_items, total_pages } = pagination;
    tPagination.innerHTML = '';

    totalPages = total_pages;
    totalItems = total_items;

    if( currentPage === 1 && totalPages > 1 ){

        tPagination.innerHTML = `
            <span class="page-link">${currentPage} de ${totalPages}</span>
            <a href="#" class="page-link" aria-label="Next" onclick="nextPage()">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        `;

    }else if( currentPage === totalPages && totalPages > 1 ){

        tPagination.innerHTML = `
            <a href="#" class="page-link" aria-label="Previous" onclick="previosPage()">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
            <span class="page-link">${currentPage} de ${totalPages}</span>
        `;

    }else if( currentPage === 1 && totalPages === 1 ){

        tPagination.innerHTML = `
            <span class="page-link">${currentPage} de ${totalPages}</span>
        `;

    }else{

        tPagination.innerHTML = `
            <a href="#" class="page-link" aria-label="Previous" onclick="previosPage()">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
            <span class="page-link">${currentPage} de ${totalPages}</span>
            <a href="#" class="page-link" aria-label="Next" onclick="nextPage()">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
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

document.addEventListener('DOMContentLoaded', async () => {

    getProducts(currentPage);

})