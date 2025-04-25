@extends('layouts.app')

@section('title', 'All Services')

@include('layouts.partials.navbar-dashboard')  
@include('layouts.partials.sidebar') 
@section('content')
<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200">
    <div class="mb-1 w-full mt-16">
        <div class="mb-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 0001.414-1.414l-7-7z"></path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('services.index') }}" class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Services</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">List</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All Services</h1>
        </div>

        <div class="flex justify-between items-center">
            <form class="relative lg:w-64 xl:w-96" action="#" method="GET">
                <input type="text" name="search" id="service-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Search for services">
            </form>
            <button type="button" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2" id="open-modal-button">
                <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                Add Service
            </button>
        </div>
    </div>
</div>

<div class="overflow-x-auto mt-4">
    <table class="table-auto min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-4">#</th>
                <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($services as $service)
            <tr class="hover:bg-gray-100">
                <td class="p-4">{{ $loop->iteration }}</td>
                <td class="p-4 font-semibold text-gray-900">{{ $service->title }}</td>
                <td class="p-4 font-semibold text-gray-900">{{ $service->category->name ?? 'Aucune catégorie' }}</td>                <td class="p-4 flex space-x-2">
                    <!-- Edit Button -->
                    <button type="button" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-3 py-2 edit-service-btn"
                    data-modal-toggle="edit-service-modal"
                    data-id="{{ $service->id }}"
                    data-title="{{ $service->title }}"
                    data-category_id="{{ $service->category_id }}"
                    data-technician_id="{{ $service->technician_id }}">
                    <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                    </svg>
                    Edit
                </button>

                    <!-- Delete Button -->
                    <button type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 delete-service-btn"
                        data-modal-toggle="delete-service-modal"
                        data-id="{{ $service->id }}">
                        <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 011 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd"></path>
                        </svg>
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Service Modal -->
<div id="add-service-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative bg-white rounded-lg shadow-lg w-96 p-6">
        <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" data-modal-toggle="add-service-modal">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 6L14 14M6 14L14 6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
        </button>
        <h3 class="text-xl font-semibold mb-4">Add Service</h3>
        <form action="{{ route('services.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="service-title" class="block text-sm font-medium text-gray-700">Service Title</label>
                <input type="text" id="service-title" name="title" class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600">
            </div>
            <div class="mb-4">
                <label for="category_id" class="text-sm font-medium text-gray-900 block mb-2">Category</label>
                <select name="category_id" id="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="technician_id" value="{{ Auth::id() }}">
            <div class="flex justify-end space-x-2">
                <button type="button" class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2" data-modal-toggle="add-service-modal">Cancel</button>
                <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-4 py-2">Add</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Service Modal -->
<div id="edit-service-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative bg-white rounded-lg shadow-lg w-96 p-6">
        <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" data-modal-toggle="edit-service-modal">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 6L14 14M6 14L14 6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
        </button>
        <h3 class="text-xl font-semibold mb-4">Edit Service</h3>
        <form action="{{ route('services.update', ':id') }}" method="POST" id="edit-service-form">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="edit-service-title" class="block text-sm font-medium text-gray-700">Service Title</label>
                <input type="text" id="edit-service-title" name="title" class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600">
            </div>
            <div class="mb-4">
                <label for="edit-service-category" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" id="edit-service-category" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="technician_id" value="{{ Auth::id() }}">
            <div class="flex justify-end space-x-2">
                <button type="button" class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2" data-modal-toggle="edit-service-modal">Cancel</button>
                <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-4 py-2">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Service Modal -->
<div id="delete-service-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative bg-white rounded-lg shadow-lg w-96 p-6">
        <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" data-modal-toggle="delete-service-modal">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 6L14 14M6 14L14 6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
        </button>
        <h3 class="text-xl font-semibold mb-4">Delete Service</h3>
        <p>Are you sure you want to delete this service?</p>
        <form action="{{ route('services.destroy', ':id') }}" method="POST" id="delete-service-form">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-2">
                <button type="button" class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2" data-modal-toggle="delete-service-modal">Cancel</button>
                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-200 font-medium rounded-lg text-sm px-4 py-2">Delete</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for Modals -->
<script>
    // Open Add Service Modal
    document.getElementById('open-modal-button').addEventListener('click', () => {
        document.getElementById('add-service-modal').classList.remove('hidden');
    });

    // Close Modals
    document.querySelectorAll('[data-modal-toggle]').forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-modal-toggle');
            document.getElementById(modalId).classList.add('hidden');
        });
    });


 // Gestion de la modal d'édition
document.querySelectorAll('.edit-service-btn').forEach(button => {
    button.addEventListener('click', () => {
        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        const categoryId = button.getAttribute('data-category_id');

        // Remplir les champs du formulaire
        document.getElementById('edit-service-title').value = title;
        document.getElementById('edit-service-category').value = categoryId;

        // Mettre à jour l'URL du formulaire
        const form = document.getElementById('edit-service-form');
        form.action = form.action.replace(':id', id);

        // Afficher la modal
        document.getElementById('edit-service-modal').classList.remove('hidden');
    });
});

    // Delete Service Modal
    document.querySelectorAll('.delete-service-btn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');

            const form = document.getElementById('delete-service-form');
            form.action = form.action.replace(':id', id);

            document.getElementById('delete-service-modal').classList.remove('hidden');
        });
    });
</script>

@endsection