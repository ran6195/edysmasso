<x-app-layout>
    <?php
    $siti = App\Models\Site::where('J4', 1)->get();
    $users = App\Models\User::where('admin', 0)->get();
    
    $siti_con_autorizzazioni = App\Models\Site::all()
        ->filter(function ($i) {
            return $i->utenti->count() > 0;
        })
        ->toArray();
    
    ?>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('main.autorizza2') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-6 px-2 text-gray-900">


                    <table class="w-1/4  border-separate border-spacing-1" x-data="{
                        async autorizza(user_id, site_id, e) {
                                axios.post('/toggleAuthUser', { site_id: site_id, user_id: user_id })
                                    .then(r => {
                                        if (r.data) {
                                            console.log(r.data)
                                            e.classList.add('bg-blue-400')
                    
                                        } else {
                                            e.classList.remove('bg-blue-400')
                                        }
                                    })
                                    .catch(e => console.log(e))
                            },
                            autorizza_tutti_sito(site_id) {
                                let el = document.querySelectorAll(`[data-sito='${site_id}']`)
                                el.forEach(e => e.click())
                            },
                    
                            abilita_utente(user_id) {
                                let el = document.querySelectorAll(`[data-user='${user_id}']`)
                                el.forEach(e => e.click())
                            }
                    
                    }">
                        <thead>
                            <tr>
                                <th class="py-7"></th>
                                @foreach ($users as $u)
                                    <th x-on:click="abilita_utente({{ $u->id }})"
                                        class="py-7 cursor-pointer bg-slate-100 hover:bg-gray-300 transition-all ease-in-out duration-300 rounded-md">
                                        <div class="-rotate-90">{{ $u->name }}</div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($siti as $sito)
                                <tr>
                                    <td x-on:click="autorizza_tutti_sito({{ $sito->id }})"
                                        class="text-right px-2 cursor-pointer rounded-md hover:bg-gray-300 bg-slate-100 font-semibold text-slate-700 transition-all">
                                        {{ $sito->domainName }}</td>
                                    @foreach ($users as $u)
                                        @php

                                        @endphp
                                        <td data-tooltip-target="tooltip-default{{ $u->id }}{{ $sito->id }}"
                                            data-sito="{{ $sito->id }}" data-user="{{ $u->id }}"
                                            x-on:click="autorizza({{ $u->id }},{{ $sito->id }},$el)"
                                            @if (in_array($u->id, $sito->utenti->pluck('id')->toArray())) class="text-center cursor-pointer rounded-full hover:bg-gray-300 bg-blue-400 transition-all" @endif
                                            class="cursor-pointer rounded-full hover:bg-gray-300 transition-all ease-in-out delay-100 duration-300">

                                            <div id="tooltip-default{{ $u->id }}{{ $sito->id }}"
                                                role="tooltip"
                                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-md shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                <span class="font-extrabold">{{ $sito->domainName }}</span> <br>
                                                @if (in_array($u->id, $sito->utenti->pluck('id')->toArray()))
                                                    disattiva:
                                                @else
                                                    attiva:
                                                @endif{{ $u->name }}

                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach

                        </tbody>
                    </table>



                </div>
            </div>
        </div>
    </div>


    <x-modal name="autorizza"></x-modal>





</x-app-layout>
