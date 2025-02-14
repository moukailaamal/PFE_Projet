<!doctype html>
<html lang="en">
  <head>
    @include('layouts.partials.header')  <!-- Inclure l'en-tête -->
  </head>
  
  @section('body_override')
    <body class="{{ request()->is('some-white-page') ? 'bg-white' : 'bg-gray-50' }}">
  @show

      <!-- Google Tag Manager (noscript) -->
      <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-THQTXJ7"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
      </noscript>
      <!-- End Google Tag Manager (noscript) -->

    @include('layouts.partials.skippy')  <!-- Inclure un fichier pour des liens ou autres éléments -->

    @section('main')  <!-- Définir le contenu principal de la page -->
    @show

    @include('layouts.partials.scripts')  <!-- Inclure les scripts -->
  </body>
</html>
