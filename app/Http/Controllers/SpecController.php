<?php
namespace App\Http\Controllers;

use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ic_category;
use Illuminate\Support\Facades\Config;
use App\Models\SpecProduct;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SpecExport;
use App\Imports\SpecImport;

class SpecController extends Controller
{
    public function spec_index(request $request){
        $item_code = $request->item_code;
        $item = DB::select('select code,name_1,item_category,(SELECT name_1 FROM ic_category where code=a.item_category) as cat_name from ic_inventory a where code = ?', [$item_code]);

        $cat = $item[0]->item_category;

        $sql = DB::SELECT("SELECT roworder,filedname,filedname_lao FROM tb_attribute where code='$cat' and active ='1'");
        

        return view('manage-data.spec.specdetail',compact('sql','item'));
    } 

    public function spec_save(request $request){


        $item_code = $request->item_code;
        // $sql = DB::connection('pgsql_odmall')->SELECT("SELECT filedname FROM tb_attribute where code='011' and active ='1'");
        foreach($request->arrtibute_id as $key => $item){
            $name_1 = $request->attribute_value[$key];
            $name_2 = $item .' : '.$name_1;
        DB::INSERT("INSERT INTO ic_name_short(ic_code,name_1) VALUES('$item_code','$name_2')");
        }

    
        $images = [];
        if($request->hasfile('images'))
        {
            foreach($request->file('images') as $key => $img)
            {
                $name = time().rand(1,100).'.'.$img->extension();
                $img->move(public_path('images/'), $name);
                $images[] = $name;
                $sql = DB::insert("insert into tb_images(ic_code,images)values('$item_code','$images[$key]')");
            }
        }

        if($sql){
            return 'success';
        }
        
    }

    public function attribute_index(request $request)    
    {
        $sql_id = $request->cat_id;

        $sql_cat = DB::select("select code,name_1 FROM ic_category where code='$sql_id'");
        $sql = DB::SELECT("SELECT roworder,filedname,filedname_lao FROM tb_attribute where code='$sql_id' and active ='1'");

        return view('manage-data.spec.attribute',compact('sql','sql_cat'));
    }

    public function category_index(request $request)
    {
        // $sql_cat = DB::select("select code,name_1 FROM ic_category");
        $sql = ic_category::select('code','name_1')->paginate(15);

        return view('manage-data.spec.category',compact('sql'));
    }

    public function save_attribute(request $request)
    {
        $item_cat = $request->cat_id;
        $filedname = $request->filedname;
        $filedname_lao = $request->filedname_lao;

        $line_number = DB::select("select count(line_number) as count FROM tb_attribute where code='$item_cat'");

        $load_last_id = $line_number[0]->count;

            $max_id = $load_last_id + 1;
            if ($max_id < 10) {
                $code = '00000' . $max_id;
            } else if ($max_id < 100) {
                $code = '0000' . $max_id;
            } else if ($max_id < 1000) {
                $code = '000' . $max_id;
            }else if ($max_id < 10000) {
                $code = '00' . $max_id;
            }else if ($max_id < 100000) {
                $code = '0' . $max_id;
            } else {
                $code = $max_id;
            }
            

        $sql = DB::INSERT("INSERT INTO tb_attribute(code,filedname,filedname_lao,active,line_number)VALUES('$item_cat','$filedname','$filedname_lao',1,'$code')");

        if($sql){

            return Redirect::route('attribute-index', [$item_cat,$filedname_lao]);
        }
    }


    public function import_index()
    {
        $Specs = SpecProduct::get();
  
        return view('manage-data.spec.importspect', compact('Specs'));
    }
        
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new SpecExport, 'spec_'.date('d_M_Y-h-i-s-A').'.xlsx');
    }
       
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import() 
    {
        DB::delete("DELETE FROM temp_import_attribute");
        Excel::import(new SpecImport,request()->file('file'));
        return back();
    }


}
?>
