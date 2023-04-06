<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    private $od_url = "http://183.182.101.13:5000";
    private $pp_url = "http://183.182.101.13:4000";

    function load_data_from_api($url){
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);
        curl_close($curl_handle);
        // Decode JSON into PHP array
        return json_decode($curl_data);
    }


    public function load_brand($ch)
    {
        if ($ch == 'pp') {
            $set_url = $this->pp_url;
        } else {
            $set_url = $this->od_url;
        }
        $url = $set_url.'/load-ic-brand';
        $ic_category = $this->load_data_from_api($url);
        return $ic_category;
    }

    public function load_category($ch)
    {
        if ($ch == 'pp') {
            $set_url = $this->pp_url;
        } else {
            $set_url = $this->od_url;
        }
        $url = $set_url.'/load-ic-category';
        $ic_category = $this->load_data_from_api($url);
        return $ic_category;
    }

    public function load_max_code($base, $code_sub2)
    {
        ///ສ້າງລະຫັດສິນຄ້າ ໂດຍດຶງຈາກຖານຂໍ້ມູນມາສ້າງ ຖ້າຍັງບໍ່ມີຢູ່ຖານຂໍ້ມູນແມ່ນໃຫ້ ດຶງຈາກຖານຂໍ້ມູນຂອງ sml
        $load_id = DB::select("SELECT right(max(code), 4) as maxid FROM ic_inventory WHERE left (code, 5) = ?", [$code_sub2]);
        if ($load_id > 0) {
            return $load_id;
        } else {
            if ($base == 'od') {
                $set_url = $this->od_url;
            } else {
                $set_url = $this->pp_url;
            }
            $url = $set_url.'/load-max-code/'.$code_sub2;
            $ic_group_sub = $this->load_data_from_api($url);
            return $ic_group_sub;
        }
        
    }
    
    public function load_sub_group(Request $request)
    {
        $ch = $request->session()->get('choose-base');
        if ($ch == 'pp') {
            $set_url = $this->pp_url;
        } else {
            $set_url = $this->od_url;
        }
        $main_group = $request->main_group;
        $url = $set_url.'/load-ic-group-sub/'.$main_group;
        $ic_group_sub = $this->load_data_from_api($url);
        return $ic_group_sub;
    }
    public function load_sub_group2(Request $request)
    {
        $ch = $request->session()->get('choose-base');
        if ($ch == 'pp') {
            $set_url = $this->pp_url;
        } else {
            $set_url = $this->od_url;
        }
        $main_group = $request->main_group;
        $group_sub = $request->group_sub;
        
        $url = $set_url.'/load-ic-group-sub2/'.$main_group.'/'.$group_sub;
        $ic_group_sub = $this->load_data_from_api($url);
        return $ic_group_sub;
    }
    
    public function fetch_emp_fb_odien()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->od_url.'/crm_select_emp');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }

    
    public function fetch_emp_fb_pp()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->pp_url.'/crm_select_emp');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }

    public function fetch_group_fb_odien()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->od_url.'/crm_select_group');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }

    
    public function fetch_group_fb_pp()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->pp_url.'/crm_select_group');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }

    public function fetch_cate_fb_odien()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->od_url.'/crm_select_cate');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }

    
    public function fetch_cate_fb_pp()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->pp_url.'/crm_select_cate');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }
    public function fetch_brand_fb_odien()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->od_url.'/crm_select_brand');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }
    
    
    public function fetch_brand_fb_pp()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->pp_url.'/crm_select_brand');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }

    public function fetch_warehouse_from_odien()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->od_url.'/select_warehouse');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }

    public function fetch_warehouse_from_pp()
    {
        // Initiate curl session in a variable (resource)
        $curl_handle = curl_init();
        // Set the curl URL option
        curl_setopt($curl_handle, CURLOPT_URL, $this->pp_url.'/select_warehouse');

        // This option will return data as a string instead of direct output
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        // Execute curl & store data in a variable
        $curl_data = curl_exec($curl_handle);

        curl_close($curl_handle);

        // Decode JSON into PHP array
        $response_data = json_decode($curl_data);
        return $response_data;
    }
}