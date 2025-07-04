<div class="w-full h-full flex flex-col">
    @if (session()->has('message'))
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
    @endif


    <div
        class="w-140 mt-2 mx-auto text-center border rounded text-3xl font-semibold p-2 hover:border-amber-400 shadow-2xl">
        CREATION DE PROGRAMMES SPECIAUX
    </div>


    <form class="w-1/2 mt-15 mx-auto shadow-2xl border-t-2" wire:submit.prevent="save">
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-6 l">
            <legend class="fieldset-legend text-lg font-semibold">Créer Programmes special</legend>

            <label class="label mt-2 floating-label">
                <span>Nom du Programme</span>
                <input wire:model="name" type="text" pattern="^[A-Z_-]+$"
                    title="Utilisez uniquement des lettres MAJUSCULES, le tiret (-) et le underscore (_)."
                    class="input input-bordered w-full" placeholder="Ex: AGNEBY TIASSA" />
            </label>
            @error('name')
                <span class="text-red-600 mb-1 text-center block">{{ $message }}</span>
            @enderror
            <button type="submit" wire:loading.remove class="btn bg-green-800 mt-4 w-full">Créer</button>
            <div wire:loading wire:target="save"
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
