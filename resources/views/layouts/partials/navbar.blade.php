{{-- resources/views/partials/navbar.blade.php --}}
<nav class="bg-white shadow-sm px-6 py-3 flex justify-between items-center sticky top-0 z-20">
    <div class="flex items-center">
        <button id="sidebarToggle" class="lg:hidden text-gray-600 mr-4">
            <i class="fas fa-bars text-xl"></i>
        </button>
        <div class="flex items-center space-x-2">
            <i class="fas fa-school text-blue-800 text-xl"></i>
            <span class="text-gray-800 font-semibold">Collège Notre-Dame de Grâce</span>
        </div>
    </div>
    
    <div class="flex items-center space-x-4">
        <!-- Notifications -->
        <div class="relative">
            <button id="notificationBtn" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-bell text-lg"></i>
                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
            </button>
        </div>
        
        <!-- User Menu -->
        <div class="relative">
            <button id="userMenuBtn" class="flex items-center space-x-3 focus:outline-none">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                    <p class="text-xs text-gray-500">
                        @if(Auth::user() && Auth::user()->role == 'administrateur') Administrateur
                        @elseif(Auth::user() && Auth::user()->role == 'comptable') Comptable
                        @elseif(Auth::user() && Auth::user()->role == 'parent') Parent
                        @else Élève
                        @endif
                    </p>
                </div>
                <div class="w-9 h-9 bg-blue-600 flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <i class="fas fa-chevron-down text-gray-400 text-xs hidden sm:block"></i>
            </button>
            
            <!-- Dropdown Menu -->
            <div id="userDropdown" class="absolute right-0 mt-2 w-48 bg-white shadow-lg hidden z-30">
                <div class="py-1">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user mr-2"></i> Mon profil
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-cog mr-2"></i> Paramètres
                    </a>
                    <div class="border-t my-1"></div>
                    <form method="POST" action="
                        @if(Auth::user() && Auth::user()->role == 'administrateur') {{ route('admin.logout') }}
                        @elseif(Auth::user() && Auth::user()->role == 'comptable') {{ route('comptable.logout') }}
                        @elseif(Auth::user() && Auth::user()->role == 'parent') {{ route('parent.logout') }}
                        @else {{ route('eleve.logout') }}
                        @endif
                    ">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.getElementById('userMenuBtn')?.addEventListener('click', function() {
        document.getElementById('userDropdown')?.classList.toggle('hidden');
    });
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.querySelector('.sidebar')?.classList.toggle('-translate-x-full');
    });
    window.addEventListener('click', function(e) {
        if (!document.getElementById('userMenuBtn')?.contains(e.target)) {
            document.getElementById('userDropdown')?.classList.add('hidden');
        }
    });
</script>