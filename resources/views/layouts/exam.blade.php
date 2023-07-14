<!DOCTYPE html>
<html lang="en">
<head>
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    <meta charset="utf-8"/>
    <title>Exam | {{ env('APP_NAME') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon"/>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
    type="text/css"/>
    
    <link href="{{ mix('/css/exam.css') }}" rel="stylesheet" type="text/css">

    @yield('exam-style')

    @if(config('pi-academy.ads_on') == 1)
        @if (Route::currentRouteName() == 'exam.home' ||
            Route::currentRouteName() == 'exam.before-exam' ||
            Route::currentRouteName() == 'exam.check'
        )
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <script>
               (adsbygoogle = window.adsbygoogle || []).push({
                    google_ad_client: "ca-pub-2766564597649639",
                    enable_page_level_ads: true
               });
          </script>
        @endif
    @endif

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137445489-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

    gtag('config', 'UA-137445489-1');
    </script>

</head>

<body>
    <div class="container">
        @include('exam.partials.header')
        
        <div class="main-section">
            @yield('content')
        </div>

        @include('exam.partials.footer')
        
    </div>

    <script src="{{ mix('/js/exam.js') }}"></script>

    @yield('exam-script')

    <script>
        $(document).ready(function(){
            @if(Session::has('message'))
                var type = "{{ Session::get('alert-type', 'info') }}";
                switch(type){
                    case 'success':
                        toastr.success("{{ Session::get('message') }}");
                        break;
                        
                    case 'info':
                        toastr.info("{{ Session::get('message') }}");
                        break;

                    case 'warning':
                        toastr.warning("{{ Session::get('message') }}");
                        break;

                    case 'error':
                        toastr.error("{{ Session::get('message') }}");
                        break;
                }
            @endif
        });
    </script>

    <script type="text/x-mathjax-config">
      MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
    </script>

    <script type="text/javascript" async src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-64114198-1', 'auto');
        ga('send', 'pageview');
    </script>

</body>
</html>
