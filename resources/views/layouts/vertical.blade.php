<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern 2-columns
@if($configData['isMenuCollapsed'] == true){{'menu-collapsed'}}@endif
@if($configData['theme'] === 'dark'){{'dark-layout'}} @elseif($configData['theme'] === 'semi-dark'){{'semi-dark-layout'}} @else {{'light-layout'}} @endif
@if($configData['isContentSidebar'] === true) {{'content-left-sidebar'}} @endif @if(isset($configData['navbarType'])){{$configData['navbarType']}}@endif
@if(isset($configData['footerType'])) {{$configData['footerType']}} @endif
{{$configData['bodyCustomClass']}}
@if($configData['mainLayoutType'] === 'vertical-menu-boxicons'){{'boxicon-layout'}}@endif
@if($configData['isCardShadow'] === false){{'no-card-shadow'}}@endif menu-expanded"
data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

  <!-- BEGIN: Header-->
  @include('cms.panels.navbar')
  <!-- END: Header-->

  <!-- BEGIN: Main Menu-->
  @include('cms.panels.sidebar')
  <!-- END: Main Menu-->

  <!-- BEGIN: Content-->
  <div class="app-content content">
  {{-- Application page structure --}}
	@if($configData['isContentSidebar'] === true)
		<div class="content-area-wrapper">
			<div class="sidebar-left">
				<div class="sidebar">
					@yield('sidebar-content')
				</div>
			</div>
			<div class="content-right">
          <div class="content-overlay"></div>
				<div class="content-wrapper">
          <div class="content-header row">
          </div>
          <div class="content-body">
            @yield('content')
          </div>
        </div>
			</div>
		</div>
	@else
    {{-- others page structures --}}

    <div class="content-overlay"></div>
		<div class="content-wrapper">
			<div class="content-header row">
                @if($configData['pageHeader']=== true )
                    <div class="content-header-left col-6 mb-2 mt-1">
                        <div class="row breadcrumbs-top">
                            <div class="col-12">
                                <x-breadcrumbs></x-breadcrumbs>
                            </div>
                        </div>
                    </div>
                @endif
                @include('cms.panels.actions')
			</div>
			<div class="content-body">
				@yield('content')
			</div>
		</div>
	@endif
  </div>
  <!-- END: Content-->

  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div>

  <div id="page-loader" style="display: none">
      <div class="sk-spinner sk-spinner-wave">
          <div class="sk-rect1"></div>
          <div class="sk-rect2"></div>
          <div class="sk-rect3"></div>
          <div class="sk-rect4"></div>
          <div class="sk-rect5"></div>
      </div>
  </div>

  <!-- BEGIN: Customizer-->
  @include('cms.panels.customizer')
  <!-- END: Customizer-->

  <!-- BEGIN: Footer-->
  @include('cms.panels.footer')
  <!-- END: Footer-->

  <!-- BEGIN: Modal-->
  @include('cms.panels.modal')
  <!-- END: Modal-->

  <!-- BEGIN: Scripts-->
  @include('cms.panels.scripts')
  <!-- END: Scripts-->

  {!! toastr()->render() !!}
</body>
<!-- END: Body-->
