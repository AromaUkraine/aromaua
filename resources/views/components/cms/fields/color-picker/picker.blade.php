<div
    class="form-group @isset($options['maxlength']) maxlength  @endisset pb-1 pr-1 mt-2">
    @if($label) <label for="{{ $setId() }}">{{$label}} @isset($options['required']) * @endisset </label> @endif
    <input type="text"
           class="form-control color-picker @error( $name ) is-invalid @enderror "
           id="{{ $setId() }}"
           name="{{ $setName() }}"
           value="{{ $getCode() }}"
    >
</div>

@push('scripts')

    <script type="text/javascript" src="{{ asset('js/scripts/tiny-color-picker/colors.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/scripts/tiny-color-picker/jqColorPicker.js') }}"></script>

    <script>
        $(function(){
            'use strict';
            let plugin = {}
            // shows input fields for rgb and hsv; changeable
            plugin.input = {
                customBG: '#222',
                margin: '4px -2px 0',
                doRender: 'div div',

                buildCallback: function($elm) {
                    var colorInstance = this.color,
                        colorPicker = this;

                    $elm.prepend('<div class="cp-panel">' +
                        'R <input type="text" class="cp-r" /><br>' +
                        'G <input type="text" class="cp-g" /><br>' +
                        'B <input type="text" class="cp-b" /><hr>' +
                        'H <input type="text" class="cp-h" /><br>' +
                        'S <input type="text" class="cp-s" /><br>' +
                        'B <input type="text" class="cp-v" /><hr>' +
                        '<input type="text" class="cp-HEX" />' +
                        '</div>').on('change', 'input', function(e) {
                        var value = this.value,
                            className = this.className,
                            type = className.split('-')[1],
                            color = {};

                        color[type] = value;
                        colorInstance.setColor(type === 'HEX' ? value : color,
                            type === 'HEX' ? 'HEX' : /(?:r|g|b)/.test(type) ? 'rgb' : 'hsv');
                        colorPicker.render();
                        this.blur();
                    });
                },

                cssAddon: // could also be in a css file instead
                    '.cp-color-picker{box-sizing:border-box; width:271px;}' +
                    '.cp-color-picker .cp-panel {line-height: 21px; float:right;' +
                    'padding:0 1px 0 8px; margin-top:-1px; overflow:visible}' +
                    '.cp-xy-slider:active {cursor:none;}' +
                    '.cp-panel{width:104px}, .cp-panel input {font-family:monospace,' +
                    '"Courier New",Courier,mono; font-size:12px; font-weight:bold;}' +
                    '.cp-panel input {width:46px; height:18px; padding:2px 3px 1px;' +
                    'text-align:right; line-height:12px; background:#fff;' +
                    'border:1px solid; border-color:#222 #666 #666 #222;}' +
                    '.cp-panel hr {margin:0 -2px 2px; height:1px; border:0;' +
                    'background:#666; border-top:1px solid #222;}' +
                    '.cp-panel .cp-HEX {width:100px; position:absolute; margin:1px -3px 0 -2px;}' +
                    '.cp-alpha {width:155px;}',

                renderCallback: function($elm, toggled) {
                    var colors = this.color.colors.RND,
                        modes = {
                            r: colors.rgb.r, g: colors.rgb.g, b: colors.rgb.b,
                            h: colors.hsv.h, s: colors.hsv.s, v: colors.hsv.v,
                            HEX: this.color.colors.HEX
                        };


                    $('input', '.cp-panel').each(function() {
                        this.value = modes[this.className.substr(3)];
                    });
                    // console.log($elm.css({color:'#'+this.color.colors.HEX}));
                }
            };
            window.myColorPicker = $('.color-picker').colorPicker(plugin['input'])
        });
    </script>
@endpush
