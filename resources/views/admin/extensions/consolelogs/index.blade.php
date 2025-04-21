@extends('layouts.admin')
<?php 
    // Define extension information.
    $EXTENSION_ID = "consolelogs";
    $EXTENSION_NAME = stripslashes("Console Logs");
    $EXTENSION_VERSION = "v1.0";
    $EXTENSION_DESCRIPTION = stripslashes("Addon that allows users to Copy Console Logs to Clipboard");
    $EXTENSION_ICON = "/assets/extensions/consolelogs/icon.png";
    $EXTENSION_WEBSITE = "https://euphoriadevelopment.uk";
    $EXTENSION_WEBICON = "bx bx-link-external";
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
    @yield('extension.description')<!-- Version and Information Box (Full Width) -->
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><strong>Console Logs</strong> by <strong>Euphoria Development</strong></h3>
            </div>
            <div class="box-body">
                Identifier: <code>consolelogs</code><br>
                Uninstall using: <code>blueprint -remove consolelogs</code><br>
                If any errors occur use redprint! <code>bash <(curl -s https://redprint.zip)</code><br>
                Get support via <a href="https://discord.gg/Cus2zP4pPH" target="_blank" rel="noopener noreferrer">Discord</a><br>
            </div>
        </div>
    </div>
</div>
@endsection
