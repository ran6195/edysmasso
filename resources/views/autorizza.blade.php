<x-app-layout>
    <?php
    $siti = App\Models\Site::where('J4', 1)->get();
    $users = App\Models\User::where('admin', 0)->get();
    
    $siti_con_autorizzazioni = App\Models\Site::all()->filter(function ($i) {
        return $i->utenti->count() > 0;
    });
    
    ?>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('main.autorizza') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-6 px-2 text-gray-900">

                    <div class="">

                        <div x-data="{
                            async autorizza() {
                                user_id = document.querySelector('#user').value
                                site_id = document.querySelector('#siti').value
                        
                                let r = await axios.post('/authUser', { user_id: user_id, site_id: site_id })
                        
                                alert(r.data.messaggio)
                        
                        
                            }
                        }" class="grid grid-cols-3 gap-2">
                            <x-form.select name="user" :options="$users" option_caption="name" />
                            <x-form.select name="siti" :options="$siti" option_caption="domainName" />
                            <x-primary-button @click="autorizza()">Autorizza</x-primary-button>
                        </div>

                        <div class="mt-10 p-6 text-gray-900">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Sito</th>
                                        <th scope="col" class="px-6 py-3">Utenti Autorizzati</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($siti_con_autorizzazioni as $item)
                                        <tr
                                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            <td class="px-6 py-4">
                                                {{ $item->domainName }}
                                            </td>
                                            <td>
                                                @foreach ($item->utenti as $i)
                                                    <span
                                                        class="px-2 py-2 rounded-md mx-1 bg-slate-800 font-semibold text-white">{{ $i->name }}
                                                    </span>
                                                @endforeach

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>


                    </div>


                </div>
            </div>
        </div>
    </div>





</x-app-layout>
