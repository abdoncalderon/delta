<?php


use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\People\ShiftController;
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
use App\Http\Controllers\Settings\MenuRoleController;
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
use App\Http\Controllers\Project\SubcategoryController;
use App\Http\Controllers\Project\PeriodController;
use App\Http\Controllers\People\TurnController;

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    
    Route::get('/', [HomeController::class, 'selectProject'])->name('project');
    Route::post('/', [HomeController::class, 'setCurrentProject'])->name('setCurrentProject');
    Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('myNeedRequests', App\Http\Controllers\Session\NeedRequestController::class);
    Route::patch('/myNeedRequests/send/{myNeedRequest}', [App\Http\Controllers\Session\NeedRequestController::class,'send'])->name('myNeedRequests.send');
    Route::delete('/myNeedRequests/destroy/{myNeedRequest}',[App\Http\Controllers\Session\NeedRequestController::class,'destroy'])->name('myNeedRequests.destroy');
    Route::get('/myNeedRequests/approval/{id}/{status}', [App\Http\Controllers\Session\NeedRequestController::class,'approval'])->name('myNeedRequests.approval');
    Route::get('getNeedRequestItems/{id}',[App\Http\Controllers\Session\NeedRequestController::class, 'getNeedRequestItems'])->name('myNeedRequest.getNeedRequestItems');

    Route::resource('myNeedRequestItems',App\Http\Controllers\Session\NeedRequestItemController::class);

    Route::get('/myAssignments', [App\Http\Controllers\Session\AssignmentController::class,'index'])->name('myAssignments.index');

    Route::get('myApprovals', [App\Http\Controllers\Session\ApprovalNeedRequestController::class,'index'])->name('myApprovals.index');
    Route::patch('/myApprovals/approval/{needRequest}', [App\Http\Controllers\Session\ApprovalNeedRequestController::class,'approve'])->name('myApprovals.approve');
    Route::get('/myApprovals/approval/{needRequest}/{status}', [App\Http\Controllers\Session\ApprovalNeedRequestController::class,'approveMail'])->name('myApprovals.approveMail');
    
    Route::get('myQuotationRequests', [App\Http\Controllers\Session\QuotationRequestController::class,'index'])->name('myQuotationRequests.index');

    Route::get('myQuotations', [App\Http\Controllers\Session\QuotationController::class,'index'])->name('myQuotations.index');



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
    Route::get('getCountries/{id}',[CountryController::class, 'getCountries'])->name('settings.countries.getCountries');

    Route::get('states', [StateController::class, 'index'])->name('settings.states.index');
    Route::post('/states',[StateController::class, 'store'])->name('settings.states.store');
    Route::patch('/states/{state}', [StateController::class, 'update'])->name('settings.states.update'); 
    Route::delete('/states/{state}', [StateController::class, 'destroy'])->name('settings.states.destroy');
    Route::post('/states/import', [StateController::class, 'import'])->name('settings.states.import');
    Route::get('getStates/{id}',[StateController::class, 'getStates'])->name('settings.states.getStates');

    Route::get('cities', [CityController::class, 'index'])->name('settings.cities.index');
    Route::post('/cities',[CityController::class, 'store'])->name('settings.cities.store');
    Route::patch('/cities/{city}', [CityController::class, 'update'])->name('settings.cities.update'); 
    Route::delete('/cities/{city}', [CityController::class, 'destroy'])->name('settings.cities.destroy');
    Route::post('/cities/import', [CityController::class, 'import'])->name('settings.cities.import');
    Route::get('getCities/{id}',[CityController::class, 'getCities'])->name('settings.cities.getCities');
    
    Route::get('menus', [MenuController::class, 'index'])->name('settings.menus.index');
    Route::post('/menus',[MenuController::class, 'store'])->name('settings.menus.store');
    Route::patch('/menus/{menu}', [MenuController::class, 'update'])->name('settings.menus.update'); 
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('settings.menus.destroy');

    Route::get('roles', [RoleController::class, 'index'])->name('settings.roles.index');
    Route::post('/roles',[RoleController::class, 'store'])->name('settings.roles.store');
    Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('settings.roles.update'); 
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('settings.roles.destroy');

    Route::get('getMenusRole', [MenuRoleController::class,'getMenusRole'])->name('settings.menusRole.getMenusRole');

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
    Route::get('getModels/{id}',[ModelController::class, 'getModels'])->name('settings.models.getModels');

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
    Route::get('getPositions/{id}',[PositionController::class, 'getPositions'])->name('project.positions.getPositions');

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
    Route::get('getDepartments/{id}',[DepartmentController::class, 'getDepartments'])->name('project.departments.getDepartments');

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
    Route::get('getLocations/{id}',[LocationController::class, 'getLocations'])->name('project.locations.getLocations');

    Route::get('equipments', [EquipmentController::class, 'index'])->name('project.equipments.index');
    Route::post('/equipments',[EquipmentController::class, 'store'])->name('project.equipments.store');
    Route::patch('/equipments/{equipment}', [EquipmentController::class, 'update'])->name('project.equipments.update'); 
    Route::delete('/equipments/{equipment}', [EquipmentController::class, 'destroy'])->name('project.equipments.destroy');
    Route::post('/equipments/import', [EquipmentController::class, 'import'])->name('project.equipments.import');

    Route::get('projectUsers', [App\Http\Controllers\Project\ProjectUserController::class, 'index'])->name('project.projectUsers.index');
    Route::post('/projectUsers', [App\Http\Controllers\Project\ProjectUserController::class, 'store'])->name('project.projectUsers.store');
    Route::patch('/projectUsers/{projectUser}', [App\Http\Controllers\Project\ProjectUserController::class, 'update'])->name('project.projectUsers.update');
    Route::delete('/projectUsers/{projectUser}', [App\Http\Controllers\Project\ProjectUserController::class, 'destroy'])->name('project.projectUsers.destroy');

    Route::post('/locationProjectUsers', [App\Http\Controllers\Project\LocationProjectUserController::class, 'store'])->name('project.locationProjectUsers.store');
    Route::delete('/locationProjectUsers/{id}', [App\Http\Controllers\Project\LocationProjectUserController::class, 'destroy'])->name('project.locationProjectUsers.destroy');
    Route::get('getLocationsProjectUser/{id}',[App\Http\Controllers\Project\LocationProjectUserController::class, 'getLocationsProjectUser'])->name('project.locationProjectUsers.getLocationsProjectUser');
    Route::get('getLocationsProjectUserByZone/{id}',[App\Http\Controllers\Project\LocationProjectUserController::class, 'getLocationsProjectUserByZone'])->name('project.locationProjectUsers.getLocationsProjectUserByZone');
    Route::get('getAvailableLocations/{projectUser}',[App\Http\Controllers\Project\LocationProjectUserController::class, 'getAvailableLocations'])->name('project.locationProjectUsers.getAvailableLocations');

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
    Route::get('getCategories/{id}',[CategoryController::class, 'getCategories'])->name('project.categories.getCategories');

    Route::post('/subcategories',[SubcategoryController::class, 'store'])->name('project.subcategories.store');
    Route::post('/subcategories/import', [SubcategoryController::class, 'import'])->name('project.subcategories.import');
    Route::get('getSubcategories/{id}',[SubcategoryController::class, 'getSubcategories'])->name('project.subcategories.getSubcategories');

    Route::get('periods', [PeriodController::class, 'index'])->name('project.periods.index');

    Route::get('parameters', [App\Http\Controllers\Project\ParameterController::class, 'index'])->name('project.parameters.index'); 

    Route::get('administration/technology', [App\Http\Controllers\Administration\Technology\HomeController::class, 'home'])->name('administration.technology.home'); 

    Route::get('administration/technology/assignments', [App\Http\Controllers\Administration\Technology\AssignmentController::class, 'index'])->name('administration.technology.assignments');
    Route::get('administration/technology/assignments/assets/{stakeholderPerson}', [App\Http\Controllers\Administration\Technology\AssignmentController::class, 'assets'])->name('administration.technology.assignments.assets');
    Route::post('administration/technology/assignments/assets', [App\Http\Controllers\Administration\Technology\AssignmentController::class, 'assetDelivery'])->name('administration.technology.assignments.assets.delivery');  
    Route::patch('administration/technology/assignments/assets/{stakeholderPersonAsset}', [App\Http\Controllers\Administration\Technology\AssignmentController::class, 'assetReturn'])->name('administration.technology.assignments.assets.return');  
    Route::delete('administration/technology/assignments/assets/{stakeholderPersonAsset}', [App\Http\Controllers\Administration\Technology\AssignmentController::class, 'assetDestroy'])->name('administration.technology.assignments.assets.destroy');

    Route::get('administration/services', [App\Http\Controllers\Administration\Services\HomeController::class, 'home'])->name('administration.services.home'); 

    Route::get('production/workbook', [App\Http\Controllers\Production\WorkBook\HomeController::class, 'home'])->name('production.workbook.home');
    Route::get('production/workbook/folios', [App\Http\Controllers\Production\WorkBook\FolioController::class, 'index'])->name('production.workbook.folios.index');
    Route::post('production/workbook/folios', [App\Http\Controllers\Production\WorkBook\FolioController::class, 'store'])->name('production.workbook.folios.store');

    Route::get('production/workbook/dailyReports/{folio}',[App\Http\Controllers\Production\WorkBook\DailyReportController::class, 'index'])->name('production.workbook.dailyReports.index');
    Route::post('/production/workbook/dailyReports',[App\Http\Controllers\Production\WorkBook\DailyReportController::class, 'store'])->name('production.workbook.dailyReports.store');
    Route::patch('/production/workbook/dailyReports/{dailyReport}',[App\Http\Controllers\Production\WorkBook\DailyReportController::class, 'update'])->name('production.workbook.dailyReports.update');

    Route::post('/production/workbook/dailyReports/positions',[App\Http\Controllers\Production\WorkBook\PositionDailyReportController::class, 'store'])->name('production.workbook.dailyReports.positions.store');
    Route::post('/production/workbook/dailyReports/positions/clone',[App\Http\Controllers\Production\WorkBook\PositionDailyReportController::class, 'clone'])->name('production.workbook.dailyReports.positions.clone');
    Route::delete('/production/workbook/dailyReports/positions/{positionDailyReport}',[App\Http\Controllers\Production\WorkBook\PositionDailyReportController::class, 'destroy'])->name('production.workbook.dailyReports.positions.destroy');
    
    Route::post('/production/workbook/dailyReports/equipments',[App\Http\Controllers\Production\WorkBook\EquipmentDailyReportController::class, 'store'])->name('production.workbook.dailyReports.equipments.store');
    Route::post('/production/workbook/dailyReports/equipments/clone',[App\Http\Controllers\Production\WorkBook\EquipmentDailyReportController::class, 'clone'])->name('production.workbook.dailyReports.equipments.clone');
    Route::delete('/production/workbook/dailyReports/equipments/{equipmentDailyReport}',[App\Http\Controllers\Production\WorkBook\EquipmentDailyReportController::class, 'destroy'])->name('production.workbook.dailyReports.equipments.destroy');
    
    Route::post('/production/workbook/dailyReports/events',[App\Http\Controllers\Production\WorkBook\EventDailyReportController::class, 'store'])->name('production.workbook.dailyReports.events.store');
    Route::delete('/production/workbook/dailyReports/events/{eventDailyReport}',[App\Http\Controllers\Production\WorkBook\EventDailyReportController::class, 'destroy'])->name('production.workbook.dailyReports.events.destroy');

    Route::post('/production/workbook/dailyReports/attachments',[App\Http\Controllers\Production\WorkBook\AttachmentDailyReportController::class, 'store'])->name('production.workbook.dailyReports.attachments.store');
    Route::delete('/production/workbook/dailyReports/attachments/{attachmentDailyReport}',[App\Http\Controllers\Production\WorkBook\AttachmentDailyReportController::class, 'destroy'])->name('production.workbook.dailyReports.attachments.destroy');

    Route::get('production/workbook/notes/{folio}',[App\Http\Controllers\Production\WorkBook\NoteController::class, 'index'])->name('production.workbook.notes.index');
    Route::post('/production/workbook/notes',[App\Http\Controllers\Production\WorkBook\NoteController::class, 'store'])->name('production.workbook.notes.store');
    Route::patch('/production/workbook/notes/{note}',[App\Http\Controllers\Production\WorkBook\NoteController::class, 'update'])->name('production.workbook.notes.update');

    Route::post('/production/workbook/notes/comments',[App\Http\Controllers\Production\WorkBook\CommentNoteController::class, 'store'])->name('production.workbook.notes.comments.store');
    Route::delete('/production/workbook/notes/comments/{commentNote}',[App\Http\Controllers\Production\WorkBook\CommentNoteController::class, 'destroy'])->name('production.workbook.notes.comments.destroy');
    
    Route::get('production/workbook/locations', [App\Http\Controllers\Production\WorkBook\LocationController::class, 'index'])->name('production.workbook.locations.index');
    
    Route::post('production/workbook/locations/turns', [App\Http\Controllers\Production\WorkBook\LocationTurnController::class, 'store'])->name('production.workbook.locations.turns.store');
    Route::patch('production/workbook/locations/turns/{locationTurn}', [App\Http\Controllers\Production\WorkBook\LocationTurnController::class, 'update'])->name('production.workbook.locations.turns.update');
    Route::delete('production/workbook/locations/turns/{locationTurn}', [App\Http\Controllers\Production\WorkBook\LocationTurnController::class, 'destroy'])->name('production.workbook.locations.turns.destroy');
    Route::get('getLocationTurns/{id}',[App\Http\Controllers\People\AddressController::class, 'getLocationTurns'])->name('production.workbook.locations.turns.getLocationTurns');
    
    Route::get('production/workbook/users', [App\Http\Controllers\Production\WorkBook\ProjectUserController::class, 'index'])->name('production.workbook.users.index');
    Route::get('production/workbook/users/locations/{projectUser}', [App\Http\Controllers\Production\WorkBook\LocationProjectUserController::class, 'index'])->name('production.workbook.users.locations.index');
    Route::post('production/workbook/users/locations', [App\Http\Controllers\Production\WorkBook\LocationProjectUserController::class, 'store'])->name('production.workbook.users.locations.store');
    Route::patch('production/workbook/users/location/{locationProjectUser}', [App\Http\Controllers\Production\WorkBook\LocationProjectUserController::class, 'update'])->name('production.workbook.users.locations.update');
    Route::delete('production/workbook/users/location/{locationProjectUser}', [App\Http\Controllers\Production\WorkBook\LocationProjectUserController::class, 'destroy'])->name('production.workbook.users.locations.destroy');
   
    Route::get('/people/people', [App\Http\Controllers\People\PersonController::class, 'index'])->name('people.people.index'); 
    Route::post('/people/people', [App\Http\Controllers\People\PersonController::class, 'store'])->name('people.people.store'); 
    Route::patch('/people/people/{person}', [App\Http\Controllers\People\PersonController::class, 'update'])->name('people.people.update'); 
    Route::get('getPerson/{id}',[App\Http\Controllers\People\PersonController::class, 'getPerson'])->name('settings.regions.getCountries');
    // Route::post('/people/exits', [App\Http\Controllers\People\PersonController::class, 'storeExist'])->name('people.people.storeExist'); 

    Route::post('/people/addresses', [App\Http\Controllers\People\AddressController::class, 'store'])->name('people.addresses.store'); 
    Route::patch('/people/addresses/{address}', [App\Http\Controllers\People\AddressController::class, 'update'])->name('people.addresses.update'); 
    Route::delete('/people/addresses/{address}', [App\Http\Controllers\People\AddressController::class, 'destroy'])->name('people.addresses.destroy'); 
    Route::get('getAddresses/{id}',[App\Http\Controllers\People\AddressController::class, 'getAddresses'])->name('people.addresses.getAddresses');

    Route::post('/people/phones', [App\Http\Controllers\People\PhoneController::class, 'store'])->name('people.phones.store'); 
    Route::patch('/people/phones/{phone}', [App\Http\Controllers\People\PhoneController::class, 'update'])->name('people.phones.update'); 
    Route::delete('/people/phones/{phone}', [App\Http\Controllers\People\PhoneController::class, 'destroy'])->name('people.phones.destroy'); 
    Route::get('getPhones/{id}',[App\Http\Controllers\People\PhoneController::class, 'getPhones'])->name('people.phones.getPhones');

    Route::post('/people/contracts', [App\Http\Controllers\People\StakeholderPersonController::class, 'store'])->name('people.contracts.store'); 
    Route::patch('/people/contracts/{stakeholderPerson}', [App\Http\Controllers\People\StakeholderPersonController::class, 'update'])->name('people.contracts.update'); 
    Route::delete('/people/contracts/{stakeholderPerson}', [App\Http\Controllers\People\StakeholderPersonController::class, 'destroy'])->name('people.contracts.destroy'); 
    Route::get('getContracts/{id}',[App\Http\Controllers\People\StakeholderPersonController::class, 'getContracts'])->name('people.contracts.getContracts');
    Route::get('getStakeholderPeople/{id}',[App\Http\Controllers\People\StakeholderPersonController::class, 'getStakeholderPeople'])->name('people.contracts.getStakeholderPeople');

    /** TIMESHEET */

    Route::get('/people/timesheet', [App\Http\Controllers\People\TimeSheetController::class, 'home'])->name('people.timesheet.home'); 
    
    Route::get('/people/timesheet/attendance', [App\Http\Controllers\People\AttendanceController::class, 'index'])->name('people.timesheet.attendance.index'); 
    Route::post('/people/timesheet/attendance/download', [App\Http\Controllers\People\AttendanceController::class, 'download'])->name('people.timesheet.attendance.download');
    
    Route::post('getEvents',[App\Http\Controllers\People\AttendanceController::class, 'getEvents'])->name('people.timesheet.attendance.getEvents');

    Route::get('/people/timesheet/users', [App\Http\Controllers\People\UserController::class, 'index'])->name('people.timesheet.users.index');
    Route::post('/people/timesheet/users/upload', [App\Http\Controllers\People\UserController::class, 'upload'])->name('people.timesheet.users.upload');

    Route::get('/people/timesheet/clocks', [App\Http\Controllers\People\ClockController::class, 'index'])->name('people.timesheet.clocks.index'); 
    Route::post('/people/timesheet/clocks',[App\Http\Controllers\People\ClockController::class, 'store'])->name('people.timesheet.clocks.store');
    Route::patch('/people/timesheet/clocks/{clock}', [App\Http\Controllers\People\ClockController::class, 'update'])->name('people.timesheet.clocks.update'); 
    Route::delete('/people/timesheet/clocks/{clock}', [App\Http\Controllers\People\ClockController::class, 'destroy'])->name('people.timesheet.clocks.destroy');

    Route::get('/people/timesheet/shifts', [ShiftController::class, 'index'])->name('people.timesheet.shifts.index');
    Route::post('/people/timesheet/shifts',[ShiftController::class, 'store'])->name('people.timesheet.shifts.store');
    Route::patch('/people/timesheet/shifts/{shift}', [ShiftController::class, 'update'])->name('people.timesheet.shifts.update'); 
    Route::delete('/people/timesheet/shifts/{shift}', [ShiftController::class, 'destroy'])->name('people.timesheet.shifts.destroy');
    Route::post('/people/timesheet/shifts/assign',[ShiftController::class, 'assign'])->name('people.timesheet.shifts.assign');
    Route::post('/people/timesheet/shifts/import', [ShiftController::class, 'import'])->name('people.timesheet.shifts.import');

    Route::get('/people/timesheet/reports', [App\Http\Controllers\People\ReportController::class, 'index'])->name('people.timesheet.reports.index');
    Route::post('getTimesheet', [App\Http\Controllers\People\ReportController::class, 'getTimesheet'])->name('people.timesheet.reports.getTimesheet');

    Route::get('isConnected/{ip}/{port}',[App\Http\Controllers\People\ClockController::class, 'isConnected'])->name('people.timesheet.clocks.isConnected');
    Route::get('getUsers/{clock}',[App\Http\Controllers\People\ClockController::class, 'getUsers'])->name('people.timesheet.clocks.getUsers');
    Route::get('cleartUsers/{clock}',[App\Http\Controllers\People\ClockController::class, 'clearUsers'])->name('people.timesheet.clocks.clearUsers');
    Route::get('removeUser/{clock}/{uid}',[App\Http\Controllers\People\ClockController::class, 'removeUser'])->name('people.timesheet.clocks.removeUser');
    Route::get('getAttendance/{clock}',[App\Http\Controllers\People\ClockController::class, 'getAttendance'])->name('people.timesheet.clocks.getAttendance');
    Route::get('clearAttendance/{clock}',[App\Http\Controllers\People\ClockController::class, 'getAttendance'])->name('people.timesheet.clocks.clearAttendance');
    Route::get('getTime/{clock}',[App\Http\Controllers\People\ClockController::class, 'getTime'])->name('people.timesheet.clocks.getTime');
    Route::get('setTime/{clock}',[App\Http\Controllers\People\ClockController::class, 'setTime'])->name('people.timesheet.clocks.setTime');

    Route::get('commercial/materials', [App\Http\Controllers\Commercial\Materials\HomeController::class, 'home'])->name('commercial.materials.home');

    Route::get('commercial/materials/materials', [App\Http\Controllers\Commercial\Materials\MaterialController::class, 'index'])->name('commercial.materials.index');
    Route::post('commercial/materials/materials', [App\Http\Controllers\Commercial\Materials\MaterialController::class, 'store'])->name('commercial.materials.store');
    Route::patch('commercial/materials/materials/{material}', [App\Http\Controllers\Commercial\Materials\MaterialController::class, 'update'])->name('commercial.materials.update');

    Route::get('commercial/controls', [App\Http\Controllers\Commercial\Controls\HomeController::class, 'home'])->name('commercial.controls.home');

    Route::get('commercial/controls/needRequests', [App\Http\Controllers\Commercial\Controls\NeedRequestController::class, 'index'])->name('commercial.controls.needRequests.index');
    Route::post('commercial/controls/needRequests/process', [App\Http\Controllers\Commercial\Controls\NeedRequestController::class, 'process'])->name('commercial.controls.needRequests.process');

    Route::get('commercial/purchases', [App\Http\Controllers\Commercial\Purchases\HomeController::class, 'home'])->name('commercial.purchases.home');
    Route::get('commercial/purchases/purchaseRequests', [App\Http\Controllers\Commercial\Purchases\PurchaseRequestController::class, 'index'])->name('commercial.purchases.purchaseRequests.index');
    Route::get('commercial/purchases/purchaseRequests/send/{id}', [App\Http\Controllers\Commercial\Purchases\PurchaseRequestController::class, 'send'])->name('commercial.purchases.purchaseRequests.send');
    Route::get('getPurchaseRequestNotifications/{id}',[App\Http\Controllers\Commercial\Purchases\PurchaseRequestController::class, 'getPurchaseRequestNotifications'])->name('commercial.purchases.purchaseRequests.getNotifications');

    Route::resource('purchaseRequestNotifications',App\Http\Controllers\Commercial\Purchases\PurchaseRequestNotificationController::class);

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
    Route::resource('projects',App\Http\Controllers\Settings\MenuController::class);  
    Route::resource('people.phones',App\Http\Controllers\People\PhoneController::class);
    Route::resource('people.addresses',App\Http\Controllers\People\AddressController::class);*/
});

require __DIR__.'/auth.php';
