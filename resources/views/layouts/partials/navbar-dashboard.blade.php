<nav class="bg-white border-b border-gray-200 fixed z-30 w-full">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start">
          <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar" class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded">
            <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
            <svg id="toggleSidebarMobileClose" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
          <a href="{{ route('home') }}" class="text-xl font-bold flex items-center lg:ml-2.5">
            <img src="{{ asset('images/logo.svg') }}" class="h-6 mr-2" alt="Tuni Repair Logo">
            <span class="self-center whitespace-nowrap">Tuni Repair</span> 
          </a>
          <form action="#" method="GET" class="hidden lg:block lg:pl-32">
            <label for="topbar-search" class="sr-only">Search</label>
            <div class="mt-1 relative lg:w-64">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
              </div>
              <input type="text" name="email" id="topbar-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full pl-10 p-2.5" placeholder="Search">
            </div>
          </form>
        </div>
        <div class="flex items-center gap-3 relative" id="avatar-dropdown">
          @auth
              <!-- Avatar et nom de l'utilisateur -->
              <div class="flex items-center gap-3 cursor-pointer">
                  <img class="w-10 h-10 rounded-full border-2 border-gray-300" 
                      src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/default-avatar.png') }}" 
                      alt="Profile" id="avatar-dropdown">
                  
                  <span class="text-lg font-semibold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
              </div>
      
              <!-- Menu déroulant -->
              <div id="dropdown-menu" class="hidden absolute top-full mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                  <ul class="py-2">
                      <li><a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">My informations</a></li>
                      <li>
                          <form id="logout" action="{{ route('logout') }}" method="POST">
                              @csrf
                              <button type="submit" class="block px-4 py-2 w-full text-gray-800 text-left hover:bg-gray-100">Logout</button>
                          </form>
                      </li>
                  </ul>
              </div>
          @else
              <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Login</a>
          @endauth
      </div>
      
        
      
    
    </div>
  </nav>
  <script>
    document.getElementById('avatar-dropdown').addEventListener('click', function() {
        const dropdown = document.getElementById('dropdown-menu');
        dropdown.classList.toggle('hidden');
    });
  
    // Optionnel : fermer le menu lorsque l'utilisateur clique en dehors
    window.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdown-menu');
        const avatar = document.getElementById('avatar-dropdown');
        if (!avatar.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
  </script>