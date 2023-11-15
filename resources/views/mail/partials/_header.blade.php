<tr>
    <td class="header"
        style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; padding: 25px 0; text-align: center;">
        <a href="{{ config('app.url') }}"
            style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; color: #3d4852; font-size: 19px; font-weight: bold; text-decoration: none; display: inline-block;"
            target="_blank">
            @isset(app()->settings->getTranslateByKey('logo')->value)
            <img src="{{ config('app.url') }}/{{ app()->settings->getTranslateByKey('logo-main')->value ?? '' }}"
                style="width:100%;display:block" alt="{{ config('app.name') }}">
            @else
            <h3 style="width:100%;text-align:center;">{{ config('app.name') }}</h3>
            @endisset
        </a>
    </td>
</tr>
