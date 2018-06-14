@php
    $carbon = new \Carbon\Carbon();
@endphp

@extends('layouts.app')

@section('content')
    <h1>Wedstrijden</h1>

    <div class="alert alert-warning alert-important" role="alert">
        Let op: Wanneer je een wedstrijd wilt opslaan dien je alle 4 de velden in te vulen.<br />
        Uitslag thuis, uitslag uit, gele kaarten en rode kaarten.
    </div>

    @if (false === empty($gamesByPoule))
        <form class="form-inline" method="post" name="saveGamesForm" action="/games/save">
            {{ csrf_field() }}
            <div class="row">
                @foreach($gamesByPoule as $poule => $games)
                    <div class="col-lg-12 col-xl-6 text-center px-0 px-md-3">
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
                                        <td class="px-1 px-sm-1 px-md-2 px-lg-3">

                                            <div class="d-sm-none">
                                                {{ $date->format('d') }}<br />
                                                {{ $date->format('m') }}
                                            </div>
                                            <div class="d-none d-sm-block">
                                                {{ $date->format('d') }} {{ $date->format('M') }}<br />
                                                {{ $date->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-0 px-sm-1 px-md-2 px-lg-3">
                                            <img class="flag" src="/images/flags/{{$game->homeCountry->flag}}" />
                                            <div class="d-sm-none text-uppercase">{{ $game->homeCountry->code }}</div>
                                            <div class="d-none d-sm-block">{{ html_entity_decode($game->homeCountry->name) }}</div>
                                        </td>
                                        <td class="px-0">
                                            <input
                                                maxlength="1"
                                                name="{{$game->id}}[goalsHome]"
                                                type="text"
                                                class="form-control form-control--score"
                                                value="{{ $goalsHome }}"{{ $disabled }}
                                            >
                                            -
                                            <input
                                                maxlength="1"
                                                name="{{$game->id}}[goalsAway]"
                                                type="text"
                                                class="form-control form-control--score"
                                                value="{{ $goalsAway }}"
                                                {{ $disabled }}
                                            >
                                        </td>
                                        <td class="px-0 px-sm-1 px-md-2 px-lg-3">
                                            <img class="flag" src="/images/flags/{{$game->awayCountry->flag}}" />
                                            <div class="d-sm-none text-uppercase">{{ $game->awayCountry->code }}</div>
                                            <div class="d-none d-sm-block">{{ html_entity_decode($game->awayCountry->name) }}</div>
                                        </td>
                                        <td class="px-0">
                                            <input
                                                maxlength="1"
                                                name="{{$game->id}}[cardsYellow]"
                                                type="text"
                                                class="form-control form-control--score form-control--card-yellow"
                                                value="{{ $cardsYellow }}"
                                                {{ $disabled }}
                                            >
                                            <input
                                                maxlength="1"
                                                name="{{$game->id}}[cardsRed]"
                                                type="text"
                                                class="form-control form-control--score form-control--card-red"
                                                value="{{ $cardsRed }}"
                                                {{ $disabled }}
                                            >
                                        </td>
                                        @if (null !== $game->goalsHome && false === $date->isFuture())
                                            <td class="px-0 px-sm-1 px-md-2 px-lg-3">
                                                <div>
                                                    <span class="badge badge-light">{{ $game->goalsHome }}</span>-<span class="badge badge-light">{{ $game->goalsAway }}</span>
                                                </div>
                                                <div>
                                                    <span class="badge badge-light" style="background: yellow;">{{ $game->cardsYellow }}</span>-<span class="badge badge-light" style="background: red;">{{ $game->cardsRed }}</span>
                                                </div>
                                            </td>
                                            <td class="px-0 px-xs-1 px-sm-2 px-md-3">
                                                <h2>
                                                    <span class="badge badge-light">
                                                        {{ $gamePrediction['points'] ?? 0 }}
                                                    </span>
                                                </h2>
                                            </td>
                                        @else
                                            <td colspan="2" class="p-0">&nbsp;</td>
                                        @endif
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7" class="bg-light">
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
