@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"></path>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif

@if(session('warning'))
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg mb-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8.257 3.099c.765-1.36 2.453-1.706 3.682-.602l.006.006c1.369 1.233 1.544 3.349.572 4.805l-.012.012c-.982 1.37-2.298 2.459-3.86 3.001l-.029.01c-1.392.48-2.575-.337-3.17-1.236l-.005-.009c-.53-.81-.247-1.95.573-2.028.8-.078 1.14.632 1.207 1.268l.004.018c.1.98.583 1.85 1.405 2.295l.027.014c1.21.51 2.57-.07 3.03-1.18l.002-.006c.34-.82.11-1.88-.598-2.4-.63-.46-1.11.04-1.59.16l-.005.001c-.38.1-.79-.05-1.05-.33-.28-.3-.33-.73-.15-1.1l.01-.02c.38-.78 1.17-1.21 1.93-1.14l.02-.002c.35.03.68-.04.97-.18.27-.13.51-.32.68-.57l.003-.005c.35-.5.28-1.21-.15-1.63-.39-.4-.95-.52-1.44-.38l-.01.002c-.78.22-1.29.93-1.46 1.68l-.001.012c-.17.75.25 1.5.95 1.75l.02.006c.5.17.7.78.4 1.21l-.01.015c-.38.55-.22 1.35.33 1.74l.01.008c.5.36.6 1.05.24 1.55l-.008.012c-.48.67-.52 1.61-.08 2.31l.01.02c.43.7.43 1.6.08 2.34l-.01.02c-.55 1.18.12 2.18 1.08 2.62l.02.008c1.25.57 2.88.04 3.48-1.13l.005-.012c.56-1.07.4-2.36-.42-3.19l-.01-.01c-.56-.56-.75-1.4-.47-2.15l.01-.03c.36-.98.16-2.1-.52-2.84l-.01-.01c-.77-.85-1.2-2.01-.97-3.18l.01-.03c.32-1.65-.48-3.33-1.94-4.28z"></path>
            </svg>
            <span>{{ session('warning') }}</span>
        </div>
    </div>
@endif

@if(session('info'))
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg mb-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"></path>
            </svg>
            <span>{{ session('info') }}</span>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
        <div class="flex items-center mb-2">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"></path>
            </svg>
            <span class="font-semibold">Please fix the following errors:</span>
        </div>
        <ul class="list-disc list-inside ml-7">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</parameter>
<parameter name="task_progress">
- [x] Create 404 error page
- [x] Create 403 error page
- [x] Create flash messages component
- [ ] Test error handling
- [ ] Complete validation implementation
</parameter>
</write_to_file>