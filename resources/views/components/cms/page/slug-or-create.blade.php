@if($languages)
    @foreach($languages as $lang)
        <div
            class="form-group lang"
            @if($lang->short_code !== $default_language) style="display: none" @endif
            data-lang="{{$lang->short_code}}"
        >
            <label for="" class="pb-1">{{__('cms.add_link_to_page')}}</label>
            <ul class="nav nav-tabs nav-justified " role="tablist">
                <li class="nav-item" >
                    <a class="nav-link slug active "
                       data-toggle="tab"
                       href="#exist-page-{{$lang->short_code}}-just"
                       role="tab"
                       aria-controls="exist-page-just"
                       aria-selected="true">
                        {{__('cms.use_exist_page')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link slug"
                       data-toggle="tab"
                       href="#create-{{$lang->short_code}}-just"
                       role="tab"
                       aria-controls="create-just"
                       aria-selected="false">
                        {{__('cms.create_link')}}
                    </a>
                </li>
            </ul>

            <div class="tab-content pl-0 ">
                <div class="tab-pane active"
                     id="exist-page-{{$lang->short_code}}-just"
                     role="tabpanel"
                     aria-labelledby="exist-page-tab-justified">

                    <select
                        id="{{ ($options['id']) ??  $lang->short_code.".".$name }}"
                        name="{{ $lang->short_code."[select_slug]" }}"
                        class="form-control select2 @error( $lang->short_code.".".$name ) is-invalid @enderror "
                        placeholder="{{ __('cms.select.default') }}"
                    >
                        <option value=""></option>
                        @foreach($getPages($lang->short_code) as $page)
                            <option value="{{$page->slug}}"> {{$page->name}} </option>
                        @endforeach
                    </select>

                </div>
                <div class="tab-pane"
                     id="create-{{$lang->short_code}}-just"
                     role="tabpanel"
                     aria-labelledby="create-tab-justified">

                    <input type="text"
                           class="form-control {{ $options['class'] ?? '' }} @error( $lang->short_code.".".$name ) is-invalid @enderror "
                           id="{{ $setId($lang->short_code) }}"
                           name="{{ $lang->short_code."[input_slug]" }}"
                           value="{{ $setValue($lang->short_code) }}"
                           @isset($options['placeholder']) placeholder="{{ \StringHelper::upper($options['placeholder']) }}"
                           @endisset
                           @isset($options['maxlength']) maxlength="{{$options['maxlength']}}" @endisset
                           @isset($options['autocomplete']) autocomplete="{{$options['autocomplete']}}" @endisset
                           @isset($options['required']) @if($options['required']) required @endif @endisset
                           @isset($options['readonly']) @if($options['readonly']) readonly @endif @endisset
                           @isset($options['disabled']) @if($options['disabled']) disabled @endif @endisset
                    >
                    <div class="col-10 float-left pl-0">
                        <small
                            class="text-muted">{!! $options['hint'] ?? __('ссылка должна иметь вид http://example.com') !!}</small>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@else

@endif

