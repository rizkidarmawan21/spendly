<x-modal name="confirm-transaction-deletion" focusable>

    <form x-data="{ selectedId: null }" x-on:selected-id.window="selectedId = $event.detail.id" method="post"
        :action="`/transaction/${selectedId}`" class="p-6">
        @csrf
        @method('DELETE')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Are you sure you want to delete this transaction?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('This action cannot be undone, and related data will also be deleted. Please confirm the deletion.') }}
        </p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Delete Data') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
