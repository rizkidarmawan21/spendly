<!-- Notifications -->
<div x-data="{
    notifications: [],
    displayDuration: 8000,
    soundEffect: true,
    init() {
        @if (session('notification'))
            this.addNotification({
                variant: '{{ session('notification')['variant'] }}',
                title: '{{ session('notification')['title'] }}',
                message: '{{ session('notification')['message'] }}'
            });
        @endif
    },
    addNotification({ variant = 'info', sender = null, title = null, message = null }) {
        const id = Date.now()
        const notification = { id, variant, sender, title, message }

        // Keep only the most recent 20 notifications
        if (this.notifications.length >= 20) {
            this.notifications.splice(0, this.notifications.length - 19)
        }

        // Add the new notification to the notifications stack
        this.notifications.push(notification)

        if (this.soundEffect) {
            // Play the notification sound
            const notificationSound = new Audio('https://res.cloudinary.com/ds8pgw1pf/video/upload/v1728571480/penguinui/component-assets/sounds/ding.mp3')
            notificationSound.play().catch((error) => {
                console.error('Error playing the sound:', error)
            })
        }
    },
    removeNotification(id) {
        setTimeout(() => {
            this.notifications = this.notifications.filter(
                (notification) => notification.id !== id,
            )
        }, 400);
    },
}"
    x-on:notify.window="addNotification({
            variant: $event.detail.variant,
            sender: $event.detail.sender,
            title: $event.detail.title,
            message: $event.detail.message,
        })">

    <div x-on:mouseenter="$dispatch('pause-auto-dismiss')" x-on:mouseleave="$dispatch('resume-auto-dismiss')"
        class="group pointer-events-none fixed inset-x-8 top-0 z-[99] flex max-w-full flex-col gap-2 bg-transparent px-6 py-6 md:bottom-0 md:left-[unset] md:right-0 md:top-[unset] md:max-w-sm">
        <template x-for="(notification, index) in notifications" x-bind:key="notification.id">
            <!-- root div holds all of the notifications  -->
            <div>
                <!-- Info Notification  -->
                <template x-if="notification.variant === 'info'">
                    <div x-data="{ isVisible: false, timeout: null }" x-cloak x-show="isVisible"
                        class="pointer-events-auto relative rounded-md border border-sky-500 bg-white text-neutral-600 dark:bg-neutral-950 dark:text-neutral-300"
                        role="alert" x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                        x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => {(isVisible = false), removeNotification(notification.id) }, displayDuration)"
                        x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id) }, displayDuration))" x-transition:enter="transition duration-300 ease-out"
                        x-transition:enter-end="translate-y-0" x-transition:enter-start="translate-y-8"
                        x-transition:leave="transition duration-300 ease-in"
                        x-transition:leave-end="-translate-x-24 opacity-0 md:translate-x-24"
                        x-transition:leave-start="translate-x-0 opacity-100">
                        <div
                            class="flex w-full items-center gap-2.5 bg-sky-500/10 rounded-md p-4 transition-all duration-300">

                            <!-- Title & Message -->
                            <div class="flex flex-col gap-2">
                                <h3 x-cloak x-show="notification.title" class="text-sm font-semibold text-sky-500"
                                    x-text="notification.title"></h3>
                                <p x-cloak x-show="notification.message" class="text-pretty text-sm"
                                    x-text="notification.message"></p>
                            </div>

                            <!--Dismiss Button -->
                            <button type="button" class="ml-auto" aria-label="dismiss notification"
                                x-on:click="(isVisible = false), removeNotification(notification.id)">
                                <svg xmlns="http://www.w3.org/2000/svg viewBox="0 0 24 24 stroke="currentColor"
                                    fill="none" stroke-width="2" class="size-5 shrink-0" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Success Notification  -->
                <template x-if="notification.variant === 'success'">
                    <div x-data="{ isVisible: false, timeout: null }" x-cloak x-show="isVisible"
                        class="pointer-events-auto relative rounded-md border border-green-500 bg-white text-neutral-600 dark:bg-neutral-950 dark:text-neutral-300"
                        role="alert" x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                        x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => {(isVisible = false), removeNotification(notification.id) }, displayDuration)"
                        x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id) }, displayDuration))" x-transition:enter="transition duration-300 ease-out"
                        x-transition:enter-end="translate-y-0" x-transition:enter-start="translate-y-8"
                        x-transition:leave="transition duration-300 ease-in"
                        x-transition:leave-end="-translate-x-24 opacity-0 md:translate-x-24"
                        x-transition:leave-start="translate-x-0 opacity-100">
                        <div
                            class="flex w-full items-center gap-2.5 bg-green-500/10 rounded-md p-4 transition-all duration-300">

                            <!-- Title & Message -->
                            <div class="flex flex-col gap-2">
                                <h3 x-cloak x-show="notification.title" class="text-sm font-semibold text-green-500"
                                    x-text="notification.title"></h3>
                                <p x-cloak x-show="notification.message" class="text-pretty text-sm"
                                    x-text="notification.message"></p>
                            </div>

                            <!--Dismiss Button -->
                            <button type="button" class="ml-auto" aria-label="dismiss notification"
                                x-on:click="(isVisible = false), removeNotification(notification.id)">
                                <svg xmlns="http://www.w3.org/2000/svg viewBox="0 0 24 24 stroke="currentColor"
                                    fill="none" stroke-width="2" class="size-5 shrink-0" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Warning Notification  -->
                <template x-if="notification.variant === 'warning'">
                    <div x-data="{ isVisible: false, timeout: null }" x-cloak x-show="isVisible"
                        class="pointer-events-auto relative rounded-md border border-amber-500 bg-white text-neutral-600 dark:bg-neutral-950 dark:text-neutral-300"
                        role="alert" x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                        x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => {(isVisible = false), removeNotification(notification.id) }, displayDuration)"
                        x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id) }, displayDuration))" x-transition:enter="transition duration-300 ease-out"
                        x-transition:enter-end="translate-y-0" x-transition:enter-start="translate-y-8"
                        x-transition:leave="transition duration-300 ease-in"
                        x-transition:leave-end="-translate-x-24 opacity-0 md:translate-x-24"
                        x-transition:leave-start="translate-x-0 opacity-100">
                        <div
                            class="flex w-full items-center gap-2.5 bg-amber-500/10 rounded-md p-4 transition-all duration-300">

                            <!-- Title & Message -->
                            <div class="flex flex-col gap-2">
                                <h3 x-cloak x-show="notification.title" class="text-sm font-semibold text-amber-500"
                                    x-text="notification.title"></h3>
                                <p x-cloak x-show="notification.message" class="text-pretty text-sm"
                                    x-text="notification.message"></p>
                            </div>

                            <!--Dismiss Button -->
                            <button type="button" class="ml-auto" aria-label="dismiss notification"
                                x-on:click="(isVisible = false), removeNotification(notification.id)">
                                <svg xmlns="http://www.w3.org/2000/svg viewBox="0 0 24 24 stroke="currentColor"
                                    fill="none" stroke-width="2" class="size-5 shrink-0" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Danger Notification  -->
                <template x-if="notification.variant === 'danger'">
                    <div x-data="{ isVisible: false, timeout: null }" x-cloak x-show="isVisible"
                        class="pointer-events-auto relative rounded-md border border-red-500 bg-white text-neutral-600 dark:bg-neutral-950 dark:text-neutral-300"
                        role="alert" x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                        x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => {(isVisible = false), removeNotification(notification.id) }, displayDuration)"
                        x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id) }, displayDuration))" x-transition:enter="transition duration-300 ease-out"
                        x-transition:enter-end="translate-y-0" x-transition:enter-start="translate-y-8"
                        x-transition:leave="transition duration-300 ease-in"
                        x-transition:leave-end="-translate-x-24 opacity-0 md:translate-x-24"
                        x-transition:leave-start="translate-x-0 opacity-100">
                        <div
                            class="flex w-full items-center gap-2.5 bg-red-500/10 rounded-md p-4 transition-all duration-300">

                            <!-- Title & Message -->
                            <div class="flex flex-col gap-2">
                                <h3 x-cloak x-show="notification.title" class="text-sm font-semibold text-red-500"
                                    x-text="notification.title"></h3>
                                <p x-cloak x-show="notification.message" class="text-pretty text-sm"
                                    x-text="notification.message"></p>
                            </div>

                            <!--Dismiss Button -->
                            <button type="button" class="ml-auto" aria-label="dismiss notification"
                                x-on:click="(isVisible = false), removeNotification(notification.id)">
                                <svg xmlns="http://www.w3.org/2000/svg viewBox="0 0 24 24 stroke="currentColor"
                                    fill="none" stroke-width="2" class="size-5 shrink-0" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Message Notification  -->
                <template x-if="notification.variant === 'message'">
                    <div x-data="{ isVisible: false, timeout: null }" x-cloak x-show="isVisible"
                        class="pointer-events-auto relative rounded-md border border-neutral-300 bg-white text-neutral-600 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-300"
                        role="alert" x-on:pause-auto-dismiss.window="clearTimeout(timeout)"
                        x-on:resume-auto-dismiss.window="timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id) }, displayDuration)"
                        x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id) }, displayDuration))" x-transition:enter="transition duration-300 ease-out"
                        x-transition:enter-end="translate-y-0" x-transition:enter-start="translate-y-8"
                        x-transition:leave="transition duration-300 ease-in"
                        x-transition:leave-end="-translate-x-24 opacity-0 md:translate-x-24"
                        x-transition:leave-start="translate-x-0 opacity-100">
                        <div
                            class="flex w-full rounded-md items-center gap-2.5 bg-neutral-50 p-4 transition-all duration-300 dark:bg-neutral-900">
                            <div class="flex w-full items-center gap-2.5">

                                <!-- Avatar -->
                                <img x-cloak x-show="notification.sender.avatar" class="mr-2 size-12 rounded-full"
                                    alt="avatar" aria-hidden="true" x-bind:src="notification.sender.avatar" />
                                <div class="flex flex-col items-start gap-2">
                                    <!-- Title & Message -->
                                    <h3 x-cloak x-show="notification.sender.name"
                                        class="text-sm font-semibold text-neutral-900 dark:text-white"
                                        x-text="notification.sender.name"></h3>
                                    <p x-cloak x-show="notification.message" class="text-pretty text-sm"
                                        x-text="notification.message"></p>

                                    <!-- Action Buttons -->
                                    <div class="flex items-center gap-4">
                                        <button type="button"
                                            class="cursor-pointer whitespace-nowrap bg-transparent text-center text-sm font-bold tracking-wide text-black transition hover:opacity-75 active:opacity-100 dark:text-white">Reply</button>
                                        <button type="button"
                                            class="cursor-pointer whitespace-nowrap bg-transparent text-center text-sm font-bold tracking-wide text-neutral-600 transition hover:opacity-75 active:opacity-100 dark:text-neutral-300"
                                            x-on:click=" (isVisible = false), setTimeout(() => { removeNotification(notification.id) }, 400)">Dismiss</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Dismiss Button -->
                            <button type="button" class="ml-auto" aria-label="dismiss notification"
                                x-on:click="(isVisible = false), removeNotification(notification.id)">
                                <svg xmlns="http://www.w3.org/2000/svg viewBox="0 0 24 24 stroke="currentColor"
                                    fill="none" stroke-width="2" class="size-5 shrink-0" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>

            </div>
        </template>
    </div>
</div>