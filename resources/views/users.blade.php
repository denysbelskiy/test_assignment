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
    <script src="{{ asset('js/users.js')}}"></script>
  </body>
</html>