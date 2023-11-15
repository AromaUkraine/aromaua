<div class="row justify-content-end">
    <div class="col-sm-12 col-md-6 ">
        <div class="text-right">
            <button class="advanced-filter-toggle btn  btn-outline-primary btn-sm">
               {{__('cms.advanced-filter')}}
            </button>
       </div>
    </div>
</div>

<div class="advanced-filter d-none d-md-block ">
    <div class="advanced-filter-content p-2 ps ps--active-y">
        <h4 class="text-uppercase mb-0">{{__('cms.advanced-filter')}}</h4>
        <a href="javascript:void(0)" class="advanced-filter-close">
            <i class="bx bx-x"></i>
        </a>
        <hr>
        <x-form options="{!! json_encode($options) !!}">
            {{ $slot }}
            <div class="d-flex flex-row-reverse">
                <x-action
                    href="#"
                    class="light btn-sm text-capitalize reset"
                    title="{{__('cms.reset')}}"
                ></x-action>
                <x-action
                    href="#"
                    class="primary btn-sm text-capitalize mr-1 apply"
                    title="{{__('cms.to_apply')}}"
                ></x-action>
            </div>
        </x-form>
    </div>
</div>

@push('scripts')
    <script>
        $(document).mouseup(function (e) {
            var container = $(".advanced-filter");
            if( container.has(e.target).length === 0 && container.hasClass('open') ){
                // доп. условие для select2
                if($(e.target).attr('role') !== 'option'){
                    container.removeClass('open');
                }
            }
        });
        $(document).ready(function(){
            clearForm();
        })
        let form = $('.form-filter');
        let checkbox = $('input.custom-control-input',form);


        $('.apply').on('click', function (e){
            e.preventDefault();
            console.log(findGetParameter(form.attr('action')));
            $('.table').DataTable().ajax.url(findGetParameter(form.attr('action'))).draw();
        })
        $('.reset').on('click', function (e){
            e.preventDefault();
            clearForm();
            $('.table').DataTable().ajax.url(findGetParameter(form.attr('action'), true)).draw();
        })

        function findGetParameter(url, reset = false) {
            let queryString = window.location.search;
            let formData = getFormData();

            if(reset)
                return queryString;

            if(!queryString) {
                queryString = '?' + formData;
            }else{
                queryString += '&' + formData;
            }
            return queryString;
        }

        function getFormData(){
            return $(":input", form)
                .filter(function(index, element) {
                    return $(element).val() !== '';
                })
                .serialize();
        }

        checkbox.on('change', (e) =>  e.target.value = e.target.checked ? 1 : 0 );

        function clearForm(){
            $(':input',form).not(':button, :submit, :reset, :hidden').val('');
            $("select", form).val('').trigger('change');
            checkbox.prop('checked', false).val(0);
        }
    </script>
@endpush
