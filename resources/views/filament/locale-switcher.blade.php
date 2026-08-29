@php
    $nextLocale = app()->getLocale() === 'ar' ? 'en' : 'ar';
@endphp

<x-filament::link
    tag="a"
    :href="route('locale.switch', $nextLocale)"
    color="gray"
    icon="heroicon-o-language"
>
    {{ config('app.available_locales.'.$nextLocale) }}
</x-filament::link>
