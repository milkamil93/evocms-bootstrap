<!DOCTYPE html>
<html lang="ru">
<head>
    <title>@runescaped('bootstrap#metatitle')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <base href="@config('base_url')">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    @run('bootstrap#metaheaders')
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.4/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.2/jquery.fancybox.min.css">
    <link rel="stylesheet" type="text/css" href="@config('base_url')assets/templates/default/css/style.css">
    @config('client_head_scripts', false)
</head>

<body class="@runescaped('bootstrap#template')">
    @config('client_body_start_scripts', false)
    <div class="wrap">
        <div class="head-placeholder">
            <div class="head">
                <div class="container">
                    <div class="pull-xs-left">
                        <div class="logo">
                            <a href="@config('base_url')">
                                <img src="@config('client_company_logo', true)" class="img-fluid" alt="@config('site_name', true)">
                            </a>
                        </div>

                        <div class="pull-xs-left show-on-top hidden-md-down text">
                            {!! nl2br($modx->getConfig('client_head_text')) !!}
                        </div>
                    </div>

                    <div class="pull-xs-right text-xs-right">
                        <div class="wi-group phone">
                            <i class="icon-phone"></i>
                            @include('partials.phones')
                        </div>

                        <a href="#" data-toggle="modal" data-target="#callback" class="btn btn-hollow-theme callback">Заказать звонок</a>
                    </div>
                </div>
            </div>

            <div class="head-menu">
                <div class="container">
                    <div class="menu">
                        @run('DLMenu', [
                            'parents'  => 1,
                            'maxDepth' => 2,
                        ])
                    </div>
                </div>
            </div>
        </div>

        @yield('pagebody')
    </div>

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="copy">
                        © {{ date('Y') }} Все права защищены.
                    </div>

                    <div class="socials">
                        @foreach ($modx->runSnippet('bootstrap#socials') as $social)
                            <a href="{{ $social['url'] }}" target="_blank" rel="nofollow" title="{{ $social['title'] }}" class="icon-social-{{ $social['code'] }}"></a>
                        @endforeach
                    </div>
                </div>

                <div class="col-sm-9">
                    <div class="row">
                        <div class="bottom-menu">
                            @run('DLMenu', [
                                'parents'  => 1,
                                'maxDepth' => 2,
                            ])
                        </div>

                        <div class="wi-group phone">
                            <i class="icon-phone"></i>
                            @include('partials.phones')
                            <a href="#" class="callback" data-toggle="modal" data-target="#callback">Заказать звонок</a>
                        </div>

                        <div class="wi-group">
                            <i class="icon-location"></i>
                            @config('client_company_address')
                        </div>

                        <div class="wi-group">
                            <a href="mailto:@config('client_company_email')">
                                <i class="icon-email"></i>
                                @config('client_company_email')
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="policy text-xs-center">
                <a href="@config('client_policy')">Политика конфиденциальности</a>
            </div>
        </div>
    </div>

    <div class="popups">
        @include('partials.forms.callback')
        <div class="modal fade" tabindex="-1" role="dialog" id="response">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="modal-body">
                        <div class="response"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.4/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.2/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>
    <script type="text/javascript" src="@config('base_url')assets/templates/default/js/jquery.maskedinput.min.js"></script>
    @stack('footer_scripts')
    <script type="text/javascript" src="@config('base_url')assets/templates/default/js/common.js"></script>
    @config('client_body_end_scripts')
</body>
</html>
