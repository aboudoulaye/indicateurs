<?php

use App\Http\Controllers\ProductController;
use App\Livewire\CenterProducts\CreateCenterProduct;
use App\Livewire\CenterProgams\CenterProgramList;
use App\Livewire\CenterProgams\CreateCenterProgram;
use App\Livewire\Centers\CenterList;
use App\Livewire\Centers\CreateCenter;
use App\Livewire\Disrtics\CreateDistrict;
use App\Livewire\Disrtics\DistrictList;
use App\Livewire\Periods\CreatePeriod;
use App\Livewire\ProductRecords\CreateProductRecord;
use App\Livewire\ProductRecords\ProductRecordsList;
use App\Livewire\Programs\CreateProgram;
use App\Livewire\Regions\CreateRegion;
use App\Livewire\Products\CreateProduct;
use App\Livewire\CenterTypes\CreateType;
use App\Livewire\CenterTypes\TypeList;
use App\Livewire\ProductPrograms\CreateProductProgram;
use App\Livewire\ProductPrograms\ProductProgramList;
use App\Livewire\Products\ProductList;
use App\Livewire\ProductSpecials\CreateProductSpecial;
use App\Livewire\Programs\ProgramList;
use App\Livewire\Records\CreateRecord;
use App\Livewire\Regions\RegionList;
use App\Livewire\Specilas\CreateSpecial;
use App\Livewire\Tous\TousList;

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/regions/create', CreateRegion::class)->name('create.regions');
Route::get('/regions/list', RegionList::class)->name('list.regions');

Route::get('/districts/create', CreateDistrict::class)->name('create.districts');
Route::get('/districts/list', DistrictList::class)->name('list.districts');

Route::get('/centres/create', CreateCenter::class)->name('create.centres');
Route::get('/centres/list', CenterList::class)->name('list.centres');

Route::get('/centretype/create', CreateType::class)->name('type.centres');
Route::get('/centretype/list', TypeList::class)->name('type.list');

Route::get('/programs/create', CreateProgram::class)->name('create.programs');
Route::get('/programs/list', ProgramList::class)->name('list.programs');

Route::get('/program_center/create', CreateCenterProgram::class)->name('create.program_center');
Route::get('/program_center/list', CenterProgramList::class)->name('list.program_center');

Route::get('/product_program',CreateProductProgram::class)->name('create.product_program');
Route::get('product_program/list',ProductProgramList::class)->name('list.product_program');

Route::get('/products/create', CreateProduct::class)->name('create.product');
Route::get('/products/list', ProductList::class)->name('list.product');

Route::get('/product_center/create', CreateCenterProduct::class)->name('create.product_center');

Route::get('/special/create', CreateSpecial::class)->name('create.special');

Route::get('/product_special/create', CreateProductSpecial::class)->name('create.special_product');

Route::get('/record/create', CreateRecord::class)->name('create.record');

Route::get('/product_record/create', CreateProductRecord::class)->name('create.product_record');
Route::get('/product_record/list', ProductRecordsList::class)->name('list.product_record');

Route::get('/period/create', CreatePeriod::class)->name('create.period');

Route::get('/tous', TousList::class)->name('tous.list');