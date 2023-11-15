<ul class="nav nav-tabs nav-language" role="tablist">
    @foreach($languages as $lang)
        <li class="nav-item" role="presentation">
            <a class="btn btn-outline-primary text-capitalize @if($lang->short_code == $default_language) active current @endif"
               @if($lang->short_code !== $default_language &&  (!$model || !$model->hasTranslation($lang->short_code)) )
               style="display: none"
               @endif
               data-lang="{{ $lang->short_code }}"
               aria-controls="{{ $lang->short_code }}"
               data-toggle="tab"
               role="tab"
               aria-selected="true">
                <i class="flag-icon flag-icon-{{$lang->icon}} mr-50"></i>
                <span class="align-middle">{{ $lang->name }}</span>
            </a>
        </li>
    @endforeach
</ul>

<div class="row px-2 pb-2">
    <div >
         @if($languages->count() > 1)
            <label for="#" class="mr-2">{{__('cms.language_versions')}}</label>
            @foreach($languages as $lang)
                <div class="form-check form-check-inline enable-lang" @if($lang->short_code == $default_language) style="display: none" @endif>
                    @if($model && $model->hasTranslation($lang->short_code) || $lang->short_code == $default_language)
                        <x-tab-checkbox name="{{$lang->short_code}}" :lang="$lang->short_code" label="{{$lang->name}}" group="enable" checked  />
                    @else
                        <x-tab-checkbox name="{{$lang->short_code}}" :lang="$lang->short_code" label="{{$lang->name}}" group="enable" />
                    @endif
                </div>
            @endforeach
        @endif
    </div>
    @isset($language_switcher)
        <div class="ml-auto">{{ $language_switcher }}</div>
    @endisset
</div>

{{ $slot }}


@push('scripts')
    <script>

        $(document).ready(function () {
            let navigationItems = $('.nav-language li');
            let hasLanguageFormItems = $('.form-group.lang');
            let checkboxes = $(".enable-lang input[type='checkbox']");
            let currentLanguage;

            // если валидация формы вернула ошибку
            if (hasErrors()) {

                $('.is-invalid', hasLanguageFormItems).map((k, elem) => {

                    let lang = $(elem).parent().attr('data-lang');

                    if (k === 0) {
                        currentLanguage = lang;
                        let tab = findNavigationItem(lang);
                        tab.tab('show');
                        toggleLanguageFormItems(lang);
                    }
                    //включаем чекбоксы
                    setCheckedCheckbox(lang);

                    // показываем таб с ошибкой
                    let nav = findNavigationItem(lang);

                    nav.removeClass('btn-outline-primary');
                    nav.addClass('btn-outline-danger');

                    if (nav.is(":hidden")) {
                        nav.show();
                    }
                });
            }


            function setCheckedCheckbox(lang) {
                checkboxes.map((k, item) => {
                    if ($(item).attr('data-lang') === lang && !$(item).is(':checked')) {
                        $(item).prop("checked", true);
                    }
                })
            }

            // событие изминения состояния чекбокса
            checkboxes.map((k, item) => {

                $(item).on('change', function () {
                    if (!$(this).is(':checked')) {

                        // переключение на другой таб если выбранный выключается
                        if ($(this).attr('data-lang') === currentLanguage) {
                            setNewActiveNavigationItem();
                        }
                    }

                    toggleNavigationItem($(this).attr('data-lang'))
                })
            })

            function setNewActiveNavigationItem() {

                let checked = false;
                checkboxes.toArray().reverse().map( (item) => {

                    if ($(item).is(':checked') && !checked) {
                        checked = true;
                        //устанавливаем текущий язык
                        currentLanguage = $(item).attr('data-lang');
                        // смена активного таба
                        let tab = findNavigationItem(currentLanguage);
                        tab.tab('show');
                        // смена полей форм
                        toggleLanguageFormItems(currentLanguage);
                    }
                })
            }

            // переключение табов по клику, устанавливаем текущий язык
            navigationItems.click(function () {
                currentLanguage = $(this).children().attr('data-lang');
                toggleLanguageFormItems(currentLanguage);
            })


            // прячем - показываем поля взависимости переданного языка
            function toggleLanguageFormItems(lang) {
                hasLanguageFormItems.map((k, item) => ($(item).attr('data-lang') === lang) ? $(item).show() : $(item).hide());
            }

            // показываем - прячем таб
            function toggleNavigationItem(lang) {
                let item = findNavigationItem(lang);
                item.toggle()
            }

            // поиск таба по языку
            function findNavigationItem(lang) {
                return navigationItems.find('a[data-lang="'+lang+'"]');
            }

            // наличие ошибок в форме
            function hasErrors() {
                return ($(hasLanguageFormItems).find('.is-invalid').length > 0);
            }
        })

    </script>
@endpush




