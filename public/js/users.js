let page = 1;
let count = 6;
const usersContainer = document.getElementById('users-container');
const formEl = document.getElementById('add-new-user');
const showMoreEl = document.getElementById('show-more');
const getTokenEl = document.getElementById('get-token');
const loaderEl = document.getElementById('loader');
const button = document.getElementById('submit-button');
const formErrorEl = document.getElementById('form-error-message');
const usersErrorEl = document.getElementById('users-error-message');

function copyFullToken(button) {
    const token = button.value;
    navigator.clipboard.writeText(token)
        .then(() => alert('Token copied to clipboard!'))
        .catch(() => alert('Failed to copy token.'));
}
function renderUserCard(user) {
    return markup = `
        <div class="bg-white p-4 shadow flex flex-col items-center text-center w-52 hover:border-2 hover:border-green-500 rounded-lg">
            <img src="${user.photo}" alt="User Photo" class="h-[70px] w-[70px] object-cover mb-4 rounded-md">
            <h3 class="font-semibold text-lg text-black">${user.name}</h3>
            <p class="text-sm text-gray-600">${user.email}</p>
            <p class="text-sm text-gray-600">${user.phone}</p>
            <p class="text-sm text-gray-700 mb-2">${user.position}</p>
        </div>
    `;
}
function showLoadig() {
    button.classList.add('hidden');
    loaderEl.classList.remove('hidden');
}
function hideLoading() {
    button.classList.remove('hidden');
    loaderEl.classList.add('hidden');
}
function showFormError(error) {
    formErrorEl.classList.remove('hidden');
    formErrorEl.innerHTML = error;
}
function hideFormError(){
    if(formErrorEl.classList.contains('hidden')){
        return;
    }
    formErrorEl.classList.add('hidden');
}
function showUsersError(error) {
    usersErrorEl.classList.remove('hidden');
    usersErrorEl.innerHTML = error;
}
function renderUsers(container, users) {
    users.forEach( user => {
        container.insertAdjacentHTML('beforeend', renderUserCard(user));
    });
}
function disableShowMore() {
    let button = document.getElementById('show-more');
    button.disabled = true;
    button.innerHTML = 'No more users';
    button.classList.remove('hover:bg-green-700');
    button.classList.add('cursor-not-allowed','hover:bg-red-600');
}
function insertPositions(positions) {
    positions.forEach(position => {
        let markup = `<option value="${position.id}">${position.name}</option>`;
        document.getElementById('position-select').insertAdjacentHTML('beforeend', markup);
    });
}
function insertToken(token) {
    const copyButtonEl = document.getElementById('copy-token');
    if(copyButtonEl) {
        copyButtonEl.value = token
    }else {
        let markup = `
            <button  
                id="copy-token"
                class="w-52 bg-red-600 hover:bg-red-700 text-white py-2 rounded-md font-semibold" 
                value="${token}" 
                onclick="copyFullToken(this)">
                    Copy to clipboard
            </button>`;
        document.getElementById('token-container').insertAdjacentHTML('afterbegin', markup);
    }
}
async function fetchUsers(count, page) {
    try {
        const response = await fetch(`/api/v1/users?page=${page}&count=${count}`);
        const data = await response.json();
        if (!response.ok) {
            showUsersError(response.message);
            throw new Error(`Response status: ${response.status}`);
        }
        if(!data.links.next_url){
            disableShowMore();
        }
        renderUsers(usersContainer, data.users);
    } catch (error) {
        showUsersError(error);
        console.error(error.message);
    }
}
async function fetchPositions() {
    try {
        const response = await fetch(`/api/v1/positions`);
        const data = await response.json();
        hideFormError();
        if (!response.ok) {
            showFormError(response.status);
            throw new Error(`Response status: ${response.status}`);
        }
        insertPositions(data.positions);
    } catch (error) {
        showFormError(error.message);
        console.log(error.message);
    }
}
async function fetchToken() {
    try {
        const response = await fetch(`/api/v1/token`);
        const data = await response.json();
        hideFormError();
        if (!response.ok) {
            showFormError(response.status);
            throw new Error(`Response status: ${response.status}`);
        }
        insertToken(data.token);
    } catch (error) {
        showFormError(error.message);
        console.log(error.message);
    }
}
async function storeUser(formEl) {
    const formData = new FormData(formEl);
    const token = formData.get('token');
    formData.set('position_id', formData.get('position'));
    formData.delete('position');
    formData.delete('token');
    try {
        const response = await fetch('/api/v1/users', {
            method: 'POST',
            headers: {
                'token': `${token}`,
            },
            body: formData,
        });

        if (response.ok) {
            hideFormError();
            let alertContent = await response.json();
            alert(alertContent);
            formEl.reset();
        } else {
            const errorData = await response.json();
            showFormError('adding user unsuccessful: ' + (errorData.error || errorData.message ||'Unknown error'));
        }
    } catch (error) {
        console.error('Error adding user:', error);
        showFormError(error);
    }
}
fetchUsers(count, page);
fetchPositions();
showMoreEl.addEventListener('click', () => {
    fetchUsers(count, page++);
});
getTokenEl.addEventListener('click', () => {
    fetchToken();
});
formEl.addEventListener('submit', event => {
    event.preventDefault();
    storeUser(formEl);
    showLoadig();
    hideLoading();
});