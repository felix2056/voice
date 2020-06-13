<!DOCTYPE html>
<html lang="en" style="height: auto; min-height: 100%;">
<head>
    <?php
    $settings = App\Setting::whereIn(
            'meta_key', [
                'logo',
                'favicon',
                'site_name',
                'short_name',
                'site_desc',
                'site_link',
                'keywords',
                'email',
                'contact_address',
                'contact_email',
                'contact_phone',
                'facebook',
                'twitter',
                'instagram'
            ]
            )->get();

            $metas = [];

            foreach ($settings as $setting){
                $metas[$setting->meta_key] = $setting->meta_value;
            }
            $siteInfo = $metas;
    ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="{{ $siteInfo['site_desc'] }}">
    <meta name="author" content="{{ $siteInfo['site_name'] }}">
    <link rel="icon" href="@if($siteInfo['favicon']){{asset('storage/site/'.$siteInfo['favicon'])}} @else{{ asset('assets/images/site/favicon.png') }}@endif">

    <title>{{ $siteInfo['site_name'] }} | Authentication</title>

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{ asset('assets/vendor_components/bootstrap/dist/css/bootstrap.css') }}">

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css') }}">

    <!--amcharts -->
    <link href="https://www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap-extend -->
    <link rel="stylesheet" href="{{ asset('assets/src/css/bootstrap-extend.css') }}">

    <!-- theme style -->
    <link rel="stylesheet" href="{{ asset('src/css/master_style.css') }}">

    <!-- Crypto_Admin skins -->
    <link rel="stylesheet" href="{{ asset('src/css/skins/_all-skins.css') }}">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body class="hold-transition login-page" data-gr-c-s-loaded="true">
    @yield('content')
    
    
    <!-- jQuery 3 -->
    <script src="{{ asset('assets/vendor_components/jquery/dist/jquery.js') }}"></script>

    <!-- popper -->
    <script src="{{ asset('assets/vendor_components/popper/dist/popper.min.js') }}"></script>
        
    <!-- Bootstrap 4.0-->
    <script src="{{ asset('assets/vendor_components/bootstrap/dist/js/bootstrap.js') }}"></script>
    
    
    
    <div class="nsc-panel nsc-panel-compact nsc-hide">
        <div class="nsc-panel-move"></div>
        <div class="nsc-panel-tooltip">
            <div class="nsc-panel-tooltip-layout" layout="row" layout-align="start center">CTRL+V to toggle the panel</div>
        </div>
    
        <div class="nsc-panel-layout" flex="" layout="row" layout-align="start center">
            <div class="nsc-panel-groups" flex="" layout="row" layout-align="start start">
    
                <!-- group -->
                <div class="nsc-panel-group" flex="none" layout="row" layout-align="start start">
                    <div class="nsc-panel-button separated active">
                        <div class="nsc-panel-select" flex="" layout="row">
                            <div class="nsc-panel-text nsc-noselect" flex="" layout="row" layout-align="center center">
                                <span class="nsc-icon nsc-icon-cursor-normal" data-i18n="videoPanelSimpleCursor" data-event="nimbus-editor-active-tools" data-event-param="cursorDefault">&nbsp;</span>
                            </div>
                            <div class="nsc-panel-trigger">
                                <span class="nsc-icon nsc-icon-arrow">&nbsp;</span>
                            </div>
                        </div>
                        <div class="nsc-panel-dropdown to-top">
                            <ul flex="" layout="row" layout-align="start center">
                                <li class="nsc-panel-dropdown-icon" flex="" layout="row" layout-align="start center">
                                    <span class="nsc-icon nsc-icon-cursor-shade" data-i18n="videoPanelFocusMouse" data-event="nimbus-editor-active-tools" data-event-param="cursorShadow">&nbsp;</span>
                                </li>
                                <li class="nsc-panel-dropdown-icon" flex="" layout="row" layout-align="start center">
                                    <span class="nsc-icon nsc-icon-cursor-circle" data-i18n="videoPanelAnimatedCursor" data-event="nimbus-editor-active-tools" data-event-param="cursorRing">&nbsp;</span>
                                </li>
                                <!--<li class="nsc-panel-dropdown-icon " flex layout="row" layout-align="start center">-->
                                <!--<span class="nsc-icon nsc-icon-cursor-tail"></span>-->
                                <!--</li>-->
                                <!--<li class="nsc-panel-dropdown-icon " flex layout="row" layout-align="start center">-->
                                <!--<span class="nsc-icon nsc-icon-cursor-long"></span>-->
                                <!--</li>-->
                                <li class="nsc-panel-dropdown-icon" flex="" layout="row" layout-align="start center">
                                    <span class="nsc-icon nsc-icon-cursor-normal" data-i18n="videoPanelSimpleCursor" data-event="nimbus-editor-active-tools" data-event-param="cursorDefault">&nbsp;</span>
                                </li>
                                <!--<li class="nsc-panel-dropdown-icon" flex layout="row" layout-align="start center">-->
                                <!--<span class="nsc-icon nsc-icon-cursor-none" data-event="nimbus-editor-active-tools" data-event-param="cursorNone"></span>-->
                                <!--</li>-->
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /group -->
    
                <!-- group -->
                <div class="nsc-panel-group" flex="none" layout="row" layout-align="start start">
                    <button class="nsc-panel-button" type="button">
                        <span class="nsc-icon nsc-icon-pen" data-i18n="videoPanelPen" data-event="nimbus-editor-active-tools" data-event-param="pen">&nbsp;</span>
                    </button>
                    <button class="nsc-panel-button" type="button">
                        <span class="nsc-icon nsc-icon-arrow-line" data-i18n="videoPanelArrow" data-event="nimbus-editor-active-tools" data-event-param="arrow">&nbsp;</span>
                    </button>
                    <button class="nsc-panel-button" type="button">
                        <span class="nsc-icon nsc-icon-square" data-i18n="videoPanelSquare" data-event="nimbus-editor-active-tools" data-event-param="square">&nbsp;</span>
                    </button>
                    <div class="nsc-panel-button separated">
                        <div class="nsc-panel-select" flex="" layout="row">
                            <div class="nsc-panel-text nsc-noselect" flex="" layout="row" layout-align="center center">
                                <span class="nsc-icon nsc-icon-attention" data-i18n="videoPanelMark" data-event="nimbus-editor-active-tools" data-event-param="notifRed">&nbsp;</span>
                            </div>
                            <div class="nsc-panel-trigger">
                                <span class="nsc-icon nsc-icon-arrow">&nbsp;</span>
                            </div>
                        </div>
                        <div class="nsc-panel-dropdown to-top">
                            <ul flex="" layout="row" layout-align="start center">
                                <li class="nsc-panel-dropdown-icon" flex="" layout="row" layout-align="start center">
                                    <span class="nsc-icon nsc-icon-attention" data-i18n="videoPanelMark" data-event="nimbus-editor-active-tools" data-event-param="notifRed">&nbsp;</span>
                                </li>
                                <li class="nsc-panel-dropdown-icon" flex="" layout="row" layout-align="start center">
                                    <span class="nsc-icon nsc-icon-question" data-i18n="videoPanelQuestion" data-event="nimbus-editor-active-tools" data-event-param="notifBlue">&nbsp;</span>
                                </li>
                                <li class="nsc-panel-dropdown-icon" flex="" layout="row" layout-align="start center">
                                    <span class="nsc-icon nsc-icon-done" data-i18n="videoPanelCheckmark" data-event="nimbus-editor-active-tools" data-event-param="notifGreen">&nbsp;</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="nsc-panel-button assembled">
                        <div class="nsc-panel-select" flex="" layout="row">
                            <div class="nsc-panel-text nsc-noselect" flex="" layout="row" layout-align="center center">
                                <span class="nsc-icon nsc-icon-fill-none nsc-panel-icon-fill">
                                    <span class="nsc-panel-icon-fill-inner" id="nsc_panel_button_colors" style="background:#00FF00;" data-event="nimbus-editor-active-color" data-event-param="#00FF00">&nbsp;</span>
                                </span>
                            </div>
                            <div class="nsc-panel-trigger">
                                <span class="nsc-icon nsc-icon-arrow">&nbsp;</span>
                            </div>
                        </div>
                        <div class="nsc-panel-dropdown">
                            <div class="nsc-panel-drop-area">
                                <div class="nsc-panel-colors">
    
                                    <!-- picked -->
                                    <div class="nsc-colors-picked">
                                        <div class="nsc-colors-picked-layout" flex="" layout="row" layout-align="start start" layout-wrap="">
                                            <div class="nsc-colors-picked-item">
                                                <button class="nsc-colors-picked-button" type="button" data-event="nimbus-editor-active-color" data-event-param="#000000">
                                                    <span class="nsc-colors-picked-button-inner" style="background: #000000;">&nbsp;</span>
                                                </button>
                                            </div>
                                            <div class="nsc-colors-picked-item">
                                                <button class="nsc-colors-picked-button" type="button" data-event="nimbus-editor-active-color" data-event-param="#0000FF">
                                                    <span class="nsc-colors-picked-button-inner" style="background: #0000FF;">&nbsp;</span>
                                                </button>
                                            </div>
                                            <div class="nsc-colors-picked-item">
                                                <button class="nsc-colors-picked-button" type="button" data-event="nimbus-editor-active-color" data-event-param="#FF00FF">
                                                    <span class="nsc-colors-picked-button-inner" style="background: #FF00FF;">&nbsp;</span>
                                                </button>
                                            </div>
                                            <div class="nsc-colors-picked-item">
                                                <button class="nsc-colors-picked-button" type="button" data-event="nimbus-editor-active-color" data-event-param="#00FFFF">
                                                    <span class="nsc-colors-picked-button-inner" style="background: #00FFFF;">&nbsp;</span>
                                                </button>
                                            </div>
                                            <div class="nsc-colors-picked-item">
                                                <button class="nsc-colors-picked-button" type="button" data-event="nimbus-editor-active-color" data-event-param="#00FF00">
                                                    <span class="nsc-colors-picked-button-inner" style="background: #00FF00;">&nbsp;</span>
                                                </button>
                                            </div>
                                            <div class="nsc-colors-picked-item">
                                                <button class="nsc-colors-picked-button" type="button" data-event="nimbus-editor-active-color" data-event-param="#FFFF00">
                                                    <span class="nsc-colors-picked-button-inner" style="background: #FFFF00;">&nbsp;</span>
                                                </button>
                                            </div>
                                            <div class="nsc-colors-picked-item">
                                                <button class="nsc-colors-picked-button" type="button" data-event="nimbus-editor-active-color" data-event-param="#FF0000">
                                                    <span class="nsc-colors-picked-button-inner" style="background: #FF0000;">&nbsp;</span>
                                                </button>
                                            </div>
                                            <div class="nsc-colors-picked-item">
                                                <button class="nsc-colors-picked-button" type="button" data-event="nimbus-editor-active-color" data-event-param="#FFFFFF">
                                                    <span class="nsc-colors-picked-button-inner" style="background: #FFFFFF;">&nbsp;</span>
                                                </button>
                                            </div>
                                            <!--<div class="nsc-colors-picked-item">-->
                                            <!--<button class="nsc-colors-picked-button custom" type="button"> -->
                                            <!--<i class="nsc-icon ic-color-custom"></i> -->
                                            <!--</button>-->
                                            <!--</div>-->
                                        </div>
                                    </div>
                                    <!-- /picked -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /group -->
    
                <!-- group -->
                <div class="nsc-panel-group" flex="none" layout="row" layout-align="start start">
                    <button class="nsc-panel-button nsc-hide" type="button">
                        <span class="nsc-icon nsc-icon-eraser" data-i18n="videoPanelClear" data-event="nimbus-editor-active-tools" data-event-param="clear">&nbsp;</span>
                    </button>
                    <button class="nsc-panel-button" type="button">
                        <span class="nsc-icon nsc-icon-eraser-all" data-i18n="videoPanelClearAll" data-event="nimbus-editor-active-tools" data-event-param="clearAll">&nbsp;</span>
                    </button>
                    <button class="nsc-panel-button" type="button">
                        <span class="nsc-icon nsc-icon-webcam" data-i18n="videoPanelCamera" id="nimbus_web_camera_toggle">&nbsp;</span>
                    </button>
                </div>
                <!-- /group -->
            </div>
    
            <div class="nsc-panel-actions" flex="none" layout="row" layout-align="start center">
                <button class="nsc-panel-button big" type="button" id="nsc_panel_button_play" style="display: none;">
                    <span class="nsc-icon nsc-icon-play">&nbsp;</span>
                </button>
                <button class="nsc-panel-button big" type="button" id="nsc_panel_button_pause">
                    <span class="nsc-icon nsc-icon-pause">&nbsp;</span>
                </button>
                <button class="nsc-panel-button big" type="button" id="nsc_panel_button_stop">
                    <span class="nsc-icon nsc-icon-stop">&nbsp;</span>
                </button>
            </div>
    
            <!-- panel togglers -->
            <div class="nsc-panel-togglers" layout="row" layout-align="start center" flex="none">
                <button class="nsc-panel-toggle-button" type="button">
                    <span class="nsc-icon nsc-icon-panel-close" data-i18n="videoPanelHideShowPanel">&nbsp;</span>
                </button>
            </div>
            <!-- /panel togglers -->
    
        </div>
    </div>
    </body>