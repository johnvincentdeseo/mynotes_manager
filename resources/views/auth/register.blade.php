<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteMan - Create Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: radial-gradient(circle at center, #3B61B1 0%, #2D509E 100%); }
        .brand-font { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="bg-white rounded-[2.5rem] shadow-2xl p-10 w-full max-w-[480px]">
        <div class="text-center mb-10">
            <h1 class="brand-font text-5xl text-[#2D509E] mb-2">Note<span class="text-[#E67E5A]">Man</span></h1>
            <p class="text-gray-400 text-lg">Create your account to get started</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" 
                    class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2D509E] focus:border-transparent outline-none transition duration-200">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" 
                    class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2D509E] focus:border-transparent outline-none transition duration-200">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                <input type="password" name="password" placeholder="Minimum 6 characters" 
                    class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2D509E] focus:border-transparent outline-none transition duration-200">
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="confirm password" 
                    class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2D509E] focus:border-transparent outline-none transition duration-200">
            </div>

            <button type="submit" class="w-full bg-[#2D509E] text-white py-4 rounded-xl font-bold text-lg hover:bg-blue-900 transition-all duration-300 shadow-lg mt-4">
                Create Account
            </button>
        </form>
    </div>
</body>
</html>