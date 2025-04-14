<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Users List</title>
</head>
<body class="bg-[#1b3164] text-white min-h-screen px-4">
    <div class="flex flex-col lg:flex-row gap-4 h-screen">
      <!-- Form -->
      <div class="lg:w-1/3 w-full flex flex-col items-center justify-center">
        <div id="token-container" class="bg-[#1e293b] flex flex-col items-center justify-center my-7 p-6 rounded-xl w-full max-w-md space-y-4">
            <button id="get-token" class="w-52 bg-green-600 hover:bg-green-700 text-white py-2 rounded-md font-semibold">Get Token</button>
        </div>
        <div id="form-error-message" class="bg-[#1e293b] text-red-800 text-2xl mb-7 p-6 rounded-xl w-full max-w-md space-y-4 hidden">
        </div>
        <form id="add-new-user" class="bg-[#1e293b] flex flex-col items-center justify-center p-6 rounded-xl w-full max-w-md space-y-4">
            <input type="text" placeholder="Token" name="token" required class="w-full px-4 py-2 bg-white text-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 hover:ring-2 hover:ring-green-500" />
            <h2 class="text-2xl font-semibold text-center mb-4">Add New User</h2>
            <input type="text" placeholder="Name" name="name" required class="w-full px-4 py-2 bg-white text-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 hover:ring-2 hover:ring-green-500" />
            <input type="email" placeholder="Email" name="email" required class="w-full px-4 py-2 bg-white text-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 hover:ring-2 hover:ring-green-500" />
            <input type="tel" placeholder="Phone" name="phone" required class="w-full px-4 py-2 bg-white text-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 hover:ring-2 hover:ring-green-500" />
            <select id="position-select" name="position" required class="w-full px-4 py-2 bg-white text-black rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 hover:ring-2 hover:ring-green-500">
                <option value="null">Option</option>
            </select>
            <input type="file" name="photo" required class="w-full h-20 bg-white text-black rounded-md" />
            <button id="submit-button" type="submit" class="w-52 bg-green-600 hover:bg-green-700 text-white py-2 rounded-md font-semibold">Create</button>
            <div id="loader" class="hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 animate-[spin_0.8s_linear_infinite] fill-blue-600 block mx-auto" viewBox="0 0 24 24">
                    <path
                        d="M12 22c5.421 0 10-4.579 10-10h-2c0 4.337-3.663 8-8 8s-8-3.663-8-8c0-4.336 3.663-8 8-8V2C6.579 2 2 6.58 2 12c0 5.421 4.579 10 10 10z"
                        data-original="#000000" />
                </svg>
            </div>
        </form>
      </div>

      <!-- Members List -->
      <div class="lg:w-2/3 w-full flex items-center justify-center">
        <div class="overflow-y-auto h-full w-full pt-6 pb-18 flex flex-col">
            <div id="users-container" class="grid grid-cols-2 lg:grid-cols-3 gap-10 justify-items-center m-auto">
                <div id="users-error-message" class="bg-[#1e293b] text-red-800 col-span-3 text-2xl mb-7 p-6 rounded-xl w-full max-w-md space-y-4 hidden">
                </div>
            </div>
            <div class="m-16 flex justify-center">
                <button id="show-more" class="w-52 bg-green-600 hover:bg-green-700 text-white py-2 rounded-md font-semibold">Show More</button>
            </div>
        </div>
      </div>
    </div>
    {{-- <script>
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
    </script> --}}
    <script src="{{ asset('js/users.js')}}"></script>
  </body>
</html>