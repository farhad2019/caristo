<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LocalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locales')->insert([
            [
                'id'          => 1,
                'code'        => 'en',
                'title'       => 'English',
                'direction'   => 'LTR',
                'status'      => 1,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 2,
                'code'        => 'ar',
                'title'       => 'Arabic',
                'direction'   => 'RTL',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 3,
                'code'        => 'ab',
                'title'       => 'Abkhaz',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 4,
                'code'        => 'aa',
                'title'       => 'Afar',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 5,
                'code'        => 'af',
                'title'       => 'Afrikaans',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 6,
                'code'        => 'ak',
                'title'       => 'Akan',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 7,
                'code'        => 'sq',
                'title'       => 'Albanian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 8,
                'code'        => 'am',
                'title'       => 'Amharic',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 10,
                'code'        => 'an',
                'title'       => 'Aragonese',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 11,
                'code'        => 'hy',
                'title'       => 'Armenian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 12,
                'code'        => 'as',
                'title'       => 'Assamese',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 13,
                'code'        => 'av',
                'title'       => 'Avaric',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 14,
                'code'        => 'ae',
                'title'       => 'Avestan',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 15,
                'code'        => 'ay',
                'title'       => 'Aymara',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 16,
                'code'        => 'az',
                'title'       => 'Azerbaijani',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 17,
                'code'        => 'bm',
                'title'       => 'Bambara',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 18,
                'code'        => 'ba',
                'title'       => 'Bashkir',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 19,
                'code'        => 'eu',
                'title'       => 'Basque',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 20,
                'code'        => 'be',
                'title'       => 'Belarusian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 21,
                'code'        => 'bn',
                'title'       => 'Bengali',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 22,
                'code'        => 'bh',
                'title'       => 'Bihari',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 23,
                'code'        => 'bi',
                'title'       => 'Bislama',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 24,
                'code'        => 'bs',
                'title'       => 'Bosnian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 25,
                'code'        => 'br',
                'title'       => 'Breton',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 26,
                'code'        => 'bg',
                'title'       => 'Bulgarian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 27,
                'code'        => 'my',
                'title'       => 'Burmese',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 28,
                'code'        => 'ca',
                'title'       => 'Catalan; Valencian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 29,
                'code'        => 'ch',
                'title'       => 'Chamorro',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 30,
                'code'        => 'ce',
                'title'       => 'Chechen',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 31,
                'code'        => 'ny',
                'title'       => 'Chichewa; Chewa; Nyanja',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 32,
                'code'        => 'zh',
                'title'       => 'Chinese',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 33,
                'code'        => 'cv',
                'title'       => 'Chuvash',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 34,
                'code'        => 'kw',
                'title'       => 'Cornish',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 35,
                'code'        => 'co',
                'title'       => 'Corsican',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 36,
                'code'        => 'cr',
                'title'       => 'Cree',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 37,
                'code'        => 'hr',
                'title'       => 'Croatian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 38,
                'code'        => 'cs',
                'title'       => 'Czech',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 39,
                'code'        => 'da',
                'title'       => 'Danish',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 40,
                'code'        => 'dv',
                'title'       => 'Divehi; Dhivehi; Maldivian;',
                'direction'   => 'RTL',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 41,
                'code'        => 'nl',
                'title'       => 'Dutch',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 43,
                'code'        => 'eo',
                'title'       => 'Esperanto',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 44,
                'code'        => 'et',
                'title'       => 'Estonian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 45,
                'code'        => 'ee',
                'title'       => 'Ewe',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 46,
                'code'        => 'fo',
                'title'       => 'Faroese',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 47,
                'code'        => 'fj',
                'title'       => 'Fijian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 48,
                'code'        => 'fi',
                'title'       => 'Finnish',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 49,
                'code'        => 'fr',
                'title'       => 'French',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 50,
                'code'        => 'ff',
                'title'       => 'Fula; Fulah; Pulaar; Pular',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 51,
                'code'        => 'gl',
                'title'       => 'Galician',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 52,
                'code'        => 'ka',
                'title'       => 'Georgian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 53,
                'code'        => 'de',
                'title'       => 'German',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 54,
                'code'        => 'el',
                'title'       => 'Greek, Modern',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 55,
                'code'        => 'gn',
                'title'       => 'Guaraní',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 56,
                'code'        => 'gu',
                'title'       => 'Gujarati',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 57,
                'code'        => 'ht',
                'title'       => 'Haitian; Haitian Creole',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 58,
                'code'        => 'ha',
                'title'       => 'Hausa',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 59,
                'code'        => 'he',
                'title'       => 'Hebrew (modern)',
                'direction'   => 'RTL',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 60,
                'code'        => 'hz',
                'title'       => 'Herero',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 61,
                'code'        => 'hi',
                'title'       => 'Hindi',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 62,
                'code'        => 'ho',
                'title'       => 'Hiri Motu',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 63,
                'code'        => 'hu',
                'title'       => 'Hungarian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 64,
                'code'        => 'ia',
                'title'       => 'Interlingua',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 65,
                'code'        => 'id',
                'title'       => 'Indonesian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 66,
                'code'        => 'ie',
                'title'       => 'Interlingue',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 67,
                'code'        => 'ga',
                'title'       => 'Irish',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 68,
                'code'        => 'ig',
                'title'       => 'Igbo',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 69,
                'code'        => 'ik',
                'title'       => 'Inupiaq',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 70,
                'code'        => 'io',
                'title'       => 'Ido',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 71,
                'code'        => 'is',
                'title'       => 'Icelandic',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 72,
                'code'        => 'it',
                'title'       => 'Italian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 73,
                'code'        => 'iu',
                'title'       => 'Inuktitut',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 74,
                'code'        => 'ja',
                'title'       => 'Japanese',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 75,
                'code'        => 'jv',
                'title'       => 'Javanese',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 76,
                'code'        => 'kl',
                'title'       => 'Kalaallisut, Greenlandic',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 77,
                'code'        => 'kn',
                'title'       => 'Kannada',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 78,
                'code'        => 'kr',
                'title'       => 'Kanuri',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 79,
                'code'        => 'ks',
                'title'       => 'Kashmiri',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 80,
                'code'        => 'kk',
                'title'       => 'Kazakh',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 81,
                'code'        => 'km',
                'title'       => 'Khmer',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 82,
                'code'        => 'ki',
                'title'       => 'Kikuyu, Gikuyu',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 83,
                'code'        => 'rw',
                'title'       => 'Kinyarwanda',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 84,
                'code'        => 'ky',
                'title'       => 'Kirghiz, Kyrgyz',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 85,
                'code'        => 'kv',
                'title'       => 'Komi',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 86,
                'code'        => 'kg',
                'title'       => 'Kongo',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 87,
                'code'        => 'ko',
                'title'       => 'Korean',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 88,
                'code'        => 'ku',
                'title'       => 'Kurdish',
                'direction'   => 'RTL',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 89,
                'code'        => 'kj',
                'title'       => 'Kwanyama, Kuanyama',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 90,
                'code'        => 'la',
                'title'       => 'Latin',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 91,
                'code'        => 'lb',
                'title'       => 'Luxembourgish, Letzeburgesch',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 92,
                'code'        => 'lg',
                'title'       => 'Luganda',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 93,
                'code'        => 'li',
                'title'       => 'Limburgish, Limburgan, Limburger',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 94,
                'code'        => 'ln',
                'title'       => 'Lingala',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 95,
                'code'        => 'lo',
                'title'       => 'Lao',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 96,
                'code'        => 'lt',
                'title'       => 'Lithuanian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 97,
                'code'        => 'lu',
                'title'       => 'Luba-Katanga',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 98,
                'code'        => 'lv',
                'title'       => 'Latvian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 99,
                'code'        => 'gv',
                'title'       => 'Manx',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 100,
                'code'        => 'mk',
                'title'       => 'Macedonian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 101,
                'code'        => 'mg',
                'title'       => 'Malagasy',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 102,
                'code'        => 'ms',
                'title'       => 'Malay',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 103,
                'code'        => 'ml',
                'title'       => 'Malayalam',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 104,
                'code'        => 'mt',
                'title'       => 'Maltese',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 105,
                'code'        => 'mi',
                'title'       => 'Māori',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 106,
                'code'        => 'mr',
                'title'       => 'Marathi (Marāṭhī)',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 107,
                'code'        => 'mh',
                'title'       => 'Marshallese',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 108,
                'code'        => 'mn',
                'title'       => 'Mongolian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 109,
                'code'        => 'na',
                'title'       => 'Nauru',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 110,
                'code'        => 'nv',
                'title'       => 'Navajo, Navaho',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 111,
                'code'        => 'nb',
                'title'       => 'Norwegian Bokmål',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 112,
                'code'        => 'nd',
                'title'       => 'North Ndebele',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 113,
                'code'        => 'ne',
                'title'       => 'Nepali',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 114,
                'code'        => 'ng',
                'title'       => 'Ndonga',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 115,
                'code'        => 'nn',
                'title'       => 'Norwegian Nynorsk',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 116,
                'code'        => 'no',
                'title'       => 'Norwegian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 117,
                'code'        => 'ii',
                'title'       => 'Nuosu',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 118,
                'code'        => 'nr',
                'title'       => 'South Ndebele',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 119,
                'code'        => 'oc',
                'title'       => 'Occitan',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 120,
                'code'        => 'oj',
                'title'       => 'Ojibwe, Ojibwa',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 121,
                'code'        => 'cu',
                'title'       => 'Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 122,
                'code'        => 'om',
                'title'       => 'Oromo',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 123,
                'code'        => 'or',
                'title'       => 'Oriya',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 124,
                'code'        => 'os',
                'title'       => 'Ossetian, Ossetic',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 125,
                'code'        => 'pa',
                'title'       => 'Panjabi, Punjabi',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 126,
                'code'        => 'pi',
                'title'       => 'Pāli',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 127,
                'code'        => 'fa',
                'title'       => 'Persian',
                'direction'   => 'RTL',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 128,
                'code'        => 'pl',
                'title'       => 'Polish',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 129,
                'code'        => 'ps',
                'title'       => 'Pashto, Pushto',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 130,
                'code'        => 'pt',
                'title'       => 'Portuguese',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 131,
                'code'        => 'qu',
                'title'       => 'Quechua',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 132,
                'code'        => 'rm',
                'title'       => 'Romansh',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 133,
                'code'        => 'rn',
                'title'       => 'Kirundi',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 134,
                'code'        => 'ro',
                'title'       => 'Romanian, Moldavian, Moldovan',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 135,
                'code'        => 'ru',
                'title'       => 'Russian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 136,
                'code'        => 'sa',
                'title'       => 'Sanskrit (Saṁskṛta)',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 137,
                'code'        => 'sc',
                'title'       => 'Sardinian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 138,
                'code'        => 'sd',
                'title'       => 'Sindhi',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 139,
                'code'        => 'se',
                'title'       => 'Northern Sami',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 140,
                'code'        => 'sm',
                'title'       => 'Samoan',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 141,
                'code'        => 'sg',
                'title'       => 'Sango',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 142,
                'code'        => 'sr',
                'title'       => 'Serbian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 143,
                'code'        => 'gd',
                'title'       => 'Scottish Gaelic; Gaelic',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 144,
                'code'        => 'sn',
                'title'       => 'Shona',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 145,
                'code'        => 'si',
                'title'       => 'Sinhala, Sinhalese',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 146,
                'code'        => 'sk',
                'title'       => 'Slovak',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 147,
                'code'        => 'sl',
                'title'       => 'Slovene',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 148,
                'code'        => 'so',
                'title'       => 'Somali',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 149,
                'code'        => 'st',
                'title'       => 'Southern Sotho',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 150,
                'code'        => 'es',
                'title'       => 'Spanish; Castilian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 151,
                'code'        => 'su',
                'title'       => 'Sundanese',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 152,
                'code'        => 'sw',
                'title'       => 'Swahili',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 153,
                'code'        => 'ss',
                'title'       => 'Swati',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 154,
                'code'        => 'sv',
                'title'       => 'Swedish',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 155,
                'code'        => 'ta',
                'title'       => 'Tamil',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 156,
                'code'        => 'te',
                'title'       => 'Telugu',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 157,
                'code'        => 'tg',
                'title'       => 'Tajik',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 158,
                'code'        => 'th',
                'title'       => 'Thai',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 159,
                'code'        => 'ti',
                'title'       => 'Tigrinya',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 160,
                'code'        => 'bo',
                'title'       => 'Tibetan Standard, Tibetan, Central',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 161,
                'code'        => 'tk',
                'title'       => 'Turkmen',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 162,
                'code'        => 'tl',
                'title'       => 'Tagalog',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 163,
                'code'        => 'tn',
                'title'       => 'Tswana',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 164,
                'code'        => 'to',
                'title'       => 'Tonga (Tonga Islands)',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 165,
                'code'        => 'tr',
                'title'       => 'Turkish',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 166,
                'code'        => 'ts',
                'title'       => 'Tsonga',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 167,
                'code'        => 'tt',
                'title'       => 'Tatar',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 168,
                'code'        => 'tw',
                'title'       => 'Twi',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 169,
                'code'        => 'ty',
                'title'       => 'Tahitian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 170,
                'code'        => 'ug',
                'title'       => 'Uighur, Uyghur',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 171,
                'code'        => 'uk',
                'title'       => 'Ukrainian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 172,
                'code'        => 'ur',
                'title'       => 'Urdu',
                'direction'   => 'RTL',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 173,
                'code'        => 'uz',
                'title'       => 'Uzbek',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 174,
                'code'        => 've',
                'title'       => 'Venda',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 175,
                'code'        => 'vi',
                'title'       => 'Viettitlese',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 176,
                'code'        => 'vo',
                'title'       => 'Volapük',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 177,
                'code'        => 'wa',
                'title'       => 'Walloon',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 178,
                'code'        => 'cy',
                'title'       => 'Welsh',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 179,
                'code'        => 'wo',
                'title'       => 'Wolof',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 180,
                'code'        => 'fy',
                'title'       => 'Western Frisian',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 181,
                'code'        => 'xh',
                'title'       => 'Xhosa',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 182,
                'code'        => 'yi',
                'title'       => 'Yiddish',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 183,
                'code'        => 'yo',
                'title'       => 'Yoruba',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id'          => 184,
                'code'        => 'za',
                'title'       => 'Zhuang, Chuang',
                'direction'   => 'LTR',
                'status'      => 0,
                'native_name' => null,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}