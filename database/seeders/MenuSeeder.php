<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Settings Menu
        DB::table('menus')->insert([
            'name' => 'settings',
            'text' => 'content.setting',
            'route' => null,
            'icon' => 'fa fa-gears'
        ]);

                        /* DB::table('menus')->insert([
                            'name' => 'catalog',
                            'text' => 'content.catalog',
                            'father' => 'settings',
                            'route' => 'settings.catalog.index',
                            'icon' => 'fa fa-gears'
                        ]); */

                        DB::table('menus')->insert([
                            'name' => 'settings.regions',
                            'text' => 'content.regions',
                            'father' => 'settings',
                            'route' => 'settings.regions.index',
                            'icon' => 'fa fa-gears',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'settings.countries',
                            'text' => 'content.countries',
                            'father' => 'settings',
                            'route' => 'settings.countries.index',
                            'icon' => 'fa fa-gears',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'settings.states',
                            'text' => 'content.states',
                            'father' => 'settings',
                            'route' => 'settings.states.index',
                            'icon' => 'fa fa-gears',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'settings.cities',
                            'text' => 'content.cities',
                            'father' => 'settings',
                            'route' => 'settings.cities.index',
                            'icon' => 'fa fa-gears',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'settings.menus',
                            'text' => 'content.menus',
                            'father' => 'settings',
                            'route' => 'settings.menus.index',
                            'icon' => 'fa fa-gears',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'settings.roles',
                            'text' => 'content.roles',
                            'father' => 'settings',
                            'route' => 'settings.roles.index',
                            'icon' => 'fa fa-gears',
                        ]);
                        
                        DB::table('menus')->insert([
                            'name' => 'settings.permits',
                            'text' => 'content.permits',
                            'father' => 'settings',
                            'route' => 'settings.permits.index',
                            'icon' => 'fa fa-gears',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'settings.brands',
                            'text' => 'content.brands',
                            'father' => 'settings',
                            'route' => 'settings.brands.index',
                            'icon' => 'fa fa-gears',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'settings.models',
                            'text' => 'content.models',
                            'father' => 'settings',
                            'route' => 'settings.models.index',
                            'icon' => 'fa fa-gears',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'settings.unities',
                            'text' => 'content.unities',
                            'father' => 'settings',
                            'route' => 'settings.unities.index',
                            'icon' => 'fa fa-gears',
                        ]);


                        DB::table('menus')->insert([
                            'name' => 'settings.companies',
                            'text' => 'content.companies',
                            'father' => 'settings',
                            'route' => 'settings.companies.index',
                            'icon' => 'fa fa-gears',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'settings.divisions',
                            'text' => 'content.divisions',
                            'father' => 'settings',
                            'route' => 'settings.divisions.index',
                            'icon' => 'fa fa-gears',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'settings.subsidiaries',
                            'text' => 'content.subsidiaries',
                            'father' => 'settings',
                            'route' => 'settings.subsidiaries.index',
                            'icon' => 'fa fa-gears',
                        ]);
                        
                        DB::table('menus')->insert([
                            'name' => 'settings.projects',
                            'text' => 'content.projects',
                            'father' => 'settings',
                            'route' => 'settings.projects.index',
                            'icon' => 'fa fa-gears',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'settings.parameters',
                            'text' => 'content.parameters',
                            'father' => 'settings',
                            'route' => 'settings.parameters.index',
                            'icon' => 'fa fa-gears',
                        ]);

        // Project Menu

        DB::table('menus')->insert([
            'name' => 'projects',
            'text' => 'content.project',
            'route' => null,
            'icon' => 'fa fa-map',
        ]);

                        DB::table('menus')->insert([
                            'name' => 'project.data',
                            'text' => 'content.data',
                            'father' => 'projects',
                            'route' => 'project.project.edit',
                            'icon' => 'fa fa-map',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'project.stakeholders',
                            'text' => 'content.stakeholders',
                            'father' => 'projects',
                            'route' => 'project.stakeholders.index',
                            'icon' => 'fa fa-map',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'project.functions',
                            'text' => 'content.functions',
                            'father' => 'projects',
                            'route' => 'project.functions.index',
                            'icon' => 'fa fa-map',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'project.positions',
                            'text' => 'content.positions',
                            'father' => 'projects',
                            'route' => 'project.positions.index',
                            'icon' => 'fa fa-map',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'project.sectors',
                            'text' => 'content.sectors',
                            'father' => 'projects',
                            'route' => 'project.sectors.index',
                            'icon' => 'fa fa-map',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'project.departments',
                            'text' => 'content.departments',
                            'father' => 'projects',
                            'route' => 'project.departments.index',
                            'icon' => 'fa fa-map',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'project.zones',
                            'text' => 'content.zones',
                            'father' => 'projects',
                            'route' => 'project.zones.index',
                            'icon' => 'fa fa-map',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'project.locations',
                            'text' => 'content.locations',
                            'father' => 'projects',
                            'route' => 'project.locations.index',
                            'icon' => 'fa fa-map',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'project.families',
                            'text' => 'content.families',
                            'father' => 'projects',
                            'route' => 'project.families.index',
                            'icon' => 'fa fa-map',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'project.categories',
                            'text' => 'content.categories',
                            'father' => 'projects',
                            'route' => 'project.categories.index',
                            'icon' => 'fa fa-map',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'project.equipments',
                            'text' => 'content.equipments',
                            'father' => 'projects',
                            'route' => 'project.equipments.index',
                            'icon' => 'fa fa-map',
                        ]);

                        /* DB::table('menus')->insert([
                            'name' => 'project.periods',
                            'text' => 'content.periods',
                            'father' => 'projects',
                            'route' => 'project.periods.index',
                            'icon' => 'fa fa-map',
                        ]); 

                        DB::table('menus')->insert([
                            'name' => 'project.shifts',
                            'text' => 'content.shifts',
                            'father' => 'projects',
                            'route' => 'project.turns.index',
                            'icon' => 'fa fa-map',
                        ]);*/

                        DB::table('menus')->insert([
                            'name' => 'project.projectUsers',
                            'text' => 'content.users',
                            'father' => 'projects',
                            'route' => 'project.projectUsers.index',
                            'icon' => 'fa fa-map',
                        ]);

                        DB::table('menus')->insert([
                            'name' => 'project.parameters',
                            'text' => 'content.parameters',
                            'father' => 'projects',
                            'route' => 'project.parameters.index',
                            'icon' => 'fa fa-map',
                        ]);

        // Administration Menu 

        DB::table('menus')->insert([
            'name' => 'administration',
            'text' => 'content.administration',
            'route' => null,
            'icon' => 'fa fa-headset',
        ]);

                        DB::table('menus')->insert([
                            'name' => 'administration.technology',
                            'text' => 'content.technology',
                            'father' => 'administration',
                            'route' => 'administration.technology.home',
                            'icon' => 'fa fa-laptop',
                        ]);

                                        /* DB::table('menus')->insert([
                                            'name' => 'administration.technology.requests',
                                            'text' => 'content.requests',
                                            'father' => 'administration.technology.index',
                                            'route' => 'dashboard',
                                            'icon' => 'mdi-account-wrench',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'administration.technology.assignments.',
                                            'text' => 'content.assignments',
                                            'father' => 'administration.technology',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-laptop',
                                        ]); */

                        DB::table('menus')->insert([
                            'name' => 'administration.services',
                            'text' => 'content.services',
                            'father' => 'administration',
                            'route' => 'administration.services.home',
                            'icon' => 'fa fa-toolbox',
                        ]);

                                        /* DB::table('menus')->insert([
                                            'name' => 'administration.services.requests',
                                            'text' => 'content.requests',
                                            'father' => 'administration.services',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-ticket',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'administration.services.catering',
                                            'text' => 'content.catering',
                                            'father' => 'administration.services',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-cutlery',
                                        ]); */
        

        // Production Menu 

        DB::table('menus')->insert([
            'name' => 'production',
            'text' => 'content.production',
            'route' => null,
            'icon' => 'fa fa-helmet-safety',
        ]);

                        DB::table('menus')->insert([
                            'name' => 'production.workbook',
                            'text' => 'content.workbook',
                            'father' => 'production',
                            'route' => 'production.workbook.home',
                            'icon' => 'fa fa-book',
                        ]);

                                        /* DB::table('menus')->insert([
                                            'name' => 'production.workbook.documents',
                                            'text' => 'content.documents',
                                            'father' => 'production.workbook',
                                            'route' => null,
                                            'icon' => 'fa fa-file-text',
                                        ]);

                                                        DB::table('menus')->insert([
                                                            'name' => 'production.workbook.documents.folios',
                                                            'text' => 'content.folios',
                                                            'father' => 'production.workbook.documents',
                                                            'route' => 'dashboard',
                                                            'icon' => null,
                                                        ]);

                                                        DB::table('menus')->insert([
                                                            'name' => 'production.workbook.documents.dailyReports',
                                                            'text' => 'content.dailyReports',
                                                            'father' => 'production.workbook.documents',
                                                            'route' => 'dashboard',
                                                            'icon' => null,
                                                        ]);

                                                        DB::table('menus')->insert([
                                                            'name' => 'production.workbook.documents.notes',
                                                            'text' => 'content.notes',
                                                            'father' => 'production.workbook.documents',
                                                            'route' => 'dashboard',
                                                            'icon' => null,
                                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'production.workbook.reports',
                                            'text' => 'content.reports',
                                            'father' => 'production.workbook',
                                            'route' => null,
                                            'icon' => 'fa fa-print',
                                        ]);

                                                        DB::table('menus')->insert([
                                                            'name' => 'production.workbook.reports.folios',
                                                            'text' => 'content.folios',
                                                            'father' => 'production.workbook.reports',
                                                            'route' => 'dashboard',
                                                            'icon' => null,
                                                        ]);

                                                        DB::table('menus')->insert([
                                                            'name' => 'production.workbook.reports.dailyReports',
                                                            'text' => 'content.dailyReports',
                                                            'father' => 'production.workbook.reports',
                                                            'route' => 'dashboard',
                                                            'icon' => null,
                                                        ]);

                                                        DB::table('menus')->insert([
                                                            'name' => 'production.workbook.reports.notes',
                                                            'text' => 'content.notes',
                                                            'father' => 'production.workbook.reports',
                                                            'route' => 'dashboard',
                                                            'icon' => null,
                                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'production.workbook.settings',
                                            'text' => 'content.settings',
                                            'father' => 'production.workbook',
                                            'route' => null,
                                            'icon' => 'fa fa-cogs',
                                        ]);

                                                        DB::table('menus')->insert([
                                                            'name' => 'production.workbook.settings.users',
                                                            'text' => 'content.users',
                                                            'father' => 'production.workbook.settings',
                                                            'route' => 'dashboard',
                                                            'icon' => null,
                                                        ]);

                                                        DB::table('menus')->insert([
                                                            'name' => 'production.workbook.settings.locations',
                                                            'text' => 'content.locations',
                                                            'father' => 'production.workbook.settings',
                                                            'route' => 'dashboard',
                                                            'icon' => null,
                                                        ]); */

        // Commercial Menu
        
        DB::table('menus')->insert([
            'name' => 'commercial',
            'text' => 'content.commercial',
            'route' => null,
            'icon' => 'fa fa-cash-register',
        ]);

                        DB::table('menus')->insert([
                            'name' => 'commercial.controls',
                            'text' => 'content.controls',
                            'father' => 'commercial',
                            'route' => 'commercial.controls.home',
                            'icon' => 'fa fa-square-check',
                        ]);

                                        /* DB::table('menus')->insert([
                                            'name' => 'commercial.controls.needRequests',
                                            'text' => 'content.needRequests',
                                            'father' => 'commercial.controls',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-list',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'commercial.controls.receptions',
                                            'text' => 'content.receptions',
                                            'father' => 'commercial.controls',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-inbox',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'commercial.controls.destocking',
                                            'text' => 'content.destocking',
                                            'father' => 'commercial.controls',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-arrow-left',
                                        ]); */



                        DB::table('menus')->insert([
                            'name' => 'commercial.materials',
                            'text' => 'content.materials',
                            'father' => 'commercial',
                            'route' => 'commercial.materials.home',
                            'icon' => 'fa fa-cubes',
                        ]);

                                        /* DB::table('menus')->insert([
                                            'name' => 'commercial.materials.record',
                                            'text' => 'content.record',
                                            'father' => 'commercial.materials',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-pencil',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'commercial.materials.stockingUp',
                                            'text' => 'messages.stockingUp',
                                            'father' => 'commercial.materials',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-arrow-right',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'commercial.materials.reports',
                                            'text' => 'content.reports',
                                            'father' => 'commercial.materials',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-print',
                                        ]); */

                        DB::table('menus')->insert([
                            'name' => 'commercial.purchases',
                            'text' => 'content.purchases',
                            'father' => 'commercial',
                            'route' => 'commercial.purchases.home',
                            'icon' => 'fa fa-shopping-cart',
                        ]);

                                        /* DB::table('menus')->insert([
                                            'name' => 'commercial.purchases.purchaseRequests',
                                            'text' => 'messages.purchaseRequests',
                                            'father' => 'commercial.purchases',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-check-square',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'commercial.purchases.quotations',
                                            'text' => 'content.quotations',
                                            'father' => 'commercial.purchases',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-money',
                                        ]);
                                        
                                        DB::table('menus')->insert([
                                            'name' => 'commercial.purchases.purchaseOrders',
                                            'text' => 'messages.purchaseOrders',
                                            'father' => 'commercial.purchases',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-file-text-o',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'commercial.purchases.reports',
                                            'text' => 'content.reports',
                                            'father' => 'commercial.purchases',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-print',
                                        ]);  */

                        /* DB::table('menus')->insert([
                            'name' => 'commercial.contracts',
                            'text' => 'content.contracts',
                            'father' => 'commercial',
                            'route' => null,
                            'icon' => 'fa fa-bookmark',
                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'commercial.contracts.serviceRequests',
                                            'text' => 'messages.serviceRequests',
                                            'father' => 'commercial.contracts',
                                            'route' => 'serviceRequests.index',
                                            'icon' => 'fa fa-check-square',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'commercial.purchases.proposals',
                                            'text' => 'content.proposals',
                                            'father' => 'commercial.contracts',
                                            'route' => 'serviceProposals.index',
                                            'icon' => 'fa fa-money',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'commercial.contracts.serviceOrders',
                                            'text' => 'messages.serviceOrders',
                                            'father' => 'commercial.contracts',
                                            'route' => 'purchaseOrders.index',
                                            'icon' => 'fa fa-file-text-o',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'commercial.contracts.reports',
                                            'text' => 'content.reports',
                                            'father' => 'commercial.contracts',
                                            'route' => null,
                                            'icon' => 'fa fa-print',
                                        ]); */
                        
                        DB::table('menus')->insert([
                            'name' => 'commercial.warehouses',
                            'text' => 'content.warehouses',
                            'father' => 'commercial',
                            'route' => 'dashboard',
                            'icon' => 'fa fa-industry',
                        ]);             

                                        /* DB::table('menus')->insert([
                                            'name' => 'commercial.warehouses.record',
                                            'text' => 'content.record',
                                            'father' => 'commercial.warehouses',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-pencil',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'commercial.warehouses.reports',
                                            'text' => 'content.reports',
                                            'father' => 'commercial.warehouses',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-print',
                                        ]); */

                        DB::table('menus')->insert([
                            'name' => 'commercial.assets',
                            'text' => 'content.assets',
                            'father' => 'commercial',
                            'route' => 'dashboard',
                            'icon' => 'fa fa-cube',
                        ]);

                                        /* DB::table('menus')->insert([
                                            'name' => 'commercial.assets.record',
                                            'text' => 'content.record',
                                            'father' => 'commercial.assets',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-pencil',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'commercial.assets.assignments',
                                            'text' => 'content.assignments',
                                            'father' => 'commercial.assets',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-check-square',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'commercial.assets.updates',
                                            'text' => 'content.updates',
                                            'father' => 'commercial.assets',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-refresh',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'commercial.assets.reports',
                                            'text' => 'content.reports',
                                            'father' => 'commercial.assets',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-print',
                                        ]); */


        // Persons Menu 

        DB::table('menus')->insert([
            'name' => 'people',
            'text' => 'content.people',
            'route' => null,
            'icon' => 'fa fa-people-group',
        ]);
                        DB::table('menus')->insert([
                            'name' => 'people.record',
                            'text' => 'content.record',
                            'father' => 'people',
                            'route' => 'people.people.index',
                            'icon' => 'fa fa-pencil',
                        ]);

                        /* DB::table('menus')->insert([
                            'name' => 'people.payroll',
                            'text' => 'content.payroll',
                            'father' => 'people',
                            'route' => 'dashboard',
                            'icon' => 'fa fa-list',
                        ]); */

                        DB::table('menus')->insert([
                            'name' => 'people.timesheet',
                            'text' => 'content.timesheet',
                            'father' => 'people',
                            'route' => 'people.timesheet.home',
                            'icon' => 'fa fa-table',
                        ]); 
        
        // Safety & Health Menu 

        DB::table('menus')->insert([
            'name' => 'shw',
            'text' => 'content.safetyAndHealth',
            'route' => null,
            'icon' => 'fa fa-user-shield',
        ]);

                        DB::table('menus')->insert([
                            'name' => 'shw.ppes',
                            'text' => 'content.ppes',
                            'father' => 'shw',
                            'route' => 'dashboard',
                            'icon' => 'fa fa-medkit',
                        ]);

                                        /* DB::table('menus')->insert([
                                            'name' => 'shw.ppes.assignments',
                                            'text' => 'content.assignments',
                                            'father' => 'shw.ppes',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-check-square',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'shw.ppes.rules',
                                            'text' => 'content.rules',
                                            'father' => 'shw.ppes',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-list',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'shw.ppes.reports',
                                            'text' => 'content.reports',
                                            'father' => 'shw.ppes',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-print',
                                        ]); */

                        DB::table('menus')->insert([
                            'name' => 'shw.health',
                            'text' => 'content.health',
                            'father' => 'shw',
                            'route' => 'dashboard',
                            'icon' => 'fa fa-heart',
                        ]);

                                        /* DB::table('menus')->insert([
                                            'name' => 'shw.health.history',
                                            'text' => 'content.history',
                                            'father' => 'shw.health',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-folder-open',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'shw.health.record',
                                            'text' => 'content.record',
                                            'father' => 'shw.health',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-list',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'shw.health.reports',
                                            'text' => 'content.reports',
                                            'father' => 'shw.health',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-print',
                                        ]); */

                        DB::table('menus')->insert([
                            'name' => 'shw.access',
                            'text' => 'content.access',
                            'father' => 'shw',
                            'route' => 'dashboard',
                            'icon' => 'fa fa-sign-in',
                        ]);

                                        /* DB::table('menus')->insert([
                                            'name' => 'shw.access.requirements',
                                            'text' => 'content.requirements',
                                            'father' => 'shw.access',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-list',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'shw.access.profiles',
                                            'text' => 'content.profiles',
                                            'father' => 'shw.access',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-user',
                                        ]);


                                        DB::table('menus')->insert([
                                            'name' => 'shw.access.organizations',
                                            'text' => 'content.organizations',
                                            'father' => 'shw.access',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-institution',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'shw.access.checkings',
                                            'text' => 'content.checkings',
                                            'father' => 'shw.access',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-search',
                                        ]);

                                        DB::table('menus')->insert([
                                            'name' => 'shw.access.reports',
                                            'text' => 'content.reports',
                                            'father' => 'shw.access',
                                            'route' => 'dashboard',
                                            'icon' => 'fa fa-print',
                                        ]); */
    } 
}
