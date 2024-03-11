<x-app-layout>
    <?php
    $siti = App\Models\Site::where('J4', 1)->get();
    
    ?>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('main.report_utenti') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-6 px-2 text-gray-900">



                    <table class="table w-full" x-data="{
                        async init() {
                            let el = document.querySelectorAll(`[data-site]`)
                    
                            el.forEach(async el => {
                                let r = await axios.post('listaUtenti', { site_id: el.dataset.site })
                                r = r.data
                                if (r.length) {
                                    let h = `<div class='grid grid-flow-row grid-cols-6 gap-2'>`
                                    r.forEach(e => {
                                        h += `<div class='text-wrap p-2 text-center bg-slate-700 text-white font-semibold rounded-md'>${e.attributes.username}</div>`
                                    })
                                    el.innerHTML = h + '</div>'
                                } else {
                                    el.innerHTML = `<div class='text-wrap p-2 text-center bg-red-700 text-white font-semibold rounded-md'>Si è verificato un errore</div>`
                                }
                            })
                        }
                    }">
                        <thead>
                            <tr class="table-row">
                                <th class="text-right">Sito</th>
                                <th>Lista Utenti</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($siti as $sito)
                                <tr class="text-right table-row">

                                    <th class="w-[6%]">{{ $sito->domainName }}</th>

                                    <td data-site="{{ $sito->id }}" class="table-cell p-2 text-left"></td>
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
