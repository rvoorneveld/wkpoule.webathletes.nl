@php
    $carbon = new \Carbon\Carbon();
@endphp

@extends('layouts.app')

@section('content')
    <h1>Programma & Uitslagen</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (false === empty($games))
        <form method="post" name="saveGamesForm" action="/admin/games/save">
            {{ csrf_field() }}
            <fieldset>
                <legend>Alle wedstrijden</legend>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Stadion</th>
                            <th>Datum</th>
                            <th>Tijd</th>
                            <th colspan="5">Wedstrijd</th>
                            <th colspan="2">Kaarten</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($games as $game)
                        <tr>
                            <td>
                                @if(false === empty($types))
                                    <select
                                        class="form-control"
                                        name="{{ $game->id }}[typeId]"
                                        disabled
                                    >
                                        @foreach($types as $type)
                                            <option
                                                    value="{{ $type->id }}"
                                                    {{{ ($game->typeId === $type->id) ? 'selected' : '' }}}
                                            >{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                            <td>
                                @if(false === empty($stadiums))
                                    <select
                                        class="form-control"
                                        name="{{ $game->id }}[stadiumId]"
                                        disabled
                                    >
                                        @foreach($stadiums as $stadium)
                                            <option
                                                value="{{ $stadium->id }}"
                                                {{{ ($game->stadiumId === $stadium->id) ? 'selected' : '' }}}
                                            >{{ $stadium->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                            <td>
                                <input
                                    name="{{ $game->id }}[date]"
                                    type="text"
                                    class="form-control"
                                    value="{{ $game->formattedDate }}"
                                    disabled
                                    style="width:75px;"
                                >
                            </td>
                            <td>
                                <input
                                    name="{{ $game->id }}[time]"
                                    type="text"
                                    class="form-control"
                                    value="{{ $game->formattedTime }}"
                                    disabled
                                    style="width:65px;"
                                >
                            </td>
                            <td style="text-align: right;">
                                @if(false === empty($countries))
                                    <select
                                        class="form-control"
                                        name="{{ $game->id }}[homeId]"
                                        disabled
                                    >
                                        @foreach($countries as $country)
                                            <option
                                                value="{{ $country->id }}"
                                                {{{ ($game->homeCountry->id === $country->id) ? 'selected' : '' }}}
                                            >{{ html_entity_decode($country->name) }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                            <td>
                                <input
                                    name="{{ $game->id }}[goalsHome]"
                                    type="text"
                                    class="form-control"
                                    placeholder="0"
                                    value="{{ $game->goalsHome }}"
                                    {{ $disabled = true === $game->inFuture ? ' disabled' : '' }}
                                    style="width:50px;"
                                >
                            </td>
                            <td>-</td>
                            <td>
                                <input
                                    name="{{ $game->id }}[goalsAway]"
                                    type="text"
                                    class="form-control"
                                    placeholder="0"
                                    value="{{ $game->goalsAway }}"
                                    {{ $disabled }}
                                    style="width:50px;"
                                >
                            </td>
                            <td>
                                @if(false === empty($countries))
                                    <select
                                        class="form-control"
                                        name="{{ $game->id }}[awayId]"
                                        disabled
                                    >
                                    @foreach($countries as $country)
                                        <option
                                            value="{{ $country->id }}"
                                            {{{ ($game->awayCountry->id === $country->id) ? 'selected' : '' }}}
                                        >{{ html_entity_decode($country->name) }}</option>
                                    @endforeach
                                    </select>
                                @endif
                            </td>
                            <td>
                                <select
                                    class="form-control"
                                    name="{{$game->id}}[cardsYellow]"
                                    {{ $disabled }}
                                >
                                    @for($i = 0; $i <= 10; $i++)
                                        @php
                                            $selected = ($i === $game->cardsYellow) ? ' selected' : '';
                                        @endphp
                                        <option value="{{$i}}"{{$selected}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </td>
                            <td>
                                <select
                                    class="form-control"
                                    name="{{$game->id}}[cardsRed]"
                                    {{ $disabled }}
                                >
                                    @for($i = 0; $i <= 5; $i++)
                                        @php
                                            $selected = ($i === $game->cardsRed) ? ' selected' : '';
                                        @endphp
                                        <option value="{{$i}}"{{$selected}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                Update scores: <input type="checkbox" name="updateScores" value="yes">
                <input class="btn btn-primary" type="submit" name="submit" value="Opslaan">
            </fieldset>
        </form>
    @endif
@endsection