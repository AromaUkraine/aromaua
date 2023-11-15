<div class="footer__main">
    <div class="footer__main-container">
        <x-site-logo
            key="{{'logo-footer'}}"
            options="{!! json_encode([
                'class'=>'footer__logo',
                'image_class'=>'footer__logo-img'
                ]) !!}"
        ></x-site-logo>

        <div class="footer__row">
            <div class="footer__col">
                <x-contact-footer></x-contact-footer>
            </div>

            <x-menu-footer key="{{'footer-menu'}}"></x-menu-footer>

        </div>
        <p class="footer__copyright">{{app()->settings->key('copyright')->value ?? ''}} {{\Carbon\Carbon::now()->format('Y')}} ©</p>
    </div>
</div>
