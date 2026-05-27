<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note Management</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/all.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f8f9fa;
        }
        /* Custom layout structures mimicking your dark menu grid look */
        .sidebar-wrapper {
            width: 260px;
            min-height: 100vh;
            background-color: #1E293B;
            padding: 1.5rem;
        }
        .sidebar-heading-small {
            font-size: 10px;
            font-weight: 700;
            text-uppercase: uppercase;
            letter-spacing: 0.1em;
            color: #64748B;
        }
        .custom-nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #F8FAFC;
            font-size: 0.95rem;
            font-weight: 500;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
            margin-bottom: 0.25rem;
        }
        .custom-nav-link:hover {
            background-color: #334155;
            color: #FFFFFF;
        }
        .custom-nav-link.active-tab {
            background-color: #2563EB !important;
            color: #FFFFFF !important;
        }
        .logout-btn {
            color: #F87171;
            transition: background-color 0.2s;
        }
        .logout-btn:hover {
            background-color: rgba(248, 113, 113, 0.1);
            color: #F87171;
        }
        .profile-avatar {
            width: 40px;
            height: 40px;
            background-color: #E67E5A;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #FFFFFF;
            flex-shrink: 0;
        }
    </style>
</head>
<body class="d-flex">

    <aside class="sidebar-wrapper d-flex flex-column text-white">
        <h1 class="h3 fw-bold text-white mb-1">Note<span style="color: #E67E5A;">Man</span></h1>
        <p class="text-uppercase text-secondary tracking-widest mb-4" style="font-size: 10px; font-weight: 700; letter-spacing: 0.15em; color: #94A3B8 !important;">Management System</p>
        
        <nav class="d-flex flex-column flex-grow-1">
            <div class="sidebar-heading-small text-uppercase mb-2 mt-2">Main</div>
            <a href="{{ route('dashboard') }}" class="custom-nav-link {{ request()->routeIs('dashboard') ? 'active-tab' : '' }}">
                <span>Dashboard</span>
            </a>
            
            <div class="sidebar-heading-small text-uppercase mb-2 mt-4">Management</div>
            <a href="{{ route('users.index') }}" class="custom-nav-link {{ request()->routeIs('users.index') ? 'active-tab' : '' }}">
                <span>User Management</span>
            </a>
            <a href="{{ route('notes.index') }}" class="custom-nav-link {{ request()->routeIs('notes.*') || request()->routeIs('notes.index') ? 'active-tab' : '' }}">
                <span>Notes</span>
            </a>
            
            <div class="sidebar-heading-small text-uppercase mb-2 mt-4">Account</div>
            <a href="{{ route('profile') }}" class="custom-nav-link {{ request()->routeIs('profile') ? 'active-tab' : '' }}">
                <span>My Profile</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn w-full text-start custom-nav-link logout-btn border-0 bg-transparent shadow-none">
                    <span class="fw-medium">Log Out</span>
                </button>
            </form>
        </nav>

        <div class="mt-auto pt-3 border-top border-secondary d-flex align-items-center gap-3">
            <div class="profile-avatar">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="overflow-hidden text-nowrap">
                <p class="text-sm fw-bold mb-0 text-truncate" style="font-size: 0.9rem;">{{ auth()->user()->name }}</p>
                <p class="text-muted mb-0 small text-truncate" style="font-size: 0.75rem; color: #94A3B8 !important;">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </aside>

    <main class="flex-grow-1 p-4 overflow-y-auto" style="height: 100vh;">   
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>