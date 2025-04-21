@extends('layouts.admin')
<?php 
    // Define extension information.
    $EXTENSION_ID = "customserversort";
    $EXTENSION_NAME = stripslashes("Custom Server Sort");
    $EXTENSION_VERSION = "1.0.3";
    $EXTENSION_DESCRIPTION = stripslashes("Pterodactyl server sorting that just works.");
    $EXTENSION_ICON = "/assets/extensions/customserversort/icon.png";
    $EXTENSION_WEBSITE = "https://discord.gg/3Gu2FThNcS";
    $EXTENSION_WEBICON = "bx bxl-discord-alt";
?>
@include('blueprint.admin.template')

@section('title')
    {{ $EXTENSION_NAME }}
@endsection

@section('content-header')
    @yield('extension.header')
@endsection

@section('content')
    @yield('extension.config')
    @yield('extension.description')
@endsection
