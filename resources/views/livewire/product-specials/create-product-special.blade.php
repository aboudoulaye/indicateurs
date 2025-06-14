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
        LIER PRODUITS/PROGRAMMES SPECIAUX
    </div>


    <form class="w-1/2  mx-auto mt-15 border-t-2 shadow-2xl" wire:submit.prevent="save">
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-6">
            <legend class="fieldset-legend text-lg font-semibold">LIER PRODUITS PROGRAMMES SPECIAUX</legend>
            <label class="label mt-2">Nom Programme</label>
            <select id="programme" wire:model="special_id" class=" w-full" autocomplete="off">
                <option value="">choisir programme ----</option>
                @foreach ($this->specials as $special)
                    <option value="{{ $special->id }}">{{ $special->name }}</option>
                @endforeach
            </select>
            @error('special_id')
                <span class="text-red-600 mb-1 text-center block">{{ $message }}</span>
            @enderror
            <label class="label mt-2">Nom Produit</label>
            <select id="produit" class="w-full" autocomplete="off" wire:model="product_id">
                <option value="">choisir produit</option>
                @foreach ($this->produits as $produit)
                    <option value="{{ $produit->id }}">{{ $produit->name }}</option>
                @endforeach
            </select>
            @error('product_id')
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

    @if (session()->has('success'))
        <div class="flex items-center justify-between">
            <div class="w-40 mt-10 mx-auto text-center  rounded  font-semibold shadow-2xl">
                <a href="{{ route('create.regions') }}" class="btn btn-warning w-full"
                    type="button">terminer/quitter</a>
            </div>
        </div>
    @endif
</div>

<script>
    new TomSelect("#produit", {
        create: true,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
    new TomSelect("#programme", {
        create: true,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
</script>
