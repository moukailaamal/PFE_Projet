{{-- resources/views/layouts/defaults/single.blade.php --}}
@extends('layouts.app')  <!-- Assurez-vous d'avoir un layout principal -->

@section('content')
  <header class="py-5 border-bottom">
    <div class="container pt-md-1 pb-md-4">

      <h1 class="bd-title mt-0">{{ $title }}</h1>  
      <p class="bd-lead">{{ $description }}</p>  <!-- Remplace .Page.Params.Description -->
      
      @if ($title == 'Examples') 
        <div class="d-flex flex-column flex-sm-row">
          <a href="{{ $downloadLink }}" class="btn btn-lg btn-bd-primary" onclick="ga('send', 'event', 'Examples', 'Hero', 'Download Examples');">
            Download examples
          </a>
        </div>
      @endif
    </div>
  </header>

  <main class="bd-content order-1 py-5" id="content">
    <div class="container">
      {!! $content !!}  <!-- Utilise {!! !!} pour afficher du contenu HTML brut -->
    </div>
  </main>
@endsection
