<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Link ke Google Fonts untuk Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="h-screen flex items-center justify-center bg-gray-100">

  <div class="flex w-full max-w-2xl bg-white rounded-lg shadow-lg overflow-hidden">
    <!-- Left Side: Image -->
    <div class="w-5/12 bg-cover bg-center" style="background-image: url('/images/background-login.webp');">
    </div>

    <!-- Right Side: Login Form -->
    <div class="w-7/12 p-4 flex flex-col justify-center">
      <div class="flex flex-col items-start p-6">
        <!-- Logo -->
        <img src="/images/SST-Logo.webp" alt="Logo" class="h-12 mb-2">

        <!-- Title and Subtitle -->
        <h2 class="text-lg font-semibold text-gray-800 mb-1">Hey, Hello 👋</h2>
        <p class="text-gray-600 mb-4 text-xs">Masukkan informasi yang Anda untuk login</p>
        <!-- Login Heading -->
        <h3 class="text-base font-semibold text-gray-700 mb-3">Login</h3>

        <!-- Login Form -->
        <form class="w-full" method="POST" action="{{ route('login') }}">
          @csrf

          <input type="hidden" name="redirect" value="{{ request()->query('redirect') }}">
          <div class="mb-3">
            <label class="block text-gray-700 text-xs mb-1" for="username">Username</label>
            <div class="flex items-center border rounded-lg focus-within:ring-2 focus-within:ring-blue-500">
              <!-- Icon -->
              <span class="pl-2 text-gray-500">
                <img src="/icon/username.png" alt="Username Icon" class="h-4 w-4">
              </span>
              <!-- Input Field -->
              <input type="text" id="username" name="username" placeholder="username" value="{{ old('username') }}" class="w-full px-2 py-1 focus:outline-none text-xs">
            </div>
            <x-input-error :messages="$errors->get('username')" class="text-xs text-red-500 mt-0.5" />
          </div>

          <div class="mb-3">
            <label class="block text-gray-700 text-xs mb-1" for="password">Password</label>
            <div class="flex items-center border rounded-lg focus-within:ring-2 focus-within:ring-blue-500">
              <!-- Icon for Password -->
              <span class="pl-2 text-gray-500">
                <img src="/icon/Lock 1.png" alt="Password Icon" class="h-4 w-4">
              </span>
              <!-- Input Field for Password -->
              <input type="password" id="password" name="password" placeholder="********" class="w-full px-2 py-1 focus:outline-none text-xs">
            </div>
            <x-input-error :messages="$errors->get('password')" class="text-xs text-red-500 mt-0.5" />
          </div>
          <button type="submit" class="w-full py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-semibold text-xs mb-3">Login</button>
        </form>

        <!-- Divider -->
        <div class="flex items-center w-full my-2">
          <hr class="w-full border-gray-300">
          <span class="px-2 text-gray-500 text-xs">or</span>
          <hr class="w-full border-gray-300">
        </div>

        <!-- Sign in with Google -->
        <a href="{{ route('auth.redirect') }}" class="w-full py-2 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-100">
          <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google Logo" class="h-3 w-3 mr-2">
          <span class="text-gray-700 font-semibold text-xs">Sign in with Google</span>
        </a >
      </div>
    </div>
  </div>

</body>
</html>
