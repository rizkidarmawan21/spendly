<form x-ref="accountForm" method="post" :action="isEdit ? '{{ url('') }}' + '/account/' + selectedData.id : ''"
    class="min-w-[400px] space-y-5">
    @csrf
    <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">
    <div class="flex w-full flex-col gap-1 text-neutral-600 dark:text-neutral-300">
        <label for="code" class="w-fit pl-0.5 text-sm flex gap-2">Code
            <x-tooltip title="Code" content="Will be generate by system if no set" position="right" />
        </label>
        <input id="code" type="number"
            class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-700 dark:bg-neutral-900/50 dark:focus-visible:outline-white"
            name="code" placeholder="Enter code" :value="selectedData ? selectedData.code : ''" />

        <x-input-error :messages="$errors->get('code')" for="code" />
    </div>

    <div class="flex w-full flex-col gap-1 text-neutral-600 dark:text-neutral-300">
        <label for="category_id" class="w-fit pl-0.5 text-sm">Account Category*</label>
        <select id="category_id" name="category_id"
            class="w-full appearance-none rounded-md border border-neutral-300 bg-neutral-50 px-4 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-700 dark:bg-neutral-900/50 dark:focus-visible:outline-white">
            <option value="" >Please Select</option>
            @forelse ($categories as $item)
                <option value="{{ $item->id }}"
                    :selected="selectedData ? selectedData.category_id === {{ $item->id }} : ''">
                    {{ $item->name }}
                </option>
            @empty
                <option disabled>No data record</option>
            @endforelse
        </select>

        <x-input-error :messages="$errors->get('category_id')" for="name" />
    </div>

    <div class="flex w-full flex-col gap-1 text-neutral-600 dark:text-neutral-300">
        <label for="name" class="w-fit pl-0.5 text-sm">Account name*</label>
        <input id="name" type="text"
            class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-700 dark:bg-neutral-900/50 dark:focus-visible:outline-white"
            name="name" placeholder="Enter account name" :value="selectedData ? selectedData.name : ''" />

        <x-input-error :messages="$errors->get('name')" for="name" />
    </div>
</form>
