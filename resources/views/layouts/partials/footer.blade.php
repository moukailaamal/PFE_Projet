<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-4">
        <div class="flex flex-col items-center text-center">
            <!-- Logo/Brand -->
            <div class="mb-4">
                <a href="{{ route('home') }}" class="text-xl font-bold flex items-center lg:ml-2.5">
                    <img src="{{ asset('images/logo.svg') }}" class="h-6 mr-2" alt="Tuni Repair Logo">
                    <h2 class="text-2xl font-bold">TuniRepair</h2>
                  </a>
              
                <p class="text-gray-400 mt-1">Your trusted repair service</p>
            </div>
            
            <!-- Contact Info -->
            <div class="mb-6">
                <p class="text-gray-300">123 Repair Street, Tunis</p>
                <p class="text-gray-300">contact@tunirepair.com</p>
                <p class="text-gray-300">+216 12 345 678</p>
            </div>
            
            <!-- Social Links -->
            <div class="flex space-x-4 mb-6">
                <a href="#" class="text-gray-300 hover:text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                    </svg>
                </a>
                <a href="#" class="text-gray-300 hover:text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
                <a href="#" class="text-gray-300 hover:text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                    </svg>
                </a>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-gray-700 pt-6 w-full">
                <p class="text-gray-400 text-sm">© 2023 TuniRepair. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
<script>
    document.addEventListener('scroll', function () {
        const sidebar = document.getElementById('sidebar');
        const footer = document.querySelector('footer');
        const footerTop = footer.getBoundingClientRect().top;
        const sidebarHeight = sidebar.offsetHeight;
        const windowHeight = window.innerHeight;

        if (footerTop < windowHeight) {
            sidebar.style.position = 'absolute';
            sidebar.style.bottom = (windowHeight - footerTop + 16) + 'px';
        } else {
            sidebar.style.position = 'fixed';
            sidebar.style.bottom = 'auto';
        }
    });
</script>