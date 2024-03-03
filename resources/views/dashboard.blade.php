<x-app-layout>
    <?php
    if (Auth::user()->admin) {
        $siti = App\Models\Site::where('J4', 1)->paginate(15);
    } else {
        $siti = Auth::user()->siti;
    
        $siti = App\Helpers\PaginationHelper::paginate($siti, 15);
    }
    
    ?>



    <br>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('main.login_ok') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (method_exists($siti, 'links'))
                        <div class="mb-5">{{ $siti->links() }}</div>
                    @endif


                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>

                                    <th scope="col" class="px-6 py-3">
                                        URL
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Admin
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Token
                                    </th>
                                    <th scope="col" class="px-6 py-3">

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siti as $sito)
                                    <tr
                                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">

                                        <td class="px-6 py-4">
                                            <a href="https://{{ $sito->domainName }}"
                                                target="_blank">https://{{ $sito->domainName }}</a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="https://{{ $sito->domainName }}/administrator"
                                                target="_blank">https://{{ $sito->domainName }}/administrator</a>
                                        </td>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ Str::limit($sito->token, 20) }}
                                        </th>

                                        <td x-data="{
                                            user_id: {{ Auth::user()->id }},
                                            async creaUtenteJoomla(site_id, event) {
                                        
                                                //console.log(site_id, this.user_id, event.target)
                                        
                                                let r = await axios.post('/creautente', { site_id: site_id })
                                        
                                                data = r.data
                                                if (data.status == 500) {
                                                    alert(`Errore sul server: ${JSON.parse(data.body)['errors']['title']}`)
                                                } else if (data.status == 401) {
                                                    alert(`Errore di autenticazione: ${JSON.parse(data.body)['errors'][0]['title']}\nControlla il token`)
                                                } else if (data.status == 200) {
                                                    alert(`La chiamata ha avuto successo`)
                                        
                                                    //event.target.setAttribute('disabled', true)
                                                } else if (data.status == 400) {
                                                    alert(`Si è verificato un errore: ${JSON.parse(data.body)['errors'][0]['title']}`)
                                                }
                                        
                                            }
                                        }" class="px-6 py-4 cursor-pointer">

                                            @if (Auth::user()->admin)
                                                Edit
                                            @else
                                                <button @click="creaUtenteJoomla({{ $sito->id }}, $event )"
                                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                                    Accedi
                                                </button>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>


                    </div>
                    @if (method_exists($siti, 'links'))
                        <div class="mt-5">{{ $siti->links() }}</div>
                    @endif



                </div>
            </div>
        </div>
    </div>
</x-app-layout>
