<x-filament-widgets::widget>
    <div class="w-full flex flex-col min-h-[100px] items-center justify-between gap-4 bg-white px-6 py-4 rounded-xl border-slate-200 border shadow-sm">
        <div class="w-full flex items-center justify-between">
            <h1 class="text-xl font-medium">Hi there <span class="capitalize">{{ $user->name }}</span>!</h1>
            <span class="font-medium text-xl">{{ $currentTime->format('l - M d, Y') }}</span>
        </div>
        
      
        <div class="w-full flex justify-between items-center gap-1 bg-gradient-to-br from-sky-600 to-sky-900 text-white rounded-md divide-x divide-white ">
            <div href="{{route('filament.admin.resources.fsrs.create')}}"
            wire:navigate class="w-full text-nowrap text-center cursor-pointer text-sm font-bold ">
            <span>+</span>
            <span>Add FSR</span>
            </div>
            <div href="{{route('filament.admin.resources.projects.create')}}"
            wire:navigate class="w-full text-nowrap text-center cursor-pointer text-sm font-bold">
            <span>+</span>
            <span>Add Project</span>
            
        </div>
            <div href="{{route('filament.admin.resources.dbe-personnels.create')}}"
            wire:navigate class="w-full text-nowrap text-center cursor-pointer text-sm font-bold">
            <span>+</span>
            <span>Add DBE Personnel</span>
            
        </div>
           
        
        </div>
    </div>
</x-filament-widgets::widget>
