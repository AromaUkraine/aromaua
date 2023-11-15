<?php

namespace App\Providers;



use App\View\Components\Cms\Advanced\Filter;
use App\View\Components\Cms\Buttons\Action;
use App\View\Components\Cms\Buttons\Button;
use App\View\Components\Cms\Card\Card;
use App\View\Components\Cms\DragAndDrop\DaDLeftRight;
use App\View\Components\Cms\Fields\Checkbox;
use App\View\Components\Cms\Fields\ColorPicker;
use App\View\Components\Cms\Fields\DatePicker;
use App\View\Components\Cms\Fields\DateTimeRangePicker;
use App\View\Components\Cms\Fields\Editor;
use App\View\Components\Cms\Fields\Gallery;
use App\View\Components\Cms\Fields\Image;
use App\View\Components\Cms\Fields\Input;
use App\View\Components\Cms\Fields\InputNumber;
use App\View\Components\Cms\Fields\Select;
use App\View\Components\Cms\Fields\SlugGenerator;
use App\View\Components\Cms\Fields\Switcher;
use App\View\Components\Cms\Fields\Textarea;
use App\View\Components\Cms\FileManager\FileManager;
use App\View\Components\Cms\Filter\FilterContainer;
use App\View\Components\Cms\Form\Form;

use App\View\Components\Cms\Menu\FrontendAddTree;
use App\View\Components\Cms\Menu\Menu;
use App\View\Components\Cms\Menu\MenuNestedTree;
use App\View\Components\Cms\Modal\Modal;
use App\View\Components\Cms\Nav\NavBrand;
use App\View\Components\Cms\Nav\NavEntity;
use App\View\Components\Cms\Nav\NavInnerEntity;
use App\View\Components\Cms\Nav\NavPage;
use App\View\Components\Cms\Page\Breadcrumbs;
use App\View\Components\Cms\Page\SlugOrCreate;
use App\View\Components\Cms\Permission\PermissionList;
use App\View\Components\Cms\Permission\PermissionTable;
use App\View\Components\Cms\Pills\PillVertical;
use App\View\Components\Cms\Repeat\RepeatItems;
use App\View\Components\Cms\Robots\RobotsTxt;
use App\View\Components\Cms\Seo\SeoPage;
use App\View\Components\Cms\Settings\SettingValue;
use App\View\Components\Cms\Tab\Lang;
use App\View\Components\Web\Article\ArticleItem;
use App\View\Components\Web\Article\ArticleLatest;
use App\View\Components\Web\Article\ArticleView;
use App\View\Components\Web\Banner\AboutCompany;
use App\View\Components\Web\Banner\BannerAdvantages;
use App\View\Components\Web\Banner\BannerCatalog;
use App\View\Components\Web\Banner\BannerOtherProducts;
use App\View\Components\Web\Catalog\ProductCategory;
use App\View\Components\Web\Catalog\ProductCategoryItem;
use App\View\Components\Web\Footer\FooterContact;
use App\View\Components\Web\Footer\FooterMain;
use App\View\Components\Web\Footer\FooterTop;
use App\View\Components\Web\Gallery\GalleryPage;
use App\View\Components\Web\Header\HeaderMain;
use App\View\Components\Web\Header\HeaderTop;
use App\View\Components\Web\Header\HeaderTopLanguageSwitcher;
use App\View\Components\Web\Header\HeaderTopMenu;
use App\View\Components\Web\Header\HeaderTopPhones;
use App\View\Components\Web\Info\InfoAdvantages;
use App\View\Components\Web\Language\LanguageSwitcher;
use App\View\Components\Web\Logo\SiteLogo;
use App\View\Components\Web\Banner\SlickSlider;
use App\View\Components\Web\Contact\ContactFooter;
use App\View\Components\Web\Gallery\GalleryVideoItem;
use App\View\Components\Web\Menu\MenuFooter;
use App\View\Components\Web\Menu\MenuMain;
use App\View\Components\Web\Menu\MenuTop;
use App\View\Components\Web\Menu\TopMenu;
use App\View\Components\Web\Meta\MetaTags;
use App\View\Components\Web\News\LatestNews;
use App\View\Components\Web\Phone\PhoneTop;
use App\View\Components\Web\Product\ProductDocumentList;
use App\View\Components\Web\Product\ProductGallery;
use App\View\Components\Web\Social\SocialLinks;
use Modules\Developer\View\Components\Template\TemplateResourceData;
use Modules\Developer\View\Components\Template\TemplateList;
/****/



use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;


/****/

class BladeComponentsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::components([
            /*** cms ***/
            'card' => Card::class,
            'action' => Action::class,
            'button' => Button::class,
            'form' => Form::class,
            'tab-lang' => Lang::class,
            'tab-checkbox' => \App\View\Components\Cms\Tab\Checkbox::class,
            'input' => Input::class,
            'input-number' => InputNumber::class,
            'checkbox' => Checkbox::class,
            'breadcrumbs' => Breadcrumbs::class,
            'cms-page-title' => \App\View\Components\Cms\Page\Title::class,
            'cms-menu' => Menu::class,
            'select' => Select::class,
            'textarea' => Textarea::class,
            'menu-nested-tree' => MenuNestedTree::class,
            'permission-list' => PermissionList::class,
            'permission-table' => PermissionTable::class,
            'file-manager' => FileManager::class,
            'image' => Image::class,
            'gallery' => Gallery::class,
            'editor' => Editor::class,
            'switcher' => Switcher::class,
            'template-list' => TemplateList::class,
            'template-resource-data' => TemplateResourceData::class,
            'pill-vertical' => PillVertical::class,
            'nav-page' => NavPage::class,
            'nav-entity' => NavEntity::class,
            'nav-inner-entity' => NavInnerEntity::class,
            'nav-brand' => NavBrand::class,
            'drag-drop-left-right' => DaDLeftRight::class,
            'slug-generator' => SlugGenerator::class,
            'date-picker' => DatePicker::class,
            'datetime-range-picker' =>DateTimeRangePicker::class,
            'repeat-items' => RepeatItems::class,
            'settings-value' => SettingValue::class,
            'robots-txt' => RobotsTxt::class,
            'filter-container' => FilterContainer::class,
            'page-slug-or-create' => SlugOrCreate::class,
            'color-picker' => ColorPicker::class,
            'advanced-filter' => Filter::class,
            'cms-language-switcher' => \App\View\Components\Cms\Language\Switcher::class,
            'cms-menu-frontend-add-tree' => FrontendAddTree::class,

            // move to page directory
            'seo-page' => SeoPage::class,










            /**
            * Web Components
            */
            /*
             | global components
            */
            'meta-tags' => MetaTags::class,
            'header-top' => HeaderTop::class,
            'header-main' => HeaderMain::class,

            'phone-top' => PhoneTop::class,
            'language-switcher' => LanguageSwitcher::class,
            'site-logo' => SiteLogo::class,
            'contact-footer' => ContactFooter::class,
            'social-links' => SocialLinks::class,
            'page-breadcrumbs' =>\App\View\Components\Web\Page\Breadcrumbs::class,
            'menu-top' =>MenuTop::class,
            'menu-main' => MenuMain::class,
            'menu-footer' => MenuFooter::class,

            'footer-top' => FooterTop::class,
            'footer-main' => FooterMain::class,

            /*
             | main page components
            */
            'slider-slick' => SlickSlider::class,
            'banner-catalog' => BannerCatalog::class,
            'banner-other-products' => BannerOtherProducts::class,
            'info-advantages' => InfoAdvantages::class,
            'about-company' => AboutCompany::class,
            'article-latest' => ArticleLatest::class,

            /*
             | news page components
            */
            'article-item' => ArticleItem::class,
            'article-view' => ArticleView::class,

            /*
             | about company gallery
             */
            'gallery-video-item' => GalleryVideoItem::class,
            'gallery-page' => GalleryPage::class,

            /*
              | catalog components
             */
            'catalog-product-category' => ProductCategory::class,
            'product-document-list' => ProductDocumentList::class,
            'product-gallery' => ProductGallery::class,
        ]);
    }
}
