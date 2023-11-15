<div class="header__main header-main">
    <div class="header-main__container">
        <x-site-logo
            key="{{'logo-main'}}"
            options="{!! json_encode([
                'class'=>'header__logo',
                'image_class'=>'header__logo-img'
                ]) !!}"
        ></x-site-logo>
        <button class="hamburger" id="js-hamburger" type="button">
            <span class="hamburger__line"></span>
        </button>

        <x-menu-main key="{{'main-menu'}}" :page=$page></x-menu-main>

    </div>
</div>
