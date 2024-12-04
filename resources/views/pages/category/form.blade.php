<form x-ref="categoryForm" method="post" class="min-w-96 space-y-5">
    @csrf
    @method('POST')
    <div class="flex w-full flex-col gap-1 text-neutral-600 dark:text-neutral-300">
        <label for="name" class="w-fit pl-0.5 text-sm">Account Category*</label>
        <input id="name" type="text"
            class="w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-700 dark:bg-neutral-900/50 dark:focus-visible:outline-white"
            name="name" placeholder="Enter account category" />

        <x-input-error :messages="$errors->get('name')" for="name" />
    </div>

    <div class="relative flex w-full flex-col gap-1 text-neutral-600 dark:text-neutral-300">
        <label for="type" class="w-fit pl-0.5 text-sm">Account Type*</label>
        <select id="type" name="type"
            class="w-full appearance-none rounded-md border border-neutral-300 bg-neutral-50 px-4 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-700 dark:bg-neutral-900/50 dark:focus-visible:outline-white">
            <option selected>Please Select</option>
            <option value="debit">Debit</option>
            <option value="credit">Credit</option>
        </select>

        <x-input-error :messages="$errors->get('type')" for="type" />
    </div>
</form>
