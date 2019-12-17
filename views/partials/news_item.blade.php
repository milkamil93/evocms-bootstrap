<li>
    <div class="news-item">
        <a href="{{ $data['url'] }}" class="image">
            <span style="background-image: url('@runescaped('phpthumb', ['input' => $data['image'], 'options' => 'w=635,h=355,zc=1,f=jpg'], 86400)');"></span>
        </a>

        <div class="date">
            @run('bootstrap#formatdate', ['date' => $data['pub_date']], 86400)
        </div>

        <div class="title">
            <a href="{{ $data['url'] }}">{{ $data['pagetitle'] }}</a>
        </div>

        {{ $data['introtext'] }}

        <div class="further">
            <a href="{{ $data['url'] }}">Читать далее<i class="icon-right"></i></a>
        </div>
    </div>
