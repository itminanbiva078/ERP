<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $systemConfig=array(
       'site_name' => 'Master Accounting',
       'tag_line'=>  'Master Accounting', 
       'address'=>  'Head Office: 59 ,Bir Uttam C.R .Datta Road, Jahanara Bhaban (6th & 7th Floor), Hatirpool, Dhanmondi, Dhaka- 1205.', 
       'email'=> 'info@menzklub.com',
       'secondary_email'=> 'sales@menzklub.com',
       'mobile'=> '+8801755625066',
       'logo'=> 'logo_full1477.png', 
       'favicon'=> 'icon.png', 
       'site_screenshot'=> 'design_shirt_3.jpg',
        'site_meta_keywords'=> 'Shop, ecommerce, products, Menz Klub', 
        'site_meta_description'=> 'Menz Klub online shopping in Bangladesh. Shop online for latest Clothing .',
        'main_menu' => 'a:1:{s:9:\"menu_item\";a:40:{i:1;a:8:{s:2:\"id\";s:1:\"1\";s:4:\"p_id\";s:1:\"0\";s:9:\"menu_type\";s:10:\"category|1\";s:5:\"title\";s:10:\"COLLECTION\";s:4:\"link\";s:10:\"collection\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:2;a:8:{s:2:\"id\";s:1:\"2\";s:4:\"p_id\";s:1:\"1\";s:9:\"menu_type\";s:10:\"category|2\";s:5:\"title\";s:5:\"Shirt\";s:4:\"link\";s:5:\"shirt\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:3;a:8:{s:2:\"id\";s:1:\"3\";s:4:\"p_id\";s:1:\"2\";s:9:\"menu_type\";s:10:\"category|9\";s:5:\"title\";s:16:\"Basic ( formal )\";s:4:\"link\";s:12:\"basic-formal\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:4;a:8:{s:2:\"id\";s:1:\"4\";s:4:\"p_id\";s:1:\"2\";s:9:\"menu_type\";s:11:\"category|11\";s:5:\"title\";s:8:\"Designer\";s:4:\"link\";s:8:\"designer\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:5;a:8:{s:2:\"id\";s:1:\"5\";s:4:\"p_id\";s:1:\"2\";s:9:\"menu_type\";s:11:\"category|13\";s:5:\"title\";s:17:\"Master Collection\";s:4:\"link\";s:17:\"master-collection\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:6;a:8:{s:2:\"id\";s:1:\"6\";s:4:\"p_id\";s:1:\"1\";s:9:\"menu_type\";s:10:\"category|3\";s:5:\"title\";s:5:\"Polos\";s:4:\"link\";s:5:\"polos\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:7;a:8:{s:2:\"id\";s:1:\"7\";s:4:\"p_id\";s:1:\"6\";s:9:\"menu_type\";s:11:\"category|14\";s:5:\"title\";s:5:\"Plain\";s:4:\"link\";s:5:\"plain\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:8;a:8:{s:2:\"id\";s:1:\"8\";s:4:\"p_id\";s:1:\"6\";s:9:\"menu_type\";s:11:\"category|15\";s:5:\"title\";s:7:\"Printed\";s:4:\"link\";s:7:\"printed\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:9;a:8:{s:2:\"id\";s:1:\"9\";s:4:\"p_id\";s:1:\"6\";s:9:\"menu_type\";s:11:\"category|16\";s:5:\"title\";s:6:\"Stripe\";s:4:\"link\";s:6:\"stripe\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:10;a:8:{s:2:\"id\";s:2:\"10\";s:4:\"p_id\";s:1:\"6\";s:9:\"menu_type\";s:11:\"category|17\";s:5:\"title\";s:8:\"Designer\";s:4:\"link\";s:10:\"designer-1\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:11;a:8:{s:2:\"id\";s:2:\"11\";s:4:\"p_id\";s:1:\"1\";s:9:\"menu_type\";s:10:\"category|4\";s:5:\"title\";s:7:\"T-Shirt\";s:4:\"link\";s:7:\"t-shirt\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:12;a:8:{s:2:\"id\";s:2:\"12\";s:4:\"p_id\";s:2:\"11\";s:9:\"menu_type\";s:11:\"category|18\";s:5:\"title\";s:5:\"Plain\";s:4:\"link\";s:12:\"plaint-shirt\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:13;a:8:{s:2:\"id\";s:2:\"13\";s:4:\"p_id\";s:2:\"11\";s:9:\"menu_type\";s:11:\"category|19\";s:5:\"title\";s:7:\"Printed\";s:4:\"link\";s:9:\"printed-1\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:14;a:8:{s:2:\"id\";s:2:\"14\";s:4:\"p_id\";s:2:\"11\";s:9:\"menu_type\";s:11:\"category|20\";s:5:\"title\";s:9:\"Statement\";s:4:\"link\";s:9:\"statement\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:15;a:8:{s:2:\"id\";s:2:\"15\";s:4:\"p_id\";s:1:\"1\";s:9:\"menu_type\";s:10:\"category|5\";s:5:\"title\";s:8:\"Trousers\";s:4:\"link\";s:8:\"trousers\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:16;a:8:{s:2:\"id\";s:2:\"16\";s:4:\"p_id\";s:2:\"15\";s:9:\"menu_type\";s:11:\"category|22\";s:5:\"title\";s:6:\"Chinos\";s:4:\"link\";s:6:\"chinos\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:17;a:8:{s:2:\"id\";s:2:\"17\";s:4:\"p_id\";s:2:\"16\";s:9:\"menu_type\";s:11:\"category|52\";s:5:\"title\";s:7:\"Regular\";s:4:\"link\";s:9:\"regular-1\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:18;a:8:{s:2:\"id\";s:2:\"18\";s:4:\"p_id\";s:2:\"16\";s:9:\"menu_type\";s:11:\"category|23\";s:5:\"title\";s:4:\"Slim\";s:4:\"link\";s:4:\"slim\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:19;a:8:{s:2:\"id\";s:2:\"19\";s:4:\"p_id\";s:2:\"15\";s:9:\"menu_type\";s:11:\"category|50\";s:5:\"title\";s:6:\"Formal\";s:4:\"link\";s:6:\"formal\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:20;a:8:{s:2:\"id\";s:2:\"20\";s:4:\"p_id\";s:1:\"1\";s:9:\"menu_type\";s:10:\"category|6\";s:5:\"title\";s:7:\"Outwear\";s:4:\"link\";s:7:\"outwear\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:21;a:8:{s:2:\"id\";s:2:\"21\";s:4:\"p_id\";s:2:\"20\";s:9:\"menu_type\";s:11:\"category|24\";s:5:\"title\";s:4:\"Coat\";s:4:\"link\";s:4:\"coat\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:22;a:8:{s:2:\"id\";s:2:\"22\";s:4:\"p_id\";s:2:\"20\";s:9:\"menu_type\";s:11:\"category|25\";s:5:\"title\";s:6:\"Blazer\";s:4:\"link\";s:6:\"blazer\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:23;a:8:{s:2:\"id\";s:2:\"23\";s:4:\"p_id\";s:2:\"20\";s:9:\"menu_type\";s:11:\"category|26\";s:5:\"title\";s:4:\"Vest\";s:4:\"link\";s:4:\"vest\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:24;a:8:{s:2:\"id\";s:2:\"24\";s:4:\"p_id\";s:2:\"20\";s:9:\"menu_type\";s:11:\"category|27\";s:5:\"title\";s:6:\"Jacket\";s:4:\"link\";s:6:\"jacket\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:25;a:8:{s:2:\"id\";s:2:\"25\";s:4:\"p_id\";s:2:\"20\";s:9:\"menu_type\";s:11:\"category|28\";s:5:\"title\";s:7:\"Sweater\";s:4:\"link\";s:7:\"sweater\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:26;a:8:{s:2:\"id\";s:2:\"26\";s:4:\"p_id\";s:1:\"1\";s:9:\"menu_type\";s:10:\"category|7\";s:5:\"title\";s:5:\"Jeans\";s:4:\"link\";s:5:\"jeans\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:27;a:8:{s:2:\"id\";s:2:\"27\";s:4:\"p_id\";s:2:\"26\";s:9:\"menu_type\";s:11:\"category|29\";s:5:\"title\";s:7:\"Regular\";s:4:\"link\";s:7:\"regular\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:28;a:8:{s:2:\"id\";s:2:\"28\";s:4:\"p_id\";s:2:\"26\";s:9:\"menu_type\";s:11:\"category|30\";s:5:\"title\";s:14:\"Narrow(skinny)\";s:4:\"link\";s:12:\"nerrowskinny\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:29;a:8:{s:2:\"id\";s:2:\"29\";s:4:\"p_id\";s:2:\"26\";s:9:\"menu_type\";s:11:\"category|31\";s:5:\"title\";s:7:\"Tapered\";s:4:\"link\";s:7:\"tapered\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:30;a:8:{s:2:\"id\";s:2:\"30\";s:4:\"p_id\";s:1:\"1\";s:9:\"menu_type\";s:10:\"category|8\";s:5:\"title\";s:7:\"Panjabi\";s:4:\"link\";s:7:\"panjabi\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:31;a:8:{s:2:\"id\";s:2:\"31\";s:4:\"p_id\";s:2:\"30\";s:9:\"menu_type\";s:11:\"category|32\";s:5:\"title\";s:7:\"Regular\";s:4:\"link\";s:15:\"regular-panjabi\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:32;a:8:{s:2:\"id\";s:2:\"32\";s:4:\"p_id\";s:2:\"30\";s:9:\"menu_type\";s:11:\"category|33\";s:5:\"title\";s:8:\"Designer\";s:4:\"link\";s:15:\"designerpanjabi\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:33;a:8:{s:2:\"id\";s:2:\"33\";s:4:\"p_id\";s:1:\"0\";s:9:\"menu_type\";s:2:\"cl\";s:5:\"title\";s:47:\"What\'s <div id=\"burst-8\"><span>NEW</span></div>\";s:4:\"link\";s:9:\"whats-new\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:34;a:8:{s:2:\"id\";s:2:\"34\";s:4:\"p_id\";s:1:\"0\";s:9:\"menu_type\";s:11:\"category|34\";s:5:\"title\";s:11:\"Accessories\";s:4:\"link\";s:11:\"accessories\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:35;a:8:{s:2:\"id\";s:2:\"35\";s:4:\"p_id\";s:2:\"34\";s:9:\"menu_type\";s:11:\"category|35\";s:5:\"title\";s:4:\"Belt\";s:4:\"link\";s:4:\"belt\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:36;a:8:{s:2:\"id\";s:2:\"36\";s:4:\"p_id\";s:2:\"34\";s:9:\"menu_type\";s:11:\"category|36\";s:5:\"title\";s:3:\"Tie\";s:4:\"link\";s:3:\"tie\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:37;a:8:{s:2:\"id\";s:2:\"37\";s:4:\"p_id\";s:2:\"34\";s:9:\"menu_type\";s:11:\"category|37\";s:5:\"title\";s:5:\"Socks\";s:4:\"link\";s:5:\"socks\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:38;a:8:{s:2:\"id\";s:2:\"38\";s:4:\"p_id\";s:2:\"34\";s:9:\"menu_type\";s:11:\"category|38\";s:5:\"title\";s:10:\"Body Spray\";s:4:\"link\";s:10:\"body-spray\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:39;a:8:{s:2:\"id\";s:2:\"39\";s:4:\"p_id\";s:2:\"34\";s:9:\"menu_type\";s:11:\"category|39\";s:5:\"title\";s:6:\"Inners\";s:4:\"link\";s:6:\"inners\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:40;a:8:{s:2:\"id\";s:2:\"40\";s:4:\"p_id\";s:2:\"34\";s:9:\"menu_type\";s:11:\"category|51\";s:5:\"title\";s:6:\"Wallet\";s:4:\"link\";s:6:\"wallet\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}}}',
        'fb_page' => 'http://facebook.com/nextpagetl',
        'gp_page' => 'http://facebook.com/nextpagetl',
        'tt_page' => 'http://facebook.com/nextpagetl',
        'li_page' => 'http://facebook.com/nextpagetl',
        'youtube_page'=> 'http://facebook.com/nextpagetl', 
        'website'=> 'https://www.menzklub.com',
        'about'=> 'Menz Klub', 
        'country'=> 'Bangladesh', 
        'is_cache_enable'=> '1', 
        'cache_update_time'=> '10', 
       
        'sm_theme_options_other_setting'=> 'a:7:{s:29:\"checkout_is_breadcrumb_enable\";s:1:\"0\";s:21:\"checkout_banner_title\";s:8:\"Checkout\";s:24:\"checkout_banner_subtitle\";s:24:\"A World of Opportunities\";s:21:\"checkout_banner_image\";N;s:20:\"checkout_email_label\";s:35:\"Please provide your email address :\";s:26:\"checkout_email_description\";s:147:\"Please enter an email address you check regularly, as we use this to send updates regarding your job. this email address with the service provider.\";s:28:\"checkout_payment_description\";N;}',
        'currency' => 'BDT', 
        'primary_color'=> NULL, 
        'secondary_color'=> NULL, 
        'fb_api_enable'=> 'on', 
        'fb_app_id'=> '1594459254020115', 
        'fb_app_secret'=> '0a1d1159456efd0b57026314b244e1ef', 
        'seo_title'=> 'Premium Men\'s Clothing | Menz Klub',
        'gp_api_enable'=> 'on',
        'gp_client_id'=> '#',
        'gp_client_secret'=> '#',
        'is_tax_enable'=> '1', 
        'default_tax'=> '7.5',
        'default_tax_type' => '2', 
        'shop_url' => 'https://menzklub.com/category-list/collection'
       );



       foreach($systemConfig as $key => $value):
            $setting = new Setting();
            $setting->company_id =1;
            $setting->option_name = $key;
            $setting->option_value = $value;
            $setting->modified_by = 1;
            $setting->created_by = 1;
            $setting->deleted_by = 1;
            $setting->save();
       endforeach;



}
}
