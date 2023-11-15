import lang from '../../../../lang/lang'

export default function (message, props={}) {
    console.log(lang(message, props));
    return lang(message, props);
}
