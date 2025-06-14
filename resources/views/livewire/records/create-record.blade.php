<div class="w-full h-full flex flex-col">
    {{-- @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms x-init="setTimeout(() => show = false, 3000)"
            class="toast toast-top toast-center fixed z-50">
            <div class="alert alert-success flex items-center justify-between gap-4">
                <span>{{ session('message') }}</span>
                <button @click="show = false" class="text-white hover:text-red-400 text-lg font-bold">
                    &times;
                </button>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms x-init="setTimeout(() => show = false, 3000)"
            class="toast toast-top toast-center fixed z-50">
            <div class="alert alert-success flex items-center justify-between gap-4">
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="text-white hover:text-red-400 text-lg font-bold">
                    &times;
                </button>
            </div>
        </div>
    @endif --}}
    <button wire:click='export' class="btn btn-success">centres concernés</button>
    <div
        class="w-140 mt-2 mx-auto text-center border rounded text-3xl font-semibold p-2 hover:border-amber-400 shadow-2xl">
        ENREGISTREMENTS/ENTABLISSEMENTS
    </div>

    <div class="w-full h-full mt-20">
        <div class="w-full flex justify-center ">
            <p class="text-xl font-semibold">IMPORTER CENTRES DE L'ENREGSITREMENT @if (isset($period))
                DE:  {{\Carbon\Carbon::parse($period->period)->locale('fr')->translatedFormat('F')}} 
                    {{\Carbon\Carbon::parse($period->period)->translatedFormat('Y')}}
            @endif</p>
        </div>
        <form wire:submit.prevent="import"
            class="w-[50%] h-[40%] mx-auto flex shadow-2xl border-t-6 border-t-green-800">

            <fieldset class="fieldset w-[50%] items-center  justify-end mx-auto my-auto">
                <div>
                    <legend class="fieldset-legend">Fichier produits-records</legend>
                    <label for="file-upload"
                        class="cursor-pointer flex items-center justify-between gap-2 bg-gray-100 hover:bg-gray-200 rounded-lg shadow-sm px-4 py-2 text-gray-700 ring-1 outline-amber-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd"
                                d="M19.902 4.098a3.75 3.75 0 0 0-5.304 0l-4.5 4.5a3.75 3.75 0 0 0 1.035 6.037.75.75 0 0 1-.646 1.353 5.25 5.25 0 0 1-1.449-8.45l4.5-4.5a5.25 5.25 0 1 1 7.424 7.424l-1.757 1.757a.75.75 0 1 1-1.06-1.06l1.757-1.757a3.75 3.75 0 0 0 0-5.304Zm-7.389 4.267a.75.75 0 0 1 1-.353 5.25 5.25 0 0 1 1.449 8.45l-4.5 4.5a5.25 5.25 0 1 1-7.424-7.424l1.757-1.757a.75.75 0 1 1 1.06 1.06l-1.757 1.757a3.75 3.75 0 1 0 5.304 5.304l4.5-4.5a3.75 3.75 0 0 0-1.035-6.037.75.75 0 0 1-.354-1Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="block mt-2 text-sm text-gray-800">
                            {{-- {{ $fileName }} --}}
                        </span>

                        <span class="text-blue-600 items-end">Choisir un fichier</span>
                    </label>

                    <input id="file-upload" type="file" wire:model="file" class="file-input h-12 w-full hidden" />

                    @error('file')
                        <span class="text-red-600 mb-1 block">{{ $message }}</span>
                    @enderror

                    <label class="label">Max size 2MB</label>

                    <button type="submit" wire:loading.remove
                        class="btn btn-block mt-1 bg-green-800 shadow-xl hover:bg-amber-700">
                        Importer
                    </button>
                </div>

                <div wire:loading wire:target="import"
                    class="w-full h-20 flex flex-row items-center justify-center mx-auto p-auto">
                    <span class="loading loading-ring loading-xs"></span>
                    <span class="loading loading-ring loading-sm"></span>
                    <span class="loading loading-ring loading-md"></span>
                    <span class="loading loading-ring loading-lg"></span>
                    <span class="loading loading-ring loading-xl"></span>
                </div>
            </fieldset>
        </form>
    </div>

</div>
