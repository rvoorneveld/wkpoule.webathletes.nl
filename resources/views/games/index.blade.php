@php
    $carbon = new \Carbon\Carbon();
@endphp

@extends('layouts.app')

@section('content')
    <h1>Wedstrijden</h1>

    @if (false === empty($gamesByPoule))
        <form method="post" name="saveGamesForm" action="/games/save">
            {{ csrf_field() }}
            <div class="row">
                @foreach($gamesByPoule as $poule => $games)
                    <div class="col-lg-12 col-xl-6 text-center">
                        <h2 class="mt-4">Poule {{ $poule }}</h2>
                        @if (false === empty($games))
                            <table class="table table-borderless table-striped">
                                <tbody>
                                @foreach ($games as $game)
                                    @php
                                        $date = $carbon->setTimeFromTimeString("{$game->date} {$game->time}");
                                        $disabled = false === $date->isFuture() ? ' disabled' : '';
                                        $gamePrediction = $userPredictions[$game->id] ?? false;
                                        $goalsHome = $gamePrediction['goalsHome'] ?? '';
                                        $goalsAway = $gamePrediction['goalsAway'] ?? '';
                                        $cardsYellow = $gamePrediction['cardsYellow'] ?? '';
                                        $cardsRed = $gamePrediction['cardsRed'] ?? '';
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $date->format('d') }}<br />
                                            {{ $date->format('M') }}
                                        </td>
                                        <td>
                                            <img class="flag" src="/images/flags/{{$game->homeCountry->flag}}" /><br />
                                            {{ html_entity_decode($game->homeCountry->name) }}
                                        </td>
                                        <td>
                                            <input
                                                    maxlength="1"
                                                    style="max-width:50px; text-align:center; font-size:18px;"
                                                    name="{{$game->id}}[goalsHome]"
                                                    type="text"
                                                    class="form-control"
                                                    value="{{ $goalsHome }}"{{ $disabled }}
                                            >
                                        </td>
                                        <td>-</td>
                                        <td>
                                            <input
                                                maxlength="1"
                                                style="max-width:50px; text-align:center; font-size:18px;"
                                                name="{{$game->id}}[goalsAway]"
                                                type="text"
                                                class="form-control"
                                                value="{{ $goalsAway }}"
                                                {{ $disabled }}
                                            >
                                        </td>
                                        <td>
                                            <img class="flag" src="/images/flags/{{$game->awayCountry->flag}}" /><br />
                                            {{ html_entity_decode($game->awayCountry->name) }}
                                        </td>
                                        <td>
                                            <input
                                                maxlength="1"
                                                style="max-width:50px; text-align:center; font-size:18px; background: yellow;"
                                                name="{{$game->id}}[cardsYellow]"
                                                type="text"
                                                class="form-control"
                                                value="{{ $cardsYellow }}"
                                                {{ $disabled }}
                                            >
                                        </td>
                                        <td>
                                            <input
                                                maxlength="1"
                                                style="max-width:50px; text-align:center; font-size:18px; background: red;"
                                                name="{{$game->id}}[cardsRed]"
                                                type="text"
                                                class="form-control"
                                                value="{{ $cardsRed }}"
                                                {{ $disabled }}
                                            >
                                        </td>
                                        @if (null !== $intPoints = $gamePrediction['points'])
                                            <td>
                                                <div>
                                                    <span class="badge badge-light">{{ $game->goalsHome }}</span>
                                                    -
                                                    <span class="badge badge-light">{{ $game->goalsAway }}</span>
                                                </div>
                                                <div>
                                                    <span class="badge badge-light" style="background: yellow;">{{ $game->cardsYellow }}</span>
                                                    -
                                                    <span class="badge badge-light" style="background: red;">{{ $game->cardsRed }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <h1>
                                                    <span class="badge badge-light">
                                                        {{ $intPoints }}
                                                    </span>
                                                </h1>
                                            </td>
                                        @else
                                            <td colspan="2">&nbsp;</td>
                                        @endif
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="10" class="bg-light">
                                        <input class="btn btn-primary" type="submit" name="submit" value="Opslaan">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                @endforeach
            </div>
        </form>
    @endif
@endsection
