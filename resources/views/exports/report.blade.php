<table class="min-w-full border-collapse border border-gray-300 bg-white text-left text-sm text-gray-500">
    <thead class="bg-gray-100 border divide-y">
        <tr>
            <th class="px-3 py-5 capitalize" colspan="2">
                Filter by this {{ $filterBy }}
            </th>
        </tr>
        <tr>
            <th scope="col" class="px-2 py-1 font-medium text-gray-900 border" rowspan="2">
                Category</th>
            @foreach ($headers as $header)
                <th scope="col" class="px-2 py-1 font-medium text-gray-900 border">
                    {{ $header }}
                </th>
            @endforeach
        </tr>
        <tr>
            @foreach ($headers as $header)
                <th scope="col" class="px-2 py-1 font-medium text-gray-900 border">
                    Amount
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @foreach ($incomes as $key => $value)
            <tr class="hover:bg-gray-50 {{ $value['type'] !== 'total_credit' ? 'bg-teal-50' : 'bg-teal-100' }}">
                <td class="px-3 py-2">
                    {{ $key }}
                </td>
                @foreach ($value['data'] as $item => $value)
                    <td class="px-3 py-2">
                        Rp. {{ number_format($value, 0, ',', '.') }}
                    </td>
                @endforeach
            </tr>
        @endforeach
        @foreach ($expenses as $key => $value)
            <tr class="hover:bg-gray-50 {{ $value['type'] !== 'total_debit' ? 'bg-rose-50' : 'bg-rose-100' }}">
                <td class="px-3 py-2">
                    {{ $key }}
                </td>
                @foreach ($value['data'] as $item => $value)
                    <td class="px-3 py-2">
                        Rp. {{ number_format($value, 0, ',', '.') }}
                    </td>
                @endforeach
            </tr>
        @endforeach
        @foreach ($netIncome as $key => $value)
            <tr class="hover:bg-gray-50">
                <td class="px-3 py-2">
                    {{ $key }}
                </td>
                @foreach ($value['data'] as $item => $value)
                    <td class="px-3 py-2">
                        Rp. {{ number_format($value, 0, ',', '.') }}
                    </td>
                @endforeach
            </tr>
        @endforeach

    </tbody>
</table>
