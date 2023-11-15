<div class="footer__contacts">
    <div class="footer__item">{!! $getValue('company-name') !!}</div>
    <div class="footer__item">Tel:&nbsp;<a class="footer__link" href="{{ $getLink('phone') }}">{{ $getValue('phone') }}</a> {{ $getValue('phone-description') }}</div>
    <div class="footer__item">E-mail:&nbsp;<a class="footer__link" href="mailto:{{$getValue('email')}}" target="_blank" >{{ $getValue('email') }}</a>
    </div>
    <div class="footer__item">{{__('web.address')}}:&nbsp;
        <address>{!!  $getValue('address') !!} </address>
    </div>
</div>
