<nav class="navbar navbar-expand-lg fixed-top shadow-sm" style="background-color: #ffffff;">
    <div class="container">
        <!-- Logo et nom -->
        <a class="navbar-brand d-flex align-items-center" href="/">
            <i class="fas fa-piggy-bank text-primary me-2"></i>
            <span class="fw-bold">SaveSmart</span>
        </a>

        <!-- Bouton toggle pour mobile -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu de navigation -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="fas fa-home me-1"></i> Accueil
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">
                            <i class="fas fa-chart-line me-1"></i> Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/transactions">
                            <i class="fas fa-exchange-alt me-1"></i> Transactions
                        </a>
                    </li>
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i> Inscription
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->email }}&size=32&background=random" 
                                 class="rounded-circle me-2" width="32" height="32">
                            <span>{{ auth()->user()->email }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li>
                                <a class="dropdown-item" href="{{ route('auth.profile') }}">
                                    <i class="fas fa-user me-2"></i> Mon Profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/settings">
                                    <i class="fas fa-cog me-2"></i> Paramètres
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Ajout des styles CSS -->
<style>
.navbar {
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.navbar-brand {
    font-size: 1.5rem;
}

.nav-link {
    padding: 0.5rem 1rem !important;
    color: #6c757d !important;
    transition: color 0.2s;
}

.nav-link:hover {
    color: #0d6efd !important;
}

.dropdown-menu {
    border-radius: 10px;
    margin-top: 10px;
}

.dropdown-item {
    padding: 0.7rem 1.5rem;
    color: #6c757d;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    color: #0d6efd;
}

.dropdown-item.text-danger:hover {
    color: #dc3545 !important;
}
</style>