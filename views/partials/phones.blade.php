@foreach (array_map('trim', explode("\n", $modx->getConfig('client_company_phone'))) as $phone)
    <span class="tapable-phone" data-phone="{{ '+' . preg_replace('/^8/', '7', preg_replace('/[^\d]+/', '', $phone)) }}">{{ $phone }}</span><br>
@endforeach
