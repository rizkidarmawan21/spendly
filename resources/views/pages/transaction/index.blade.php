<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ modalIsOpen: {{ $errors->any() ? 'true' : 'false' }}, isEdit: false, selectedData: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-5">
                    <button @click="modalIsOpen = true; selectedData=null" type="button"
                        class="bg-sky-500 hover:bg-sky-700 text-white font-semibold py-2 px-4 rounded">
                        Add Transaction
                    </button>
                    <div class="overflow-x-auto">
                        <table
                            class="min-w-full border-collapse border border-gray-300 bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">#</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Date</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Account</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Description</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Amount</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($transactions as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $item->date }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <strong>{{ $item->account->name }}</strong><br>
                                            <i>{{ $item->account->code }} - {{ $item->account->category->type }}</i>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $item->desciption ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            Rp. {{ number_format($item->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4">

                                            <button class="text-blue-600 hover:underline"
                                                @click="modalIsOpen = true; isEdit = true; selectedData= {{ $item }} ">
                                                Edit
                                            </button>
                                            <button class="ml-2 text-red-600 hover:underline"
                                                data-id="{{ $item->id }}"
                                                onclick="openModal(event)">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-10 text-center" colspan="6">
                                            No data record
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        @include('pages.transaction.modal')
        @include('pages.transaction.partials.delete')
    </div>

    <script>
        function openModal(e) {
            e.preventDefault();
            const button = e.target;
            const id = button.getAttribute('data-id');
            button.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'confirm-transaction-deletion',
                bubbles: true
            }));
            button.dispatchEvent(new CustomEvent('selected-id', {
                detail: {
                    id: id
                },
                bubbles: true
            }));

        }
    </script>

</x-app-layout>
