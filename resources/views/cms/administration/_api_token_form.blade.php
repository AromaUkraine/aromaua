
<div class='container'>
    <label class="notice"> Тут Вы можете сгенерировать api-токен для доступа по api </label>
</div>

<div class='container'>
    <x-input
        id="token_id"
        name="token_id"
        label="Token ID"
        options="{!! json_encode(['hint'=>'Api токен сгенерирован.']) !!}"
    >
    </x-input>
</div>

<div class='container'>
    <x-textarea
    id="token"
    name="token"
    label="{{__('cms.api_token')}}"
    options="{!! json_encode(['hint'=>'Обязательно скопируйте токен. В дальнейшем получить его снова будет невозможно!']) !!}"
    value="sdsad asdasdasdasdasd sdsadsa"
    >
    </x-textarea>
    <span class=" bg-success text-white p-1 copied" style="display: block"> Токен скопирован в буфер обмена</span>
</div>



@section('form-buttons')
    <x-button
        type="button"
        class="primary generate hidden text-capitalize mr-1"
        title="{{__('cms.buttons.generate')}}"
    ></x-button>
    <x-button
        type="button"
        class="warning regenerate hidden text-capitalize mr-1"
        title="{{__('cms.buttons.generate')}}"
    ></x-button>
@overwrite


@push('scripts')
    <script>
        $(function(){
            let notice = $('.notice');
            let container = $('.container');
            let inputTokenId = $('#token_id');
            let textareaToken = $('#token');
            let generateBtn = $('.generate');
            let regenerateBtn = $('.regenerate');
            let copied = $('.copied');
            let tokenId, token;

            container.each((i, el) => $(el).hide());
            copied.hide();


            let checkTokenExist = function(){
                var data = {
                    url: '{{ route('admin.administration.api_token', $user->id) }}',
                    type:'POST',
                    dataType:'json',
                };
                $.sendAjax(data, function(response){
                    // токен уже был создан. Заполняем input tokenId и показываем кнопку для регенерации
                    if(typeof response.tokenId !== typeof undefined && response.tokenId ){
                        inputTokenId.val(response.tokenId);
                        inputTokenId.closest('.container').show();
                        regenerateBtn.removeClass('hidden');
                    }else{
                        notice.closest('.container').show();
                        generateBtn.removeClass('hidden');
                    }

                })
            }

            // генерация api-токена
            generateBtn.click(function() {

                var data = {
                    url: '{{ route('admin.administration.api_token', $user->id) }}',
                    type:'POST',
                    dataType:'json',
                    data:{generate:1}
                };
                $.sendAjax(data, function(response){
                    // токен успешно был создан. Заполняем textarea token и показываем
                    if(typeof response.token !== typeof undefined && response.token ){
                        notice.closest('.container').hide();
                        generateBtn.addClass('hidden');
                        textareaToken.val(response.token);
                        textareaToken.closest('.container').show();
                    }
                })
            })

            // Копирование токена в буфер обмена
            textareaToken.click(function(){
                this.select();
                this.setSelectionRange(0, 99999); /* For mobile devices */
                document.execCommand("copy");
                copied.fadeToggle('slow', 'linear', function(){
                    setTimeout(function(){
                        copied.fadeToggle('slow', 'linear')
                    }, 1000)
                });
            });

            // Генерация нового токена
            regenerateBtn.click(function() {
                var data = {
                    title: "Создание нового токена API",
                    message: "Внимание после генерации нового токена, доступ к API с использованием старого токена станет недоступно!",
                    confirmButtonText: "{{ __('cms.buttons.create') }}",
                    cancelButtonText: "{{ __('cms.buttons.cancel') }}",
                }
                $.confirm(data, function (res) {
                    if (res) {
                        var data = {
                            url: '{{ route('admin.administration.api_token', $user->id) }}',
                            type:'POST',
                            dataType:'json',
                            data:{regenerate:1}
                        };
                        $.sendAjax(data, function(response){
                            // токен успешно был перегенерирован. Заполняем textarea token и показываем
                            if(typeof response.token !== typeof undefined && response.token ){
                                inputTokenId.closest('.container').hide();
                                regenerateBtn.addClass('hidden');
                                textareaToken.val(response.token);
                                textareaToken.closest('.container').show();
                            }
                        });
                    }
                })

            })

            checkTokenExist();
        })
    </script>
@endpush
