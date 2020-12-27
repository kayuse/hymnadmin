@extends('portal.layout.header')
@section('sidebar')
    <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="sidenav-header  align-items-center">
                <a class="navbar-brand" href="javascript:void(0)">
                    <img src="/img/logo.png" class="navbar-brand-img" alt="..."
                         style="width: 100px; height: 100px; max-height: 100px; margin-top: -25px;">
                </a>
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link @if(url()->current() == route('portal.dashboard')) active @endif"
                               href="{{route('portal.dashboard')}}">
                                <i class="ni ni-tv-2 text-primary"></i>
                                <span class="nav-link-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(url()->current() == route('portal.hymns.all')) active @endif"
                               href="{{route('portal.hymns.all')}}">
                                <i class="ni ni-note-03 text-orange"></i>
                                <span class="nav-link-text">Hymns</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  @if(url()->current() == route('portal.sundayschool.all')) active @endif"
                               href="{{route('portal.sundayschool.all')}}">
                                <i class="ni ni-book-bookmark text-primary"></i>
                                <span class="nav-link-text">Sunday School</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  @if(url()->current() == route('portal.sundayschool.all')) active @endif"
                               href="{{route('portal.sundayschool.all')}}">
                                <i class="ni ni-sound-wave text-yellow"></i>
                                <span class="nav-link-text">Flow</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tables.html">
                                <i class="ni ni-bullet-list-67 text-default"></i>
                                <span class="nav-link-text">Tables</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Divider -->
                    <hr class="my-3">
                    <!-- Heading -->
                    <h6 class="navbar-heading p-0 text-muted">
                        <span class="docs-normal">App Details</span>
                    </h6>
                    <!-- Navigation -->
                    <ul class="navbar-nav mb-md-3">
                        <li class="nav-item">
                            <a class="nav-link"
                               href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html"
                               target="_blank">
                                <i class="ni ni-spaceship"></i>
                                <span class="nav-link-text">Getting started</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               href="https://demos.creative-tim.com/argon-dashboard/docs/foundation/colors.html"
                               target="_blank">
                                <i class="ni ni-palette"></i>
                                <span class="nav-link-text">Foundation</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               href="https://demos.creative-tim.com/argon-dashboard/docs/components/alerts.html"
                               target="_blank">
                                <i class="ni ni-ui-04"></i>
                                <span class="nav-link-text">Components</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               href="https://demos.creative-tim.com/argon-dashboard/docs/plugins/charts.html"
                               target="_blank">
                                <i class="ni ni-chart-pie-35"></i>
                                <span class="nav-link-text">Plugins</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active active-pro" href="upgrade.html">
                                <i class="ni ni-send text-dark"></i>
                                <span class="nav-link-text">Upgrade to PRO</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
@endsection
