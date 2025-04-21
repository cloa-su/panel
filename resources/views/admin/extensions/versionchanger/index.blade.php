@extends('layouts.admin')
<?php 
    // Define extension information.
    $EXTENSION_ID = "versionchanger";
    $EXTENSION_NAME = stripslashes("Minecraft Version Changer");
    $EXTENSION_VERSION = "1.1.0";
    $EXTENSION_DESCRIPTION = stripslashes("Minecraft Version Changer allows you to adjust your minecraft servers version instantly.");
    $EXTENSION_ICON = "/assets/extensions/versionchanger/icon.jpg";
    $EXTENSION_WEBSITE = "[website]";
    $EXTENSION_WEBICON = "[webicon]";
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
    @yield('extension.description')<?php

  $response = '{"success":true,"product":{"id":5,"name":"Minecraft Version Changer","version":"1.1.0","icon":"https://cdn.rjns.dev/addons/versionchanger_icon.jpg","banner":"https://cdn.rjns.dev/addons/versionchanger_banner.jpg","summary":"Version Changer allows you to adjust your minecraft servers version instantly."},"providers":{"SOURCEXCHANGE":{"name":"sourceXchange","price":12.99,"currency":"EUR","link":"https://www.sourcexchange.net/products/version-changer"},"BUILTBYBIT":{"name":"BuiltByBit","price":14.49,"currency":"USD","link":"https://builtbybit.com/resources/minecraft-version-changer.46435"}}}';

  $data = json_decode($response, true);

  $version = $data['product']['version'];
  $providers = array_values($data['providers']);

  $nonceIdentifier = '%%__NONCE' . '__%%';
  $nonceIdentifierWithoutReplacement = '%%__NONCE' . '__%%';
?>

<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="box {{ $version !== 'Unknown' ? $version !== "1.1.0" ? 'box-danger' : 'box-primary' : 'box-primary' }}">
      <div class="box-header with-border">
        <h3 class="box-title"><i class='bx bx-git-repo-forked' ></i> Information</h3>
      </div>
      <div class="box-body">
        <p>
          Thank you for purchasing <b>Minecraft Version Changer</b>! You are currently using version <code>1.1.0</code> (latest version is <code>{{ $version }}</code>).
          If you have any questions or need help, please visit our <a href="https://rjansen.dev/discord" target="_blank">Discord</a>.
          <b>{{ $nonceIdentifier === $nonceIdentifierWithoutReplacement ? "This is an indev version of the product! Cracked by Ikdan!" : "Cracked by Ikdan!" }}</b>
        </p>

        <div class="row" style="margin-top: 10px;">
          @foreach ($providers as $provider)
            <div class="col-md-6">
              <a href="{{ $provider['link'] }}" target="_blank" class="btn btn-primary btn-block"><i class='bx bx-store'></i> {{ $provider['name'] }}</a>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"><i class='bx bxs-info-square'></i> Banner</h3>
      </div>
      <div class="box-body">
        <img src="/extensions/versionchanger/versionchanger_banner.jpg" class="img-rounded img-responsive" alt="Banner" style="max-width: 600px; margin: 0 auto;">
      </div>
    </div>
  </div>
</div>
@endsection
