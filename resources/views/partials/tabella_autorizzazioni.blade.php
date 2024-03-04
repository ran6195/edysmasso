<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">Sito</th>
            <th scope="col" class="px-6 py-3">Utenti Autorizzati</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($righe as $item)
            <tr
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td class="px-6 py-4">
                    {{ $item['domainName'] }}
                </td>
                <td>
                    @foreach (App\Models\Site::find($item['id'])->utenti as $i)
                        <span class="px-2 py-2 rounded-md mx-1 bg-slate-800 font-semibold text-white">{{ $i->name }}
                        </span>
                    @endforeach

                </td>
            </tr>
        @endforeach
    </tbody>

</table>
