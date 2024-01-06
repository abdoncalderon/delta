<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            'name' => 'Ecuador',
            'region_id' => '1',
            'code' => 'EC',
            'ccc' => '593',
        ]);
        DB::table('countries')->insert([
            'name' => 'España',
            'region_id' => '2',
            'code' => 'ES',
            'ccc' => '34',
        ]);
        DB::table('countries')->insert([
            'name' => 'Afganistán',
            'region_id' => '15',
            'code' => 'AFG',
            'ccc' => '93',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Albania',
            'region_id' => '3',
            'code' => 'ALB',
            'ccc' => '355',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Alemania',
            'region_id' => '2',
            'code' => 'DEU',
            'ccc' => '49',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Andorra',
            'region_id' => '3',
            'code' => 'AND',
            'ccc' => '376',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Angola',
            'region_id' => '6',
            'code' => 'AGO',
            'ccc' => '244',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Antigua y Barbuda',
            'region_id' => '13',
            'code' => 'ATG',
            'ccc' => '1',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Arabia Saudí',
            'region_id' => '16',
            'code' => 'SAU',
            'ccc' => '966',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Argelia',
            'region_id' => '10',
            'code' => 'DZA',
            'ccc' => '213',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Argentina',
            'region_id' => '1',
            'code' => 'ARG',
            'ccc' => '54',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Armenia',
            'region_id' => '16',
            'code' => 'ARM',
            'ccc' => '374',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Australia',
            'region_id' => '19',
            'code' => 'AUS',
            'ccc' => '61',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Austria',
            'region_id' => '2',
            'code' => 'AUT',
            'ccc' => '43',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Azerbaiyán',
            'region_id' => '16',
            'code' => 'AZE',
            'ccc' => '994',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Bahamas',
            'region_id' => '13',
            'code' => 'BHS',
            'ccc' => '1',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Bahréin',
            'region_id' => '16',
            'code' => 'BHR',
            'ccc' => '973',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Bangladesh',
            'region_id' => '15',
            'code' => 'BGD',
            'ccc' => '880',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Barbados',
            'region_id' => '13',
            'code' => 'BRB',
            'ccc' => '1',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Belarús',
            'region_id' => '4',
            'code' => 'BLR',
            'ccc' => '375',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Bélgica',
            'region_id' => '2',
            'code' => 'BEL',
            'ccc' => '32',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Belice',
            'region_id' => '11',
            'code' => 'BLZ',
            'ccc' => '501',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Benin',
            'region_id' => '8',
            'code' => 'BEN',
            'ccc' => '229',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Bhután',
            'region_id' => '15',
            'code' => 'BTN',
            'ccc' => '975',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Bolivia',
            'region_id' => '1',
            'code' => 'BOL',
            'ccc' => '591',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Bosnia y Herzegovina',
            'region_id' => '3',
            'code' => 'BIH',
            'ccc' => '387',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Botswana',
            'region_id' => '7',
            'code' => 'BWA',
            'ccc' => '267',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Brasil',
            'region_id' => '1',
            'code' => 'BRA',
            'ccc' => '55',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Brunei',
            'region_id' => '18',
            'code' => 'BRN',
            'ccc' => '673',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Bulgaria',
            'region_id' => '4',
            'code' => 'BGR',
            'ccc' => '359',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Burkina Faso',
            'region_id' => '8',
            'code' => 'BFA',
            'ccc' => '226',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Burundi',
            'region_id' => '9',
            'code' => 'BDI',
            'ccc' => '257',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Cabo Verde',
            'region_id' => '8',
            'code' => 'CPV',
            'ccc' => '238',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Camboya',
            'region_id' => '18',
            'code' => 'KHM',
            'ccc' => '855',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Camerún',
            'region_id' => '6',
            'code' => 'CMR',
            'ccc' => '237',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Canadá',
            'region_id' => '12',
            'code' => 'CAN',
            'ccc' => '1',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Chad',
            'region_id' => '6',
            'code' => 'TCD',
            'ccc' => '235',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Chile',
            'region_id' => '1',
            'code' => 'CHL',
            'ccc' => '56',
        ]); 
        DB::table('countries')->insert([
            'name' => 'China',
            'region_id' => '17',
            'code' => 'CHN',
            'ccc' => '86',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Chipre',
            'region_id' => '16',
            'code' => 'CYP',
            'ccc' => '357',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Colombia',
            'region_id' => '1',
            'code' => 'COL',
            'ccc' => '57',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Comores',
            'region_id' => '9',
            'code' => 'COM',
            'ccc' => '269',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Congo',
            'region_id' => '6',
            'code' => 'COG',
            'ccc' => '242',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Corea del Norte',
            'region_id' => '17',
            'code' => 'PRK',
            'ccc' => '850',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Corea del Sur',
            'region_id' => '17',
            'code' => 'KOR',
            'ccc' => '82',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Costa de Marfil',
            'region_id' => '8',
            'code' => 'CIV',
            'ccc' => '225',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Costa Rica',
            'region_id' => '11',
            'code' => 'CRI',
            'ccc' => '506',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Croacia',
            'region_id' => '3',
            'code' => 'HRV',
            'ccc' => '385',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Cuba',
            'region_id' => '13',
            'code' => 'CUB',
            'ccc' => '53',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Dinamarca',
            'region_id' => '5',
            'code' => 'DNK',
            'ccc' => '45',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Djibouti',
            'region_id' => '9',
            'code' => 'DJI',
            'ccc' => '253',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Dominica',
            'region_id' => '13',
            'code' => 'DMA',
            'ccc' => '1',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Egipto',
            'region_id' => '10',
            'code' => 'EGY',
            'ccc' => '20',
        ]); 
        DB::table('countries')->insert([
            'name' => 'El Salvador',
            'region_id' => '11',
            'code' => 'SLV',
            'ccc' => '503',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Emiratos Árabes Unidos',
            'region_id' => '16',
            'code' => 'ARE',
            'ccc' => '971',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Eritrea',
            'region_id' => '9',
            'code' => 'ERI',
            'ccc' => '291',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Eslovenia',
            'region_id' => '3',
            'code' => 'SVN',
            'ccc' => '386',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Estados Unidos de América',
            'region_id' => '12',
            'code' => 'USA',
            'ccc' => '1',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Estonia',
            'region_id' => '5',
            'code' => 'EST',
            'ccc' => '372',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Etiopía',
            'region_id' => '9',
            'code' => 'ETH',
            'ccc' => '251',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Fiji',
            'region_id' => '20',
            'code' => 'FJI',
            'ccc' => '679',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Filipinas',
            'region_id' => '18',
            'code' => 'PHL',
            'ccc' => '63',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Finlandia',
            'region_id' => '5',
            'code' => 'FIN',
            'ccc' => '358',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Francia',
            'region_id' => '2',
            'code' => 'FRA',
            'ccc' => '33',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Gabón',
            'region_id' => '6',
            'code' => 'GAB',
            'ccc' => '241',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Gambia',
            'region_id' => '8',
            'code' => 'GMB',
            'ccc' => '220',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Georgia',
            'region_id' => '16',
            'code' => 'GEO',
            'ccc' => '995',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Ghana',
            'region_id' => '8',
            'code' => 'GHA',
            'ccc' => '233',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Granada',
            'region_id' => '13',
            'code' => 'GRD',
            'ccc' => '1',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Grecia',
            'region_id' => '3',
            'code' => 'GRC',
            'ccc' => '30',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Guatemala',
            'region_id' => '11',
            'code' => 'GTM',
            'ccc' => '502',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Guinea Ecuatorial',
            'region_id' => '6',
            'code' => 'GNQ',
            'ccc' => '240',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Guinea',
            'region_id' => '8',
            'code' => 'GIN',
            'ccc' => '224',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Guinea-Bissau',
            'region_id' => '8',
            'code' => 'GNB',
            'ccc' => '245',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Guyana',
            'region_id' => '1',
            'code' => 'GUY',
            'ccc' => '592',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Haití',
            'region_id' => '13',
            'code' => 'HTI',
            'ccc' => '509',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Honduras',
            'region_id' => '11',
            'code' => 'HND',
            'ccc' => '504',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Hungría',
            'region_id' => '4',
            'code' => 'HUN',
            'ccc' => '36',
        ]); 
        DB::table('countries')->insert([
            'name' => 'India',
            'region_id' => '15',
            'code' => 'IND',
            'ccc' => '91',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Indonesia',
            'region_id' => '18',
            'code' => 'IDN',
            'ccc' => '62',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Irán',
            'region_id' => '15',
            'code' => 'IRN',
            'ccc' => '98',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Iraq',
            'region_id' => '16',
            'code' => 'IRQ',
            'ccc' => '964',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Irlanda',
            'region_id' => '5',
            'code' => 'IRL',
            'ccc' => '353',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Islandia',
            'region_id' => '5',
            'code' => 'ISL',
            'ccc' => '354',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Islas Marshall',
            'region_id' => '21',
            'code' => 'MHL',
            'ccc' => '692',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Islas Salomón',
            'region_id' => '20',
            'code' => 'SLB',
            'ccc' => '677',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Israel',
            'region_id' => '16',
            'code' => 'ISR',
            'ccc' => '972',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Italia',
            'region_id' => '3',
            'code' => 'ITA',
            'ccc' => '39',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Jamaica',
            'region_id' => '13',
            'code' => 'JAM',
            'ccc' => '1',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Japón',
            'region_id' => '17',
            'code' => 'JPN',
            'ccc' => '81',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Jordania',
            'region_id' => '16',
            'code' => 'JOR',
            'ccc' => '962',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Kazajstán',
            'region_id' => '14',
            'code' => 'KAZ',
            'ccc' => '7',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Kenia',
            'region_id' => '9',
            'code' => 'KEN',
            'ccc' => '254',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Kirguistán',
            'region_id' => '14',
            'code' => 'KGZ',
            'ccc' => '996',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Kiribati',
            'region_id' => '21',
            'code' => 'KIR',
            'ccc' => '686',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Kuwait',
            'region_id' => '16',
            'code' => 'KWT',
            'ccc' => '965',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Laos',
            'region_id' => '18',
            'code' => 'LAO',
            'ccc' => '856',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Lesotho',
            'region_id' => '7',
            'code' => 'LSO',
            'ccc' => '266',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Letonia',
            'region_id' => '5',
            'code' => 'LVA',
            'ccc' => '371',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Líbano',
            'region_id' => '16',
            'code' => 'LBN',
            'ccc' => '961',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Liberia',
            'region_id' => '8',
            'code' => 'LBR',
            'ccc' => '231',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Libia',
            'region_id' => '10',
            'code' => 'LBY',
            'ccc' => '218',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Liechtenstein',
            'region_id' => '2',
            'code' => 'LIE',
            'ccc' => '423',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Lituania',
            'region_id' => '5',
            'code' => 'LTU',
            'ccc' => '370',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Luxemburgo',
            'region_id' => '2',
            'code' => 'LUX',
            'ccc' => '352',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Macedonia',
            'region_id' => '3',
            'code' => 'MKD',
            'ccc' => '389',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Madagascar',
            'region_id' => '9',
            'code' => 'MDG',
            'ccc' => '261',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Malasia',
            'region_id' => '18',
            'code' => 'MYS',
            'ccc' => '60',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Malawi',
            'region_id' => '9',
            'code' => 'MWI',
            'ccc' => '265',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Maldivas',
            'region_id' => '15',
            'code' => 'MDV',
            'ccc' => '960',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Mali',
            'region_id' => '8',
            'code' => 'MLI',
            'ccc' => '223',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Malta',
            'region_id' => '3',
            'code' => 'MLT',
            'ccc' => '356',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Marruecos',
            'region_id' => '10',
            'code' => 'MAR',
            'ccc' => '212',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Mauricio',
            'region_id' => '9',
            'code' => 'MUS',
            'ccc' => '230',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Mauritania',
            'region_id' => '8',
            'code' => 'MRT',
            'ccc' => '222',
        ]); 
        DB::table('countries')->insert([
            'name' => 'México',
            'region_id' => '11',
            'code' => 'MEX',
            'ccc' => '52',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Micronesia',
            'region_id' => '21',
            'code' => 'FSM',
            'ccc' => '691',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Moldavia',
            'region_id' => '4',
            'code' => 'MDA',
            'ccc' => '373',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Mónaco',
            'region_id' => '2',
            'code' => 'MCO',
            'ccc' => '377',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Mongolia',
            'region_id' => '17',
            'code' => 'MNG',
            'ccc' => '976',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Montenegro',
            'region_id' => '3',
            'code' => 'MNE',
            'ccc' => '382',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Mozambique',
            'region_id' => '9',
            'code' => 'MOZ',
            'ccc' => '258',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Myanmar',
            'region_id' => '18',
            'code' => 'MMR',
            'ccc' => '95',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Namibia',
            'region_id' => '7',
            'code' => 'NAM',
            'ccc' => '264',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Nauru',
            'region_id' => '21',
            'code' => 'NRU',
            'ccc' => '674',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Nepal',
            'region_id' => '15',
            'code' => 'NPL',
            'ccc' => '977',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Nicaragua',
            'region_id' => '11',
            'code' => 'NIC',
            'ccc' => '505',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Níger',
            'region_id' => '8',
            'code' => 'NER',
            'ccc' => '227',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Nigeria',
            'region_id' => '8',
            'code' => 'NGA',
            'ccc' => '234',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Noruega',
            'region_id' => '5',
            'code' => 'NOR',
            'ccc' => '47',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Nueva Zelanda',
            'region_id' => '19',
            'code' => 'NZL',
            'ccc' => '64',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Omán',
            'region_id' => '16',
            'code' => 'OMN',
            'ccc' => '968',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Países Bajos',
            'region_id' => '2',
            'code' => 'NLD',
            'ccc' => '31',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Pakistán',
            'region_id' => '15',
            'code' => 'PAK',
            'ccc' => '92',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Palaos',
            'region_id' => '21',
            'code' => 'PLW',
            'ccc' => '680',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Panamá',
            'region_id' => '11',
            'code' => 'PAN',
            'ccc' => '507',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Papúa Nueva Guinea',
            'region_id' => '20',
            'code' => 'PNG',
            'ccc' => '675',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Paraguay',
            'region_id' => '1',
            'code' => 'PRY',
            'ccc' => '595',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Perú',
            'region_id' => '1',
            'code' => 'PER',
            'ccc' => '51',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Polonia',
            'region_id' => '4',
            'code' => 'POL',
            'ccc' => '48',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Portugal',
            'region_id' => '2',
            'code' => 'PRT',
            'ccc' => '351',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Qatar',
            'region_id' => '16',
            'code' => 'QAT',
            'ccc' => '974',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Reino Unido',
            'region_id' => '5',
            'code' => 'GBR',
            'ccc' => '44',
        ]); 
        DB::table('countries')->insert([
            'name' => 'República Centroafricana',
            'region_id' => '6',
            'code' => 'CAF',
            'ccc' => '236',
        ]); 
        DB::table('countries')->insert([
            'name' => 'República Checa',
            'region_id' => '4',
            'code' => 'CZE',
            'ccc' => '420',
        ]); 
        DB::table('countries')->insert([
            'name' => 'República Democrática del Congo',
            'region_id' => '6',
            'code' => 'COD',
            'ccc' => '243',
        ]); 
        DB::table('countries')->insert([
            'name' => 'República Dominicana',
            'region_id' => '13',
            'code' => 'DOM',
            'ccc' => '1',
        ]); 
        DB::table('countries')->insert([
            'name' => 'República Eslovaca',
            'region_id' => '4',
            'code' => 'SVK',
            'ccc' => '421',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Ruanda',
            'region_id' => '9',
            'code' => 'RWA',
            'ccc' => '250',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Rumanía',
            'region_id' => '4',
            'code' => 'ROU',
            'ccc' => '40',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Rusia',
            'region_id' => '4',
            'code' => 'RUS',
            'ccc' => '7',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Sáhara Occidental',
            'region_id' => '10',
            'code' => 'ESH',
            'ccc' => '212',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Samoa',
            'region_id' => '22',
            'code' => 'WSM',
            'ccc' => '685',
        ]); 
        DB::table('countries')->insert([
            'name' => 'San Cristóbal y Nieves',
            'region_id' => '13',
            'code' => 'KNA',
            'ccc' => '1',
        ]); 
        DB::table('countries')->insert([
            'name' => 'San Marino',
            'region_id' => '3',
            'code' => 'SMR',
            'ccc' => '378',
        ]); 
        DB::table('countries')->insert([
            'name' => 'San Vicente y las Granadinas',
            'region_id' => '13',
            'code' => 'VCT',
            'ccc' => '1',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Santa Lucía',
            'region_id' => '13',
            'code' => 'LCA',
            'ccc' => '1',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Santo Tomé y Príncipe',
            'region_id' => '6',
            'code' => 'STP',
            'ccc' => '239',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Senegal',
            'region_id' => '8',
            'code' => 'SEN',
            'ccc' => '221',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Serbia',
            'region_id' => '3',
            'code' => 'SRB',
            'ccc' => '381',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Seychelles',
            'region_id' => '9',
            'code' => 'SYC',
            'ccc' => '248',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Sierra Leona',
            'region_id' => '8',
            'code' => 'SLE',
            'ccc' => '232',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Singapur',
            'region_id' => '18',
            'code' => 'SGP',
            'ccc' => '65',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Siria',
            'region_id' => '16',
            'code' => 'SYR',
            'ccc' => '963',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Somalia',
            'region_id' => '9',
            'code' => 'SOM',
            'ccc' => '252',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Sri Lanka',
            'region_id' => '15',
            'code' => 'LKA',
            'ccc' => '94',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Sudáfrica',
            'region_id' => '7',
            'code' => 'ZAF',
            'ccc' => '27',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Sudán',
            'region_id' => '10',
            'code' => 'SDN',
            'ccc' => '249',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Sudán del Sur',
            'region_id' => '10',
            'code' => 'SSD',
            'ccc' => '211',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Suecia',
            'region_id' => '5',
            'code' => 'SWE',
            'ccc' => '46',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Suiza',
            'region_id' => '2',
            'code' => 'CHE',
            'ccc' => '41',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Surinam',
            'region_id' => '1',
            'code' => 'SUR',
            'ccc' => '597',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Swazilandia',
            'region_id' => '7',
            'code' => 'SWZ',
            'ccc' => '268',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Tayikistán',
            'region_id' => '14',
            'code' => 'TJK',
            'ccc' => '992',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Tailandia',
            'region_id' => '18',
            'code' => 'THA',
            'ccc' => '66',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Tanzania',
            'region_id' => '9',
            'code' => 'TZA',
            'ccc' => '255',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Timor Oriental',
            'region_id' => '18',
            'code' => 'TLS',
            'ccc' => '670',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Togo',
            'region_id' => '8',
            'code' => 'TGO',
            'ccc' => '228',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Tonga',
            'region_id' => '22',
            'code' => 'TON',
            'ccc' => '676',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Trinidad y Tobago',
            'region_id' => '13',
            'code' => 'TTO',
            'ccc' => '1',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Túnez',
            'region_id' => '10',
            'code' => 'TUN',
            'ccc' => '216',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Turkmenistán',
            'region_id' => '14',
            'code' => 'TKM',
            'ccc' => '993',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Turquía',
            'region_id' => '16',
            'code' => 'TUR',
            'ccc' => '90',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Tuvalu',
            'region_id' => '22',
            'code' => 'TUV',
            'ccc' => '688',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Ucrania',
            'region_id' => '4',
            'code' => 'UKR',
            'ccc' => '380',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Uganda',
            'region_id' => '9',
            'code' => 'UGA',
            'ccc' => '256',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Uruguay',
            'region_id' => '1',
            'code' => 'URY',
            'ccc' => '598',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Uzbekistán',
            'region_id' => '14',
            'code' => 'UZB',
            'ccc' => '998',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Vanuatu',
            'region_id' => '20',
            'code' => 'VUT',
            'ccc' => '678',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Venezuela',
            'region_id' => '1',
            'code' => 'VEN',
            'ccc' => '58',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Vietnam',
            'region_id' => '18',
            'code' => 'VNM',
            'ccc' => '84',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Yemen',
            'region_id' => '16',
            'code' => 'YEM',
            'ccc' => '967',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Zambia',
            'region_id' => '9',
            'code' => 'ZMB',
            'ccc' => '260',
        ]); 
        DB::table('countries')->insert([
            'name' => 'Zimbabwe',
            'region_id' => '9',
            'code' => 'ZWE',
            'ccc' => '263',
        ]); 
        
    }
}
