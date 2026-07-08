@if(session('success') || $errors->any())
    <div class="fixed right-4 top-4 z-50 space-y-3">
        @if(session('success'))
            <div data-toast class="surface flex min-w-80 items-start justify-between gap-4 px-4 py-4">
                <div>
                    <p class="text-sm font-semibold text-teal-700 dark:text-teal-300">Success</p>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">{{ session('success') }}</p>
                </div>
                <button type="button" data-toast-dismiss class="text-slate-400">×</button>
            </div>
        @endif

        @if($errors->any())
            <div data-toast class="surface flex min-w-80 items-start justify-between gap-4 px-4 py-4">
                <div>
                    <p class="text-sm font-semibold text-orange-700 dark:text-orange-300">Please review the form</p>
                    <ul class="mt-1 space-y-1 text-sm text-slate-600 dark:text-slate-300">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" data-toast-dismiss class="text-slate-400">×</button>
            </div>
        @endif
    </div>
@endif
