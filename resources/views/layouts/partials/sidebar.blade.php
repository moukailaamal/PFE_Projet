@php
    // Récupération du slug de la page actuelle
    $url = explode('/', request()->path());
    $page_slug = end($url);
@endphp

<!-- ==================== -->
<!-- COMPOSANT SIDEBAR -->
<!-- ==================== -->

<!-- Bouton de bascule pour mobile -->
<button id="sidebarToggle" class="lg:hidden fixed top-4 left-4 z-30 p-2 bg-white rounded-lg shadow-md focus:outline-none">
    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
    </svg>
</button>

<!-- Overlay pour mobile -->
<div id="sidebarOverlay" class="fixed inset-0 z-10 bg-black opacity-50 hidden lg:hidden"></div>

<!-- Barre latérale principale -->
<aside id="sidebar" class="fixed z-20 h-full top-0 left-0 pt-16 flex flex-shrink-0 flex-col w-64 transition-transform duration-300 transform -translate-x-full lg:translate-x-0" aria-label="Sidebar">
    <div class="relative flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white pt-0">
        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 bg-white divide-y space-y-1">
                
                <!-- ==================== -->
                <!-- SECTION PROFIL UTILISATEUR -->
                <!-- ==================== -->
                @auth
                <div class="flex items-center space-x-4 p-4">
                    <img class="w-20 h-20 rounded-full" src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/default-avatar.png') }}" alt="Photo de profil">
                    <div>
                        <p class="text-lg font-medium text-gray-900">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                        <p class="text-sm text-gray-500">{{ Auth::user()->role }}</p>
                    </div>
                </div>       
                @endauth

                <!-- ==================== -->
                <!-- MENU PRINCIPAL -->
                <!-- ==================== -->
                <ul class="space-y-2 pb-2">
                    
                    <!-- Accueil (Visible pour tous) -->
                    <li>
                        <a href="{{ route('home') }}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group">
                            <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            <span class="ml-3">Home</span>
                        </a>
                    </li>

                    <!-- ==================== -->
                    <!-- MENU TECHNICIEN -->
                    <!-- ==================== -->
                    @auth
                        @if(Auth::user()->role == "technician")
                            <!-- Rendez-vous (Technicien) -->
                            <li>
                                <a href="{{ route('book.listAppointmentsTech', Auth::user()->id) }}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group">
                                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="ml-3">Appointments</span>
                                </a>
                            </li>

                            <!-- Catégories -->
                            <li>
                                <a href="{{ route('categories.index') }}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group">
                                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                    </svg>
                                    <span class="ml-3">Category</span>
                                </a>
                            </li>

                            <!-- Services -->
                            <li>
                                <a href="{{ route('services.index') }}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group">
                                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                    </svg>
                                    <span class="ml-3">Service</span>
                                </a>
                            </li>
                        @endif
                    @endauth

                    <!-- ==================== -->
                    <!-- MENU CLIENT -->
                    <!-- ==================== -->
                    @auth
                        @if(Auth::user()->role == "client")
                            <!-- Rendez-vous (Client) -->
                            <li>
                                <a href="{{ route('book.listAppointmentsClient', Auth::user()->id) }}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group">
                                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="ml-3">Appointments</span>
                                </a>
                            </li>
                        @endif
                    @endauth

                    <!-- ==================== -->
                    <!-- MENU COMMUN -->
                    <!-- ==================== -->
                    <!-- Liste des techniciens (Visible pour tous) -->
                    <li>
                        <a href="{{ route('technician.list') }}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group">
                            <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="ml-3">List technician</span>
                        </a>
                    </li>

                    <!-- Tous les rendez-vous (Visible pour admin ou selon besoin) -->
                    <li>
                        <a href="{{ route('book.listAppointmentsAdmin') }}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group">
                            <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="ml-3">All appointment</span>
                        </a>
                    </li>

                    <!-- ==================== -->
                    <!-- MENU UTILISATEUR CONNECTÉ -->
                    <!-- ==================== -->
                    @auth
                    <!-- Profil -->
                    <li>
                        <a href="{{ route('profile.edit') }}" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group @if($page_slug == 'inbox') bg-gray-100 @endif">
                            <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-3 flex-1 whitespace-nowrap">My account</span>
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</aside>

<!-- ==================== -->
<!-- SCRIPTS -->
<!-- ==================== -->
<script>
    // Gestion de l'affichage du sidebar sur mobile
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('translate-x-0');
        sidebarOverlay.classList.toggle('hidden');
    });

    sidebarOverlay.addEventListener('click', () => {
        sidebar.classList.remove('translate-x-0');
        sidebarOverlay.classList.add('hidden');
    });
</script>