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
                        
                                let h = await axios.post('tabella_autorizzazioni', {
                                    righe: '',
                                })
                        
                        
                                container_tabella_aut.innerHTML = h.data
                                alert(r.data.messaggio)
                        
                                //dispatchEvent(new CustomEvent('open-modal', { detail: 'autorizza' }))
                            }
                        }" class="grid grid-cols-3 gap-2">
                            <x-form.select name="user" :options="$users" option_caption="name" />
                            <x-form.select name="siti" :options="$siti" option_caption="domainName" />
                            <x-primary-button @click="autorizza()">Autorizza</x-primary-button>
                        </div>

                        <div x-data="{
                            html: '',
                            async init() {
                                let r = await axios.post('tabella_autorizzazioni', {
                                    righe: {{ json_encode($siti_con_autorizzazioni) }}
                                })
                        
                        
                                this.html = r.data
                        
                            }
                        }" x-html="html"
                            class="relative overflow-x-auto shadow-md sm:rounded-lg mt-10" id="container_tabella_aut">

                        </div>


                    </div>


                </div>
            </div>
        </div>
    </div>


    <x-modal name="autorizza"></x-modal>





</x-app-layout>
