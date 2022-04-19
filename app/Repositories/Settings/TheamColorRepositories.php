<?php

namespace App\Repositories\Settings;
Use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\TheamColor;

class TheamColorRepositories
{
   
    
    public function __construct(TheamColor $theamColor)
    {
        $this->theamColor = $theamColor;
        
    }

    public function store($request)
    {

        $colorExitsCheck =$this->theamColor::company()->first();
        if(empty($colorExitsCheck)): 
            $theamColor = new $this->theamColor();
        else: 
            $theamColor = $colorExitsCheck;
        endif;
       
        $theamColor->themes_bg_color = $request->themes_bg_color ;
        $theamColor->sidebar_bg_color = $request->sidebar_bg_color;
        $theamColor->sidebar_drop_bg_color = $request->sidebar_drop_bg_color;
        $theamColor->menu_font_color = $request->menu_font_color;
        $theamColor->main_font_color = $request->main_font_color;
        $theamColor->red_color = $request->red_color;
        $theamColor->success_color = $request->success_color;
        $theamColor->border_color = $request->border_color;
        $theamColor->block_color = $request->block_color;
        $theamColor->icon_color = $request->icon_color;
        $theamColor->button_bg_color = $request->button_bg_color;
        $theamColor->button_font_color = $request->button_font_color;
        $theamColor->placeholder_color = $request->placeholder_color;
        $theamColor->readonly_color = $request->readonly_color;
        $theamColor->input_background_color = $request->input_background_color;
        $theamColor->input_text_color = $request->input_text_color;
        $theamColor->created_by =  helper::userId();
        $theamColor->company_id =  helper::companyId();
        $theamColor->save();
        return $theamColor;
    }

   

   

   
}