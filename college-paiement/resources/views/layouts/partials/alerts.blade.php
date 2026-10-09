{{-- resources/views/partials/alerts.blade.php --}}
@if(session('success'))
<div class="alert-auto mb-4 bg-green-50 border-l-4 border-green-500 p-4 flex justify-between items-start">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-check-circle text-green-500 text-lg"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    </div>
    <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert-auto mb-4 bg-red-50 border-l-4 border-red-500 p-4 flex justify-between items-start">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
    </div>
    <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

@if(session('warning'))
<div class="alert-auto mb-4 bg-yellow-50 border-l-4 border-yellow-500 p-4 flex justify-between items-start">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-triangle text-yellow-500 text-lg"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-yellow-700">{{ session('warning') }}</p>
        </div>
    </div>
    <button onclick="this.parentElement.remove()" class="text-yellow-500 hover:text-yellow-700">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

@if(session('info'))
<div class="alert-auto mb-4 bg-blue-50 border-l-4 border-blue-500 p-4 flex justify-between items-start">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-info-circle text-blue-500 text-lg"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-blue-700">{{ session('info') }}</p>
        </div>
    </div>
    <button onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-700">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

@if($errors->any())
<div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-times-circle text-red-500 text-lg"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</p>
            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif