
import translate from '../../../../lang/lang';

let TranslateMixin =  {
    methods: {
        __t: function (key, replacements = null, locale = null) {
            return translate.get(key, replacements, locale);
        },
    },
}

export default TranslateMixin;
