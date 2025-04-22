@extends('layouts.app')

@section('title', 'liste Messages')

@section('content')

<section class="py-5">
    <div class="container mx-auto px-4 py-5">
  
      <div class="flex flex-wrap -mx-4">
  
        <div class="w-full md:w-1/2 lg:w-5/12 xl:w-1/3 px-4 mb-4 md:mb-0">
  
          <h5 class="font-bold mb-3 text-center lg:text-left">Member</h5>
  
          <div class="card bg-white rounded-lg shadow">
            <div class="card-body p-0">
  
              <ul class="list-none m-0">
                <li class="p-2 border-b bg-gray-100">
                  <a href="#!" class="flex justify-between">
                    <div class="flex">
                      <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-8.webp" alt="avatar"
                        class="rounded-full self-center me-3 shadow-md" width="60">
                      <div class="pt-1">
                        <p class="font-bold mb-0">John Doe</p>
                        <p class="text-sm text-gray-500">Hello, Are you there?</p>
                      </div>
                    </div>
                    <div class="pt-1">
                      <p class="text-sm text-gray-500 mb-1">Just now</p>
                      <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 float-right">1</span>
                    </div>
                  </a>
                </li>
                <li class="p-2 border-b">
                  <a href="#!" class="flex justify-between">
                    <div class="flex">
                      <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-1.webp" alt="avatar"
                        class="rounded-full self-center me-3 shadow-md" width="60">
                      <div class="pt-1">
                        <p class="font-bold mb-0">Danny Smith</p>
                        <p class="text-sm text-gray-500">Lorem ipsum dolor sit.</p>
                      </div>
                    </div>
                    <div class="pt-1">
                      <p class="text-sm text-gray-500 mb-1">5 mins ago</p>
                    </div>
                  </a>
                </li>
                <li class="p-2 border-b">
                  <a href="#!" class="flex justify-between">
                    <div class="flex">
                      <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-2.webp" alt="avatar"
                        class="rounded-full self-center me-3 shadow-md" width="60">
                      <div class="pt-1">
                        <p class="font-bold mb-0">Alex Steward</p>
                        <p class="text-sm text-gray-500">Lorem ipsum dolor sit.</p>
                      </div>
                    </div>
                    <div class="pt-1">
                      <p class="text-sm text-gray-500 mb-1">Yesterday</p>
                    </div>
                  </a>
                </li>
                <li class="p-2 border-b">
                  <a href="#!" class="flex justify-between">
                    <div class="flex">
                      <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-3.webp" alt="avatar"
                        class="rounded-full self-center me-3 shadow-md" width="60">
                      <div class="pt-1">
                        <p class="font-bold mb-0">Ashley Olsen</p>
                        <p class="text-sm text-gray-500">Lorem ipsum dolor sit.</p>
                      </div>
                    </div>
                    <div class="pt-1">
                      <p class="text-sm text-gray-500 mb-1">Yesterday</p>
                    </div>
                  </a>
                </li>
                <li class="p-2 border-b">
                  <a href="#!" class="flex justify-between">
                    <div class="flex">
                      <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-4.webp" alt="avatar"
                        class="rounded-full self-center me-3 shadow-md" width="60">
                      <div class="pt-1">
                        <p class="font-bold mb-0">Kate Moss</p>
                        <p class="text-sm text-gray-500">Lorem ipsum dolor sit.</p>
                      </div>
                    </div>
                    <div class="pt-1">
                      <p class="text-sm text-gray-500 mb-1">Yesterday</p>
                    </div>
                  </a>
                </li>
                <li class="p-2 border-b">
                  <a href="#!" class="flex justify-between">
                    <div class="flex">
                      <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-5.webp" alt="avatar"
                        class="rounded-full self-center me-3 shadow-md" width="60">
                      <div class="pt-1">
                        <p class="font-bold mb-0">Lara Croft</p>
                        <p class="text-sm text-gray-500">Lorem ipsum dolor sit.</p>
                      </div>
                    </div>
                    <div class="pt-1">
                      <p class="text-sm text-gray-500 mb-1">Yesterday</p>
                    </div>
                  </a>
                </li>
                <li class="p-2">
                  <a href="#!" class="flex justify-between">
                    <div class="flex">
                      <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
                        class="rounded-full self-center me-3 shadow-md" width="60">
                      <div class="pt-1">
                        <p class="font-bold mb-0">Brad Pitt</p>
                        <p class="text-sm text-gray-500">Lorem ipsum dolor sit.</p>
                      </div>
                    </div>
                    <div class="pt-1">
                      <p class="text-sm text-gray-500 mb-1">5 mins ago</p>
                      <span class="text-gray-500 float-right"><i class="fas fa-check" aria-hidden="true"></i></span>
                    </div>
                  </a>
                </li>
              </ul>
  
            </div>
          </div>
  
        </div>
  
        <div class="w-full md:w-1/2 lg:w-7/12 xl:w-2/3 px-4">
  
          <ul class="list-none">
            <li class="flex justify-between mb-4">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
                class="rounded-full self-start me-3 shadow-md" width="60">
              <div class="card bg-white rounded-lg shadow flex-1">
                <div class="card-header flex justify-between p-3 border-b">
                  <p class="font-bold mb-0">Brad Pitt</p>
                  <p class="text-gray-500 text-sm mb-0"><i class="far fa-clock"></i> 12 mins ago</p>
                </div>
                <div class="card-body p-3">
                  <p class="mb-0">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore et dolore magna aliqua.
                  </p>
                </div>
              </div>
            </li>
            <li class="flex justify-between mb-4">
              <div class="card bg-white rounded-lg shadow w-full">
                <div class="card-header flex justify-between p-3 border-b">
                  <p class="font-bold mb-0">Lara Croft</p>
                  <p class="text-gray-500 text-sm mb-0"><i class="far fa-clock"></i> 13 mins ago</p>
                </div>
                <div class="card-body p-3">
                  <p class="mb-0">
                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                    laudantium.
                  </p>
                </div>
              </div>
              <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-5.webp" alt="avatar"
                class="rounded-full self-start ms-3 shadow-md" width="60">
            </li>
            <li class="flex justify-between mb-4">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
                class="rounded-full self-start me-3 shadow-md" width="60">
              <div class="card bg-white rounded-lg shadow flex-1">
                <div class="card-header flex justify-between p-3 border-b">
                  <p class="font-bold mb-0">Brad Pitt</p>
                  <p class="text-gray-500 text-sm mb-0"><i class="far fa-clock"></i> 10 mins ago</p>
                </div>
                <div class="card-body p-3">
                  <p class="mb-0">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore et dolore magna aliqua.
                  </p>
                </div>
              </div>
            </li>
            <li class="bg-white mb-3">
              <div class="relative">
                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" id="textAreaExample2" rows="4"></textarea>
                <label class="absolute left-3 -top-2.5 bg-white px-1 text-gray-500 text-sm transition-all peer-focus:text-blue-500" for="textAreaExample2">Message</label>
              </div>
            </li>
            <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-full float-right transition duration-300">Send</button>
          </ul>
  
        </div>
  
      </div>
  
    </div>
</section>


@endsection