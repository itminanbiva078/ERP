<?php

namespace Database\Seeders;

use App\Models\TheamColor;
use Illuminate\Database\Seeder;

class TheamColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $themeColor = new TheamColor();
            $themeColor->company_id = 1;
            $themeColor->themes_bg_color = '#eeeeee';
            $themeColor->sidebar_bg_color = '#87af4b';
            $themeColor->sidebar_drop_bg_color = '#8ab34d';
            $themeColor->menu_font_color = '#ffffff';
            $themeColor->main_font_color = '#212730';
            $themeColor->red_color = '#ff1500';
            $themeColor->success_color ='#1c7847';
            $themeColor->border_color = '#e4e4e4';
            $themeColor->block_color = '#ffffff';
            $themeColor->icon_color = '#ffffff';
            $themeColor->button_bg_color = '#87af4b';
            $themeColor->button_font_color = '#ffffff';
            $themeColor->placeholder_color = '#dddddd';
            $themeColor->readonly_color = '#1C658C';
            $themeColor->input_background_color = '#fff';
            $themeColor->input_text_color = '#ddd';
            $themeColor->updated_by = 1;
            $themeColor->created_by = 1;
            $themeColor->deleted_by = 1;
            $themeColor->save();
    
    }
}
