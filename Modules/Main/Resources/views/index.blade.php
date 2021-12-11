@component('admin.layouts.content', ['title' => 'Modules'])
    <div class="row">
        @foreach ($modules as $module)
            @php
                $moduledata = new \Nwidart\Modules\Json($module->getPath() . '\module.json');
            @endphp
            @if (Module::canDisable($module->getName()))
                <div class="card col-lg-5 m-4">
                    <div class="card-header">
                        {{ $moduledata->get('alias') }}
                    </div>
                    <div class="card-body">
                        <h2>{{ $moduledata->get('description') }}</h2>
                        @if (Module::isEnable($module->getName()))
                            <form action="{{ route('module.disable', $module->getName()) }}" method="post">
                                @csrf
                                <button class="btn btn-danger">Disable</button>
                            </form>
                        @else
                            <form action="{{ route('module.enable', $module->getName()) }}" method="post">
                                @csrf
                                <button class="btn btn-success">Enable</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif

        @endforeach
    </div>
@endcomponent
