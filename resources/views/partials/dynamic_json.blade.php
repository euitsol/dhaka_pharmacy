@if(is_array($data))
    <ul class="list-unstyled ps-3 mb-0 border-start border-light">
        @foreach($data as $key => $value)
            <li class="mb-2">
                <strong class="text-primary">{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong>
                <span class="ms-2">
                    @if(is_array($value))
                        @include('partials.dynamic_json', ['data' => $value])
                    @else
                        {{ $value }}
                    @endif
                </span>
            </li>
        @endforeach
    </ul>
@endif
