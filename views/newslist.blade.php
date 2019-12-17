@extends('layout')

@section('pagebody')
    <div class="container">
        <div class="page-title">
            {{ $documentObject['pagetitle'] }}
        </div>

        @run('DocLister', [
            'id'              => 'list',
            'parents'         => $modx->documentIdentifier,
            'tpl'             => '@B_FILE:partials/news_item',
            'ownerTPL'        => '@B_FILE:partials/news_wrap',
            'tvList'          => 'image',
            'tvPrefix'        => '',
            'display'         => 4,
            'paginate'        => 'pages',
            'orderBy'         => 'pub_date DESC',
            'TplNextP'        => '@CODE: <a href="[+link+]"><i class="icon-right"></i></a>',
            'TplPrevP'        => '@CODE: <a href="[+link+]"><i class="icon-left"></i></a>',
            'TplPage'         => '@CODE: <a href="[+link+]">[+num+]</a>',
            'TplCurrentPage'  => '@CODE: <span class="current">[+num+]</span>',
            'TplWrapPaginate' => '@CODE: <div class="pagination">[+wrap+]</div>',
        ], 2592000)
    </div>
@endsection
