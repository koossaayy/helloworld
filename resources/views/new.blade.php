@extends('layouts.admin')

@section('title')
    Nests &rarr; New Egg
@endsection

@section('content-header')
    <h1>{{ __('New Egg') }}<small>{{ __('Create a new Egg to assign to servers.') }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">{{ __('Admin') }}</a></li>
        <li><a href="{{ route('admin.nests') }}">{{ __('Nests') }}</a></li>
        <li class="active">{{ __('New Egg') }}</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('admin.nests.egg.new') }}" method="POST">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ __('Configuration') }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="pNestId" class="form-label">{{ __('Associated Nest') }}</label>
                                    <div>
                                        <select name="nest_id" id="pNestId">
                                            @foreach ($nests as $nest)
                                                <option value="{{ $nest->id }}"
                                                    {{ old('nest_id') != $nest->id ?: 'selected' }}>{{ $nest->name }}
                                                    &lt;{{ $nest->author }}&gt;</option>
                                            @endforeach
                                        </select>
                                        <p class="text-muted small">
                                            {{ __('Think of a Nest as a category. You can put multiple Eggs in a nest, but consider putting only Eggs that are related to each other in each Nest.') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pName" class="form-label">{{ __('Name') }}</label>
                                    <input type="text" id="pName" name="name" value="{{ old('name') }}"
                                        class="form-control" />
                                    <p class="text-muted small">
                                        {{ __('A simple, human-readable name to use as an identifier for this Egg. This is what users will see as their game server type.') }}
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label for="pDescription" class="form-label">{{ __('Description') }}</label>
                                    <textarea id="pDescription" name="description" class="form-control" rows="8">{{ old('description') }}</textarea>
                                    <p class="text-muted small">{{ __('A description of this Egg.') }}</p>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox checkbox-primary no-margin-bottom">
                                        <input id="pForceOutgoingIp" name="force_outgoing_ip" type="checkbox" value="1"
                                            {{ \Pterodactyl\Helpers\Utilities::checked('force_outgoing_ip', 0) }} />
                                        <label for="pForceOutgoingIp" class="strong">{{ __('Force Outgoing IP') }}</label>
                                        <p class="text-muted small">
                                            {{ __("Forces all outgoing network traffic to have its Source IP NATed to the IP of the server's primary allocation IP. Required for certain games to work properly when the Node has multiple public IP addresses.") }}
                                            <br>
                                            <strong>
                                                {{ __('Enabling this option will disable internal networking for any servers using this egg, causing them to be unable to internally access other servers on the same node.') }}
                                            </strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="pDockerImage" class="control-label">{{ __('Docker Images') }}</label>
                                    <textarea id="pDockerImages" name="docker_images" rows="4" placeholder="quay.io/pterodactyl/service"
                                        class="form-control">{{ old('docker_images') }}</textarea>
                                    <p class="text-muted small">
                                        {{ __('The docker images available to servers using this egg. Enter one per line. Users will be able to select from this list of images if more than one value is provided.') }}
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label for="pStartup" class="control-label">{{ __('Startup Command') }}</label>
                                    <textarea id="pStartup" name="startup" class="form-control" rows="10">{{ old('startup') }}</textarea>
                                    <p class="text-muted small">
                                        {{ __('The default startup command that should be used for new servers created with this Egg. You can change this per-server as needed.') }}
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label for="pConfigFeatures" class="control-label">{{ __('Features') }}</label>
                                    <div>
                                        <select class="form-control" name="features[]" id="pConfigFeatures" multiple>
                                        </select>
                                        <p class="text-muted small">
                                            {{ __('Additional features belonging to the egg. Useful for configuring additional panel modifications.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ __('Process Management') }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="alert alert-warning">
                                    <p>{{ __("All fields are required unless you select a separate option from the 'Copy Settings From' dropdown, in which case fields may be left blank to use the values from that option.") }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="pConfigFrom" class="form-label">{{ __('Copy Settings From') }}</label>
                                    <select name="config_from" id="pConfigFrom" class="form-control">
                                        <option value="">{{ __('None') }}</option>
                                    </select>
                                    <p class="text-muted small">
                                        {{ __('If you would like to default to settings from another Egg select it from the dropdown above.') }}
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label for="pConfigStop" class="form-label">{{ __('Stop Command') }}</label>
                                    <input type="text" id="pConfigStop" name="config_stop" class="form-control"
                                        value="{{ old('config_stop') }}" />
                                    <p class="text-muted small">
                                        {{ __('The command that should be sent to server processes to stop them gracefully. If you need to send a') }}
                                        <code>{{ __('SIGINT') }}</code> {{ __('you should enter') }}
                                        <code>{{ __('^C') }}</code> {{ __('here.') }}
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label for="pConfigLogs" class="form-label">{{ __('Log Configuration') }}</label>
                                    <textarea data-action="handle-tabs" id="pConfigLogs" name="config_logs" class="form-control" rows="6">{{ old('config_logs') }}</textarea>
                                    <p class="text-muted small">
                                        {{ __('This should be a JSON representation of where log files are stored, and whether or not the daemon should be creating custom logs.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="pConfigFiles" class="form-label">{{ __('Configuration Files') }}</label>
                                    <textarea data-action="handle-tabs" id="pConfigFiles" name="config_files" class="form-control" rows="6">{{ old('config_files') }}</textarea>
                                    <p class="text-muted small">
                                        {{ __('This should be a JSON representation of configuration files to modify and what parts should be changed.') }}
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label for="pConfigStartup"
                                        class="form-label">{{ __('Start Configuration') }}</label>
                                    <textarea data-action="handle-tabs" id="pConfigStartup" name="config_startup" class="form-control" rows="6">{{ old('config_startup') }}</textarea>
                                    <p class="text-muted small">
                                        {{ __('This should be a JSON representation of what values the daemon should be looking for when booting a server to determine completion.') }}
                                    </p>
                                    <p class="text-muted small">{{ __('Hello world please work') }}</p>
                                    <p class="text-muted small">{{ __('FOR FUCK SAKE') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-success btn-sm pull-right">{{ __('Create') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div>
        {{ __('Lorem ipsum dolor hello world') }}
    </div>
    <div>
        {{ __('again another lorem ipsum dolor') }}
    </div>

    <div>
        {{ __('and another one') }}
    </div>


    <div>
        {{ __('TEsting the new thing') }}
    </div>


    <div>
        First commit test
    </div>


    <div>
        second commit test
    </div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}
    <script>
        $(document).ready(function() {
            $('#pNestId').select2().change();
            $('#pConfigFrom').select2();
        });
        $('#pNestId').on('change', function(event) {
            $('#pConfigFrom').html('<option value="">{{ __('None') }}</option>').select2({
                data: $.map(_.get(Pterodactyl.nests, $(this).val() + '.eggs', []), function(item) {
                    return {
                        id: item.id,
                        text: item.name + ' <' + item.author + '>',
                    };
                }),
            });
        });
        $('textarea[data-action="handle-tabs"]').on('keydown', function(event) {
            if (event.keyCode === 9) {
                event.preventDefault();

                var curPos = $(this)[0].selectionStart;
                var prepend = $(this).val().substr(0, curPos);
                var append = $(this).val().substr(curPos);

                $(this).val(prepend + '    ' + append);
            }
        });
        $('#pConfigFeatures').select2({
            tags: true,
            selectOnClose: false,
            tokenSeparators: [',', ' '],
        });
    </script>
@endsection
