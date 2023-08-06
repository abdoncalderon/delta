<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Settings\RegionController;
use App\Http\Controllers\Settings\CountryController;
use App\Http\Controllers\Settings\StateController;
use App\Http\Controllers\Settings\CityController;
use App\Http\Controllers\Settings\MenuController;
use App\Http\Controllers\Settings\RoleController;
use App\Http\Controllers\Settings\PermitController;
use App\Http\Controllers\Settings\BrandController;
use App\Http\Controllers\Settings\ModelController;
use App\Http\Controllers\Settings\UnityController;
use App\Http\Controllers\Settings\CompanyController;
use App\Http\Controllers\Settings\DivisionController;
use App\Http\Controllers\Settings\SubsidiaryController;
use App\Http\Controllers\Settings\ProjectController;
use App\Http\Controllers\Settings\ParameterController;
use App\Http\Controllers\Project\StakeholderController;
use App\Http\Controllers\Project\FunctionController;
use App\Http\Controllers\Project\PositionController;
use App\Http\Controllers\Project\SectorController;
use App\Http\Controllers\Project\DepartmentController;
use App\Http\Controllers\Project\ZoneController;
use App\Http\Controllers\Project\LocationController;
use App\Http\Controllers\Project\EquipmentController;
use App\Http\Controllers\Project\FamilyController;
use App\Http\Controllers\Project\CategoryController;
use App\Http\Controllers\Project\PeriodController;
use App\Http\Controllers\Project\TurnController;


use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    
    
    Route::get('/', [HomeController::class, 'selectProject'])->name('project');
    Route::post('/', [HomeController::class, 'setCurrentProject'])->name('setCurrentProject');
    Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');


    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('regions', [RegionController::class, 'index'])->name('settings.regions.index');
    Route::post('/regions',[RegionController::class, 'store'])->name('settings.regions.store');
    Route::patch('/regions/{region}', [RegionController::class, 'update'])->name('settings.regions.update'); 
    Route::delete('/regions/{region}', [RegionController::class, 'destroy'])->name('settings.regions.destroy');
    Route::post('/regions/import', [RegionController::class, 'import'])->name('settings.regions.import');
    
    Route::get('countries', [CountryController::class, 'index'])->name('settings.countries.index');
    Route::post('/countries',[CountryController::class, 'store'])->name('settings.countries.store');
    Route::patch('/countries/{country}', [CountryController::class, 'update'])->name('settings.countries.update'); 
    Route::delete('/countries/{country}', [CountryController::class, 'destroy'])->name('settings.countries.destroy');
    Route::post('/countries/import', [CountryController::class, 'import'])->name('settings.countries.import');

    Route::get('states', [StateController::class, 'index'])->name('settings.states.index');
    Route::post('/states',[StateController::class, 'store'])->name('settings.states.store');
    Route::patch('/states/{state}', [StateController::class, 'update'])->name('settings.states.update'); 
    Route::delete('/states/{state}', [StateController::class, 'destroy'])->name('settings.states.destroy');
    Route::post('/states/import', [StateController::class, 'import'])->name('settings.states.import');

    Route::get('cities', [CityController::class, 'index'])->name('settings.cities.index');
    Route::post('/cities',[CityController::class, 'store'])->name('settings.cities.store');
    Route::patch('/cities/{city}', [CityController::class, 'update'])->name('settings.cities.update'); 
    Route::delete('/cities/{city}', [CityController::class, 'destroy'])->name('settings.cities.destroy');
    Route::post('/cities/import', [CityController::class, 'import'])->name('settings.cities.import');
    
    Route::get('menus', [MenuController::class, 'index'])->name('settings.menus.index');
    Route::post('/menus',[MenuController::class, 'store'])->name('settings.menus.store');
    Route::patch('/menus/{menu}', [MenuController::class, 'update'])->name('settings.menus.update'); 
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('settings.menus.destroy');

    Route::get('roles', [RoleController::class, 'index'])->name('settings.roles.index');
    Route::post('/roles',[RoleController::class, 'store'])->name('settings.roles.store');
    Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('settings.roles.update'); 
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('settings.roles.destroy');

    Route::get('permits', [PermitController::class, 'index'])->name('settings.permits.index');
    Route::post('/permits',[PermitController::class, 'store'])->name('settings.permits.store');
    Route::patch('/permits/{permit}', [PermitController::class, 'update'])->name('settings.permits.update'); 
    Route::delete('/permits/{permit}', [PermitController::class, 'destroy'])->name('settings.permits.destroy');

    Route::get('brands', [BrandController::class, 'index'])->name('settings.brands.index');
    Route::post('/brands',[BrandController::class, 'store'])->name('settings.brands.store');
    Route::patch('/brands/{brand}', [BrandController::class, 'update'])->name('settings.brands.update'); 
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('settings.brands.destroy');
    Route::post('/brands/import', [BrandController::class, 'import'])->name('settings.brands.import');

    Route::get('models', [ModelController::class, 'index'])->name('settings.models.index');
    Route::post('/models',[ModelController::class, 'store'])->name('settings.models.store');
    Route::patch('/models/{model}', [ModelController::class, 'update'])->name('settings.models.update'); 
    Route::delete('/models/{model}', [ModelController::class, 'destroy'])->name('settings.models.destroy');
    Route::post('/models/import', [ModelController::class, 'import'])->name('settings.models.import');

    Route::get('unities', [UnityController::class, 'index'])->name('settings.unities.index'); 
    Route::post('/unities',[UnityController::class, 'store'])->name('settings.unities.store');
    Route::patch('/unities/{unity}', [UnityController::class, 'update'])->name('settings.unities.update'); 
    Route::delete('/unities/{unity}', [UnityController::class, 'destroy'])->name('settings.unities.destroy');
    Route::post('/unities/import', [UnityController::class, 'import'])->name('settings.unities.import');
    
    Route::get('companies', [CompanyController::class, 'index'])->name('settings.companies.index');
    Route::post('/companies',[CompanyController::class, 'store'])->name('settings.companies.store');
    Route::patch('/companies/{company}', [CompanyController::class, 'update'])->name('settings.companies.update'); 
    Route::delete('/companies/{company}', [CompanyController::class, 'destroy'])->name('settings.companies.destroy');

    Route::get('divisions', [DivisionController::class, 'index'])->name('settings.divisions.index');
    Route::post('/divisions',[DivisionController::class, 'store'])->name('settings.divisions.store');
    Route::patch('/divisions/{division}', [DivisionController::class, 'update'])->name('settings.divisions.update'); 
    Route::delete('/divisions/{division}', [DivisionController::class, 'destroy'])->name('settings.divisions.destroy');

    Route::get('subsidiaries', [SubsidiaryController::class, 'index'])->name('settings.subsidiaries.index');
    Route::post('/subsidiaries',[SubsidiaryController::class, 'store'])->name('settings.subsidiaries.store');
    Route::patch('/subsidiaries/{subsidiary}', [SubsidiaryController::class, 'update'])->name('settings.subsidiaries.update'); 
    Route::delete('/subsidiaries/{subsidiary}', [SubsidiaryController::class, 'destroy'])->name('settings.subsidiaries.destroy');

    Route::get('projects', [ProjectController::class, 'index'])->name('settings.projects.index');
    Route::post('/projects',[ProjectController::class, 'store'])->name('settings.projects.store');
    Route::patch('/projects/{project}', [ProjectController::class, 'update'])->name('settings.projects.update'); 
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('settings.projects.destroy');

    Route::get('/settings/parameters', [ParameterController::class, 'index'])->name('settings.parameters.index');

    Route::get('project', [App\Http\Controllers\Project\ProjectController::class,'edit'])->name('project.project.edit');
    Route::post('/project',[ProjectController::class, 'store'])->name('project.project.store');
    Route::patch('/project/{project}', [ProjectController::class, 'update'])->name('project.project.update'); 

    Route::get('stakeholders', [StakeholderController::class, 'index'])->name('project.stakeholders.index');
    Route::post('/stakeholders',[StakeholderController::class, 'store'])->name('project.stakeholders.store');
    Route::patch('/stakeholders/{stakeholder}', [StakeholderController::class, 'update'])->name('project.stakeholders.update'); 
    Route::delete('/stakeholders/{stakeholder}', [StakeholderController::class, 'destroy'])->name('project.stakeholders.destroy');

    Route::get('functions', [FunctionController::class, 'index'])->name('project.functions.index');
    Route::post('/functions',[FunctionController::class, 'store'])->name('project.functions.store');
    Route::patch('/functions/{function}', [FunctionController::class, 'update'])->name('project.functions.update'); 
    Route::delete('/functions/{function}', [FunctionController::class, 'destroy'])->name('project.functions.destroy');
    Route::post('/functions/import', [FunctionController::class, 'import'])->name('project.functions.import');

    Route::get('positions', [PositionController::class, 'index'])->name('project.positions.index');
    Route::post('/positions',[PositionController::class, 'store'])->name('project.positions.store');
    Route::patch('/positions/{position}', [PositionController::class, 'update'])->name('project.positions.update'); 
    Route::delete('/positions/{position}', [PositionController::class, 'destroy'])->name('project.positions.destroy');
    Route::post('/positions/import', [PositionController::class, 'import'])->name('project.positions.import');

    Route::get('sectors', [SectorController::class, 'index'])->name('project.sectors.index');
    Route::post('/sectors',[SectorController::class, 'store'])->name('project.sectors.store');
    Route::patch('/sectors/{sector}', [SectorController::class, 'update'])->name('project.sectors.update'); 
    Route::delete('/sectors/{sector}', [SectorController::class, 'destroy'])->name('project.sectors.destroy');
    Route::post('/sectors/import', [SectorController::class, 'import'])->name('project.sectors.import');

    Route::get('departments', [DepartmentController::class, 'index'])->name('project.departments.index');
    Route::post('/departments',[DepartmentController::class, 'store'])->name('project.departments.store');
    Route::patch('/departments/{department}', [DepartmentController::class, 'update'])->name('project.departments.update'); 
    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('project.departments.destroy');
    Route::post('/departments/import', [DepartmentController::class, 'import'])->name('project.departments.import');

    Route::get('zones', [ZoneController::class, 'index'])->name('project.zones.index');
    Route::post('/zones',[ZoneController::class, 'store'])->name('project.zones.store');
    Route::patch('/zones/{zone}', [ZoneController::class, 'update'])->name('project.zones.update'); 
    Route::delete('/zones/{zone}', [ZoneController::class, 'destroy'])->name('project.zones.destroy');
    Route::post('/zones/import', [ZoneController::class, 'import'])->name('project.zones.import');

    Route::get('locations', [LocationController::class, 'index'])->name('project.locations.index');
    Route::post('/locations',[LocationController::class, 'store'])->name('project.locations.store');
    Route::patch('/locations/{location}', [LocationController::class, 'update'])->name('project.locations.update'); 
    Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->name('project.locations.destroy');
    Route::post('/locations/import', [LocationController::class, 'import'])->name('project.locations.import');

    Route::get('equipments', [EquipmentController::class, 'index'])->name('project.equipments.index');
    Route::post('/equipments',[EquipmentController::class, 'store'])->name('project.equipments.store');
    Route::patch('/equipments/{equipment}', [EquipmentController::class, 'update'])->name('project.equipments.update'); 
    Route::delete('/equipments/{equipment}', [EquipmentController::class, 'destroy'])->name('project.equipments.destroy');
    Route::post('/equipments/import', [EquipmentController::class, 'import'])->name('project.equipments.import');

    Route::get('projectUsers', [App\Http\Controllers\Project\UserController::class, 'index'])->name('project.users.index');
    Route::post('/projectUsers', [App\Http\Controllers\Project\UserController::class, 'store'])->name('project.users.store');
    Route::patch('/projectUsers/{projectUser}', [App\Http\Controllers\Project\UserController::class, 'update'])->name('project.users.update');
    Route::delete('/projectUsers/{projectUser}', [App\Http\Controllers\Project\UserController::class, 'destroy'])->name('project.users.destroy');

    Route::get('families', [FamilyController::class, 'index'])->name('project.families.index');
    Route::post('/families',[FamilyController::class, 'store'])->name('project.families.store');
    Route::patch('/families/{family}', [FamilyController::class, 'update'])->name('project.families.update'); 
    Route::delete('/families/{family}', [FamilyController::class, 'destroy'])->name('project.families.destroy');
    Route::post('/families/import', [FamilyController::class, 'import'])->name('project.families.import');

    Route::get('categories', [CategoryController::class, 'index'])->name('project.categories.index');
    Route::post('/categories',[CategoryController::class, 'store'])->name('project.categories.store');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('project.categories.update'); 
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('project.categories.destroy');
    Route::post('/categories/import', [CategoryController::class, 'import'])->name('project.categories.import');

    Route::get('periods', [PeriodController::class, 'index'])->name('project.periods.index');

    Route::get('turns', [TurnController::class, 'index'])->name('project.turns.index');
    Route::post('/turns',[TurnController::class, 'store'])->name('project.turns.store');
    Route::patch('/turns/{turn}', [TurnController::class, 'update'])->name('project.turns.update'); 
    Route::delete('/turns/{turn}', [TurnController::class, 'destroy'])->name('project.turns.destroy');
    Route::post('/turns/import', [TurnController::class, 'import'])->name('project.turns.import');

    Route::get('parameters', [App\Http\Controllers\Project\ParameterController::class, 'index'])->name('project.parameters.index'); 

    Route::get('administration/technology', [App\Http\Controllers\Administration\Technology\HomeController::class, 'home'])->name('administration.technology.home'); 

    Route::get('administration/technology/assignments', [App\Http\Controllers\Administration\Technology\AssignmentController::class, 'index'])->name('administration.technology.assignments');
    Route::get('administration/technology/assignments/assets/{stakeholderPerson}', [App\Http\Controllers\Administration\Technology\AssignmentController::class, 'assets'])->name('administration.technology.assignments.assets');
    Route::post('administration/technology/assignments/assets', [App\Http\Controllers\Administration\Technology\AssignmentController::class, 'assetDelivery'])->name('administration.technology.assignments.assets.delivery');  
    Route::patch('administration/technology/assignments/assets/{stakeholderPersonAsset}', [App\Http\Controllers\Administration\Technology\AssignmentController::class, 'assetReturn'])->name('administration.technology.assignments.assets.return');  
    Route::patch('administration/technology/assignments/assets/{stakeholderPersonAsset}', [App\Http\Controllers\Administration\Technology\AssignmentController::class, 'assetDestroy'])->name('administration.technology.assignments.assets.destroy');

    Route::get('administration/services', [App\Http\Controllers\Administration\Services\HomeController::class, 'home'])->name('administration.services.home'); 

    Route::get('production/workbook', [App\Http\Controllers\Production\WorkBook\HomeController::class, 'home'])->name('production.workbook.home');
    Route::get('production/workbook/folios', [App\Http\Controllers\Production\WorkBook\FolioController::class, 'index'])->name('production.workbook.folios.index');
    Route::post('production/workbook/folios', [App\Http\Controllers\Production\WorkBook\FolioController::class, 'store'])->name('production.workbook.folios.store');

    Route::get('production/workbook/dailyReports/{folio}',[App\Http\Controllers\Production\WorkBook\DailyReportController::class, 'index'])->name('production.workbook.dailyReports.index');
    Route::post('production/workbook/dailyReports',[App\Http\Controllers\Production\WorkBook\DailyReportController::class, 'store'])->name('production.workbook.dailyReports.store');
    
    
    
    
    
    
    Route::get('people', [App\Http\Controllers\People\PersonController::class, 'index'])->name('people.people.index'); 

    // Route::get('getMenusRole', [MenuRoleController::class, 'index'])->name('settings.menusRole.index'); 
    
    /* Route::resource('settings.regions',App\Http\Controllers\Settings\RegionController::class);
    Route::resource('countries',App\Http\Controllers\Settings\CountryController::class);
    Route::resource('states',App\Http\Controllers\Settings\StateController::class);
    Route::resource('cities',App\Http\Controllers\Settings\CityController::class);
    Route::resource('companies',App\Http\Controllers\Settings\CompanyController::class);
    Route::resource('menus',App\Http\Controllers\Settings\MenuController::class);
    Route::resource('roles',App\Http\Controllers\Settings\MenuController::class);
    Route::resource('permits',App\Http\Controllers\Settings\MenuController::class);
    Route::resource('brands',App\Http\Controllers\Settings\MenuController::class);
    Route::resource('models',App\Http\Controllers\Settings\MenuController::class);
    Route::resource('unities',App\Http\Controllers\Settings\MenuController::class);
    Route::resource('divisions',App\Http\Controllers\Settings\MenuController::class);
    Route::resource('subsidiaries',App\Http\Controllers\Settings\MenuController::class);
    Route::resource('projects',App\Http\Controllers\Settings\MenuController::class); */
});

require __DIR__.'/auth.php';
