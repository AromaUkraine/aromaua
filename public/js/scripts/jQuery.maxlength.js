

(function($){

    $.fn.maxlength = function (options){
        let settings = $.extend(
            {},
            $.fn.maxlength.defaults,
            options
        );

        const counterElm =`
           <span class="text-limit">
            <small data-val-length="target"></small>/<small data-val-length="max"></small>
           </span>
           `;

        return this.each(function () {
            var $wrap = $(this);
            var $val = $wrap.find(settings.valName);
            var $parent = $wrap.find(settings.parent);
            var maxLength = $val.attr('maxlength') || '255';

            if (!$wrap.find('.text-limit').length) {
                var val = $val.val() || '';
                $parent.length ? $parent.append(counterElm) : $wrap.append(counterElm);
                $wrap.find(settings.target).html(val.length);
                $wrap.find(settings.maxTarget).html(maxLength);

                $wrap.on('change paste keyup input', settings.valName, function (e) {
                    var input = e.currentTarget;
                    var val = input.value;
                    if (val.length > maxLength) input.value = val.substr(0, maxLength);
                    $wrap.find(settings.target).html(input.value.length);
                });
            }
        });
    };

    $.fn.maxlength.defaults = {
        valName: '[maxlength]',
        target: '[data-val-length=target]',
        maxTarget: '[data-val-length=max]',
        parent: '[data-val-length=parent]',
    };
})(jQuery);

$('.maxlength').maxlength();
