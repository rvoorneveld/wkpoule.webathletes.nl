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
                        @php
                        $strPointsRewardedClass = ($pointsRewarded = (20 === $game->pointsRewarded)) ? ' class=table-success' : '';
                        @endphp
                        <tr{{ $strPointsRewardedClass }}>
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
                                    value="{{ $game->goalsHome }}"
                                    {{ $disabled = (true === $game->inFuture || true === $pointsRewarded) ? ' disabled' : '' }}
                                    style="width:50px;"
                                >
                            </td>
                            <td>-</td>
                            <td>
                                <input
                                    name="{{ $game->id }}[goalsAway]"
                                    type="text"
                                    class="form-control"
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
                <div class="alert alert-danger alert-important" role="alert">
                    LET OP! Wedstrijden worden vanaf nu altijd van scores voorzien. Je hoeft dit niet meer aan te vinken.
                </div>
                <input class="btn btn-primary" type="submit" name="submit" value="Opslaan">
            </fieldset>
        </form>
    @endif
@endsection