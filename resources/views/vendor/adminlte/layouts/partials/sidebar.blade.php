@php
    $modulesGroup = [];
    $roleId = \Auth::user()->role_id;
    $slug = \Auth::user()->role_slug;

    if (!is_null($roleId)) {
        $modulesGroup = \Cache::get("modulesFullAccess");
        if (!$modulesGroup) {
            $modulesGroup = \Cache::remember(
                "modulesFullAccess",
                365*24*60*60,
                function() {
                    return \App\Master\Models\Module::select([
                        "id",
                        "class_icon",
                        "name",
                        "url",
                        "num_childs"
                    ])
                        ->with([
                            "childModules" => function($q) {
                                $q->select([
                                    "id",
                                    "name",
                                    "url",
                                    "module_parent_id"
                                ])
                                ->where("status", 1)
                                ->where("visible", 1);
                            }
                        ])
                        ->where("status", 1)
                        ->where("visible", 1)
                        ->whereRaw("module_parent_id IS NULL")
                        ->orderBy("order", "ASC")
                        ->get()
                        ->toArray();
                }
            );
        }

        if (!in_array($slug, config("crreportes.roles.fullaccess"))) {
            $modulesGroupTmp = [];
            $rolesModules = 
                \App\Master\Models\RoleModule::where("role_id", $roleId)
                    ->pluck("role_id", "module_id");
            

            $index = 0;
            foreach($modulesGroup as $key => $value) {
                $modulesGroupTmp[$index] = $value;
                $modulesGroupTmp[$index]["child_modules"] = [];
                $childModules = $value["child_modules"];
                foreach($childModules as $key2 => $value2) {
                    if (isset($rolesModules[$value2["id"]])) {
                        $modulesGroupTmp[$index]["child_modules"][] = $value2;
                    }
                }
                $index++;
            }
            
            foreach($modulesGroupTmp as $key => $value) {
                if (is_null($value["url"]) && count($value["child_modules"]) <=0) {
                    unset($modulesGroupTmp[$key]);
                }
            }
            $modulesGroup = $modulesGroupTmp;
        }
    }
    

@endphp
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p style="overflow: hidden;text-overflow: ellipsis;max-width: 160px;" data-toggle="tooltip" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif
        <!-- search form (Optional) -->
        {{--<form action="#" method="get" class="sidebar-form">--}}
            {{--<div class="input-group">--}}
                {{--<input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>--}}
              {{--<span class="input-group-btn">--}}
                {{--<button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>--}}
              {{--</span>--}}
            {{--</div>--}}
        {{--</form>--}}
        <!-- /.search form -->

        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            @foreach($modulesGroup as $key => $value)
                @php
                    $url = $value["url"];
                    $childs = $value["num_childs"];
                    $icon = $value["class_icon"];
                    $name = $value["name"];
                    $classActive = "";
                    $homeClassActive = "";
                    $classTreeView = "treeview";
                    $currentRouteName = \Route::currentRouteName();
                    //dd($currentRouteName);

                    if ($currentRouteName == "home" || is_null($currentRouteName)) {
                        $classActive = "";
                        //$classTreeView = "";
                    } else {
                        $currentRoute = route($currentRouteName);
                        foreach ($value["child_modules"] as $key2 => $value2) {
                            if (!is_null($value2["url"]) && $currentRouteName!="home" && $currentRoute == route($value2["url"])) {
                                $classActive = "active";
                            }
                        }
                    }
                    
                @endphp
                <li class="{{ ($childs > 0)? $classTreeView : '' }} {{ $classActive }}">
                    @if((int)$childs === 0)
                        <a href="{{ !is_null($url)? route($url) : '#' }}">
                            <i class="{{ $icon }}"></i>&nbsp;&nbsp;
                            <span>{{ $name }}</span>
                        </a>
                    @else
                        <a href="#">
                            <i class='{{ $icon }}'></i>&nbsp;&nbsp;
                            <span>{{ $name }}</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                        @foreach ($value["child_modules"] as $key2 => $value2)
                            @php
                                $id = "ID_".str_replace(".", "_", $value2["url"]);
                                $urlTwo = route($value2["url"]);
                                $nameTwo = $value2["name"];
                            @endphp
                            <li id="menOpt{{ $id }}">
                                <a href="{{ $urlTwo }}">
                                    <i class="fa fa-circle-o"></i> {{ $nameTwo }}
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    @endif
                    
                </li>
            @endforeach
        </ul>
        {{--<nav class="navigation">--}}
            {{--{!! Menu::main() !!}--}}
        {{--</nav>--}}
    </section>
    <!-- /.sidebar -->
</aside>
