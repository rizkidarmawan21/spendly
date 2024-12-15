<form x-ref="transactionForm" method="post"
    :action="isEdit ? '{{ url('') }}' + '/transaction/' + selectedData.id : ''" class="min-w-[400px] space-y-5">
    @csrf
    <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">

    <div x-data="accountSelect()" class="flex w-full flex-col gap-1 text-neutral-600 dark:text-neutral-300">
        <label for="account_id" class="w-fit pl-0.5 text-sm">Account*</label>
        <select id="account_id" name="account_id"
            class="w-full appearance-none rounded-md border border-neutral-300 bg-neutral-50 px-4 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-700 dark:bg-neutral-900/50 dark:focus-visible:outline-white"
            x-model="selectedAccount" @change="updateAccountDetails()" :readonly="isEdit">
            <option value="">Please Select</option>
            @forelse ($accounts as $item)
                <optgroup label="{{ $item->name }}">
                    @foreach ($item->account as $account)
                        <option value="{{ $account->id }}"
                            :selected="selectedData ? selectedData.account_id === {{ $account->id }} : ''">
                            {{ $account->code }} - {{ $account->name }}
                        </option>
                    @endforeach
                </optgroup>
            @empty
                <option disabled>No data record</option>
            @endforelse
        </select>
        <span class="text-sm italic" x-text="accountDetails ? `Type: ${accountDetails.category.type}` : ''"></span>

        <x-input-error :messages="$errors->get('account_id')" for="account_id" />
    </div>

    <div class="flex w-full flex-col gap-1 text-neutral-600 dark:text-neutral-300">
        <label for="description" class="w-fit pl-0.5 text-sm">Description</label>
        <textarea id="description"
            class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2.5 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-700 dark:bg-neutral-900/50 dark:focus-visible:outline-white"
            rows="3" placeholder="Enter description" :value="selectedData ? selectedData.description : ''"></textarea>

        <x-input-error :messages="$errors->get('description')" for="description" />
    </div>

    <div class="flex w-full flex-col gap-1 text-neutral-600 dark:text-neutral-300">
        <label for="date" class="w-fit pl-0.5 text-sm">Date</label>
        <input id="date" type="date"
            class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-700 dark:bg-neutral-900/50 dark:focus-visible:outline-white"
            name="date" placeholder="Enter date" :value="selectedData ? selectedData.date : ''" />

        <x-input-error :messages="$errors->get('date')" for="date" />
    </div>
    <div x-data="{ amount: null }" class="flex w-full flex-col gap-1 text-neutral-600 dark:text-neutral-300">
        <label for="amount" class="w-fit pl-0.5 text-sm">Amount*</label>
        <input id="amount" type="number" min="0" x-model="amount"
            class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-700 dark:bg-neutral-900/50 dark:focus-visible:outline-white"
            name="amount" placeholder="Rp." :value="selectedData ? selectedData.amount : ''" />

        <span class="text-sm italic"
            x-text="new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount ?? 0)"></span>
        <x-input-error :messages="$errors->get('amount')" for="amount" />
    </div>
</form>

<script>
    function accountSelect() {
        return {
            selectedAccount: null,
            accountDetails: null,
            updateAccountDetails() {
                const selectedAccountId = this.selectedAccount;
                const account = @json($accounts).find(account => account.id == selectedAccountId);

                this.accountDetails = account ? account : null;

            }
        };
    }
</script>
