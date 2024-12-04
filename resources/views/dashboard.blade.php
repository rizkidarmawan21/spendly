<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-3">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold">Reports ✨</h3>

                        <div x-data="handleFilter()"
                            class="relative flex w-1/6 flex-col gap-1 text-neutral-600 dark:text-neutral-300">
                            <label for="type" class="w-fit pl-0.5 text-sm">Filter By</label>
                            <select id="type" name="type"
                                class="w-full appearance-none rounded-md border border-neutral-300 bg-neutral-50 px-4 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-700 dark:bg-neutral-900/50 dark:focus-visible:outline-white"
                                x-model="filter" @change="handleFilter()">
                                <option value="">Please Select</option>
                                <option value="week" :selected="selectedFilter === 'week'">This Week</option>
                                <option value="month" :selected="selectedFilter === 'month'">This Month</option>
                                <option value="year" :selected="selectedFilter === 'year'">This Year</option>
                            </select>

                            <x-input-error :messages="$errors->get('type')" for="type" />
                        </div>

                    </div>

                    <div class="overflow-x-auto">

                        <table
                            class="min-w-full border-collapse border border-gray-300 bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-100 border divide-y">
                                <tr>
                                    <th scope="col" class="px-2 py-1 font-medium text-gray-900 border"
                                        rowspan="2">
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
                                    <tr
                                        class="hover:bg-gray-50 {{ $value['type'] !== 'total_credit' ? 'bg-teal-50' : 'bg-teal-100' }}">
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
                                    <tr
                                        class="hover:bg-gray-50 {{ $value['type'] !== 'total_debit' ? 'bg-rose-50' : 'bg-rose-100' }}">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function handleFilter() {
            return {
                filter: 'week',
                selectedFilter: new URLSearchParams(window.location.search).get('filter') || 'week',

                // watch filter changes
                handleFilter() {
                    // redirect to the selected filter
                    window.location.href = `?filter=${this.filter}`;
                }
            }
        }
    </script>
</x-app-layout>
