<div id="accordion2">
    @foreach ($childrens as $directory)
        <ul class="nav nav-pills flex-column tree">
            @php
                $childrensSub = $directory->childrens();
            @endphp
            <li class="nav-item sub-item">
                <a class="nav-link" href="#" data-type="0" data-path="{{ $directory->url }}" data-toggle="collapse" data-target="#collapse2{{ $directory->slug }}"
                    aria-controls="collapse2{{ $directory->slug }}">
                    @if (count($childrensSub) > 0)
                        <i class="fas fa-angle-down"></i>
                    @endif
                    <i class="fa fa-folder fa-fw"></i> {{ $directory->name }}
                </a>
                <div id="collapse2{{ $directory->slug }}" class="collapse" aria-labelledby="heading{{ $directory->slug }}" data-parent="#accordion2">
                    <div class="tree" style="margin-left: 30px;">
                        @if ($childrensSub)
                            @include('pages.painel.obras.obras.documentos.childrens', ['childrens' => $childrensSub])
                        @endif
                    </div>
                </div>
            </li>
        </ul>
    @endforeach
</div>
