@extends('layouts.base')

@section('title', 'Builder')

@section('body')
    <form method="post">
        {{ csrf_field() }}
        <fieldset>
            <legend>Basic Info</legend>

            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="hidden" name="b2c" value="1"/>
                        <input type="checkbox" disabled checked/> B2C
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="lead--interest">
                    Interest
                </label>
                <input id="lead--interest" type="text" class="form-control" name="interest"/>
            </div>
            <div class="form-group">
                <label for="lead--source">
                    Lead Source
                </label>
                <input id="lead--source" type="text" class="form-control"
                       name="lead_source"
                       value="EASI'R Forms (www.easirforms.com)"/>
            </div>
            <div class="form-group">
                <label for="lead--lead_type">
                    Lead Type
                </label>
                <select id="lead--lead_type" name="lead_type_id" class="form-control">
                    @foreach($leadTypes as $leadType)
                        <option value="{{ $leadType->id }}">
                            {{ $leadType->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="lead--team_id">
                    Team
                </label>
                <select id="lead--team_id" name="team_id" class="form-control">
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}">
                            {{ $team->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="inputKey" class="col-md-2 control-label">Lead Data 1</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Key" name="lead_data[0][key]"/>
                        </div>
                        <label for="inputValue" class="col-md-2 control-label">Value</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Value" name="lead_data[0][value]"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="inputKey" class="col-md-2 control-label">Lead Data 2</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Key" name="lead_data[0][key]"/>
                        </div>
                        <label for="inputValue" class="col-md-2 control-label">Value</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Value" name="lead_data[0][value]"/>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Contact Info</legend>

            <div class="form-group">
                <label for="lead--contact_id">
                    Contact ID
                </label>
                <input id="lead--contact_id" type="text" class="form-control"
                       name="contact_id"
                       value=""/>
            </div>

            @foreach($contactFixed as $key => $field)
                @include('subviews.fields', [
                    'type' => 'contact',
                    'key' => $key,
                    'field' => $field,
                    'subType' => 'fixed_fields'
                ])
            @endforeach
        </fieldset>
        <fieldset>
            <legend>Account Info</legend>

            <div class="form-group">
                <label for="lead--account_id">
                    Account ID
                </label>
                <input id="lead--account_id" type="text" class="form-control"
                       name="account_id"
                       value=""/>
            </div>

            @foreach($accountFixed as $key => $field)
                @include('subviews.fields', [
                    'type' => 'account',
                    'key' => $key,
                    'field' => $field,
                    'subType' => 'fixed_fields'
                ])
            @endforeach
        </fieldset>

        <input type="submit" class="btn btn-primary btn-lg center-block" value="Send lead"/>
    </form>
    </body>
    </html>
@endsection
