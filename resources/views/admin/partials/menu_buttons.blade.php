@foreach ($menuItems as $menuItem)
    @php
        $subMenuCheck = false;
        //This function will take the route name and return the access permission.
        if (isset($menuItem['routeName']) && $menuItem['routeName'] == 'submenu') {
            $subMenuCheck = true;
        }
        if (
            !isset($menuItem['routeName']) ||
            $menuItem['routeName'] == '' ||
            $menuItem['routeName'] == null ||
            $menuItem['routeName'] == 'submenu'
        ) {
            $check = false;
        } else {
            $check = check_access_by_route_name($menuItem['routeName']);
        }

        //Parameters
        $parameterArray = isset($menuItem['params']) ? $menuItem['params'] : [];
        $subParameterArray = isset($menuItem['subMenu']['subParams']) ? $menuItem['subMenu']['subParams'] : [];
    @endphp
    @if ($check)
        <li @if ($pageSlug == $menuItem['pageSlug']) class="active" @endif>
            <a href="{{ route($menuItem['routeName'], $parameterArray) }}">
                <i
                    class="{{ __($menuItem['iconClass'] ?? 'fa-solid fa-minus') }} @if ($pageSlug == $menuItem['pageSlug']) fa-beat-fade @endif"></i>
                <p>{{ __($menuItem['label']) }}</p>
            </a>
        </li>
    @elseif($subMenuCheck)
        @php
            // Assuming $menuItem['subMenu'] is an array
            $subMenuArray = $menuItem['subMenu'];
            // Use array_reduce to check if any subRouteName is set and has access
            $showSub = array_reduce(
                $subMenuArray,
                function ($carry, $subMenu) {
                    // Check if subRouteName is set and has access
                    return $carry ||
                        (isset($subMenu['subRouteName']) &&
                            $subMenu['subRouteName'] !== '' &&
                            check_access_by_route_name($subMenu['subRouteName']));
                },
                false,
            );
        @endphp
        @if ($showSub)
            <li @if (isset($menuItem['pageSlug']) && collect($menuItem['pageSlug'])->contains($pageSlug)) class="active" @endif>
                <a class="@if (isset($menuItem['pageSlug']) && collect($menuItem['pageSlug'])->contains($pageSlug)) @else collapsed @endif" data-toggle="collapse"
                    href="#{{ isset($menuItem['id']) ? $menuItem['id'] : '' }}"
                    @if (isset($menuItem['subMenu']) && collect($menuItem['pageSlug'])->contains($pageSlug)) aria-expanded="true" @else aria-expanded="false" @endif>
                    <i class='{{ $menuItem['iconClass'] ?? 'fa-solid fa-minus' }}'></i>
                    <span class="nav-link-text">{{ $menuItem['label'] }}</span>
                    <b class="caret mt-1"></b>
                </a>


                <div class="collapse @if (isset($menuItem['subMenu']) && collect($menuItem['pageSlug'])->contains($pageSlug)) show @endif"
                    id="{{ isset($menuItem['id']) ? $menuItem['id'] : '' }}">
                    <ul class="nav pl-2">
                        @foreach ($menuItem['subMenu'] as $subMenu)
                            @php
                                if (
                                    !isset($subMenu['subRouteName']) ||
                                    $subMenu['subRouteName'] == '' ||
                                    $subMenu['subRouteName'] == null
                                ) {
                                    $check = false;
                                } else {
                                    $check = check_access_by_route_name($subMenu['subRouteName']);
                                }
                            @endphp
                            @if ($check)
                                <li @if (isset($subMenu['subPageSlug']) && $pageSlug == $subMenu['subPageSlug']) class="active" @endif>
                                    <a href="{{ route($subMenu['subRouteName'], $subParameterArray) }}">
                                        <i
                                            class="{{ __($menuItem['subIconClass'] ?? 'fa-solid fa-arrow-right') }}  @if (isset($subMenu['subPageSlug']) && $pageSlug == $subMenu['subPageSlug']) fa-beat-fade @endif"></i>
                                        <p>{{ __($subMenu['subLabel']) }}</p>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </li>
        @endif
    @endif
    {{-- For Main Menus  --}}
    @if (!isset($menuItem['routeName']) || $menuItem['routeName'] == '' || $menuItem['routeName'] == null)
        <li @if ($pageSlug == $menuItem['pageSlug']) class="active" @endif>
            <a href="javascript:void(0)">
                <i
                    class="{{ __($menuItem['iconClass'] ?? 'fa-solid fa-minus') }} @if ($pageSlug == $menuItem['pageSlug']) fa-beat-fade @endif"></i>
                <p>{{ __($menuItem['label']) }}</p>
            </a>
        </li>
    @endif
@endforeach
