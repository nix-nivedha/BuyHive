{!! view_render_event('bagisto.shop.layout.features.before') !!}

<!--
    The ThemeCustomizationRepository repository is injected directly here because there is no way
    to retrieve it from the view composer, as this is an anonymous component.
-->
@inject('themeCustomizationRepository', 'Webkul\Theme\Repositories\ThemeCustomizationRepository')

@php
    $channel = core()->getCurrentChannel();

    $customization = $themeCustomizationRepository->findOneWhere([
        'type'       => 'services_content',
        'status'     => 1,
        'theme_code' => $channel->theme,
        'channel_id' => $channel->id,
    ]);
@endphp

<!-- Features -->
@if (
    $customization &&
    isset($customization->options['services']) &&
    is_array($customization->options['services']) &&
    count($customization->options['services']) > 0
)
    <div class="container mt-20 max-lg:px-8 max-md:mt-10 max-md:px-4">
        <div class="max-md:max-y-0 flex justify-center gap-6 max-lg:flex-wrap max-md:grid max-md:grid-cols-2">
            @foreach ($customization->options['services'] as $service)
                <div class="flex items-center gap-5 bg-white max-md:grid max-md:gap-2.5 max-sm:gap-1">
                    <span
                        class="{{ $service['service_icon'] ?? '' }} flex items-center justify-center w-[60px]"
                        role="presentation"
                    ></span>

                    <div class="grid gap-1.5">
                        <p class="text-base font-medium">
                            {{ $service['title'] ?? '' }}
                        </p>

                        <p class="text-zinc-500">
                            {{ $service['description'] ?? '' }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

{!! view_render_event('bagisto.shop.layout.features.after') !!}