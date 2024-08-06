<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin - Chubcay</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="w-full h-screen flex items-center justify-center">
        <div class="container mx-auto w-full max-w-md">
            <h1 class="p-2 text-xl font-bold uppercase">Admin login</h1>
            <form action="{{ route('admin.login') }}" method="POST" class="bg-white shadow-md w-full p-6 rounded-md">
                @csrf
                <div class="w-full p-3 flex flex-col items-start justify-center gap-2">
                    <label for="Email">Email</label>
                    <input name="email"
                        class="border w-full p-2" type="email" placeholder="Enter email....">
    
                    <label for="Password">Password</label>
                    <input name="password"
                        class="border w-full p-2" type="password" placeholder="**********">
    
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md mt-4">Login</button>
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>