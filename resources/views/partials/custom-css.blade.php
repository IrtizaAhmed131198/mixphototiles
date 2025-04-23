@foreach ($custom_color as $key => $val)
    @php
        $cssClassName = strtolower(str_replace(' ', '-', $val->name));
    @endphp

    <style>
        .box-shadow-{{ $cssClassName }}::before {
            position: absolute;
            z-index: -1;
            content: "";
            right: -8px;
            top: 4px;
            bottom: 0;
            height: 100%;
            width: 8px;
            background: {{ $val->before_color_code }};
            transform: skewY(45deg);
        }

        .box-shadow-{{ $cssClassName }}::after {
            position: absolute;
            z-index: -1;
            content: "";
            background: {{ $val->after_color_code }};
            width: 100%;
            height: 8px;
            bottom: -8px;
            transform: skewX(45deg);
            left: 5px;
        }
    </style>

    <li type="button"
        class="parentProperties dropdown-item frame-color {{ $key == 0 ? 'li-border-color' : '' }}"
        data-price="{{ $val->price }}"
        data-color="{{ $val->name }}"
        data-src="{{ $val->frame_img }}"
        data-shadow="box-shadow-{{ $cssClassName }}">
        <figure class="PropertiesleftChild">
            <img alt="drawer" width="72" height="72" class="LeftSidebar"
                src="{{ asset($val->option_img) }}">
        </figure>
        <div class="PropertiesRightChild">
            <p class="propertyName">{{ $val->name }}</p>
            <p class="propertyPrize" style="display: none">${{ $val->price }}</p>
        </div>
    </li>
@endforeach
