<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteMan - Login</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: radial-gradient(circle at center, #3B61B1 0%, #2D509E 100%); 
        }
        .brand-font { 
            font-family: 'Playfair Display', serif; 
        }
        
        .custom-card {
            border-radius: 2.5rem !important;
            max-width: 480px;
            width: 100%;
        }
        
        .form-control-custom {
            padding: 0.85rem 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.75rem !important;
            font-size: 0.95rem;
            transition: all 0.2s ease-in-out;
        }
        .form-control-custom:focus {
            outline: none;
            box-shadow: 0 0 0 2px #2D509E;
            border-color: transparent;
            background-color: #fff;
        }
        .btn-custom {
            background-color: #2D509E;
            border-radius: 0.75rem !important;
            padding-top: 0.95rem;
            padding-bottom: 0.95rem;
            transition: all 0.3s ease-in-out;
        }
        .btn-custom:hover {
            background-color: #1e3a8a !important; 
            color: #ffffff;
        }
    </style>
</head>
<body class="min-vh-100 d-flex align-items-center justify-content-center p-3">

    <div class="card custom-card bg-white border-0 shadow-lg p-4 p-md-5">
        <div class="card-body">
            
            <div class="text-center mb-5">
                <h1 class="brand-font display-4 fw-bold mb-2" style="color: #2D509E;">
                    Note<span style="color: #E67E5A;">Man</span>
                </h1>
                
                @auth
                    <p class="text-muted fs-6 mb-0">You are already logged in as <strong>{{ Auth::user()->name }}</strong></p>
                @else
                    <p class="text-muted fs-6 mb-0">Welcome back — sign in to continue</p>
                @endauth
            </div>

            @auth
                <div class="text-center">
                    @if(strtolower(Auth::user()->role) === 'admin')
                        <a href="{{ url('/admin/users') }}" class="btn btn-custom w-100 text-white fw-bold fs-5 border-0 shadow type-button mb-3">
                            Go to Admin Dashboard
                        </a>
                    @else
                        <a href="{{ url('/home') }}" class="btn btn-custom w-100 text-white fw-bold fs-5 border-0 shadow type-button mb-3">
                            Go to My Notes
                        </a>
                    @endif
                    
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link text-secondary small text-decoration-none fw-semibold">
                            Sign out of this account
                        </button>
                    </form>
                </div>
            @else
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label text-secondary small fw-bold mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter Email" required
                            class="form-control form-control-custom @error('email') is-invalid @enderror">
                        @error('email') 
                            <div class="invalid-feedback mt-1">{{ $message }}</div> 
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary small fw-bold mb-2">Password</label>
                        <input type="password" name="password" placeholder="Enter Password" required
                            class="form-control form-control-custom">
                    </div>

                    <button type="submit" class="btn btn-custom w-100 text-white fw-bold fs-5 border-0 shadow mt-2">
                        Log In
                    </button>
                </form>

                <p class="text-center text-muted mt-5 mb-0">
                    Don't have an account? <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #2D509E;">Register</a>
                </p>
            @endauth
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>