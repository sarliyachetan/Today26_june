<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Product_image;
use DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function product()
    {
        $product = Product::latest('id')->where('soft_delete', '=', '0')->get();
        if (request()->ajax()) {
            return datatables()->of($product)
            
                ->editColumn('created_at', function ($product) {
                    return date('d-M-Y h:i:s a', strtotime($product->created_at));
                })
                ->addColumn('action', function ($product) {
                    return '<a data-toggle="tooltip" data-placement="top" title="Edit" data-id="' . $product->id . '" href="javascript:void(0)" class="btn btn-sm btn-warning productEdit"><i class="fa fa-edit"></i></a> '
                        . '<button onclick="ProductDelete(' . $product->id . ');" title="Delete" class="btn btn-danger btn-sm"><i style="color:#000;"class="fa fa-trash"></i></button>';
                })

                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.product');

    }
    public function productSave(Request $request)
    {
        $id             = $request->id;       
        $option_value   = $request->option_value;
        $product_image  = $request->product_image;
        $files          = $request->file('image_arr');       
        # Validation
        $validation_fields = [
            'product_name'     => 'required',
            'product_price'   => 'required',
            'product_desccription'         => 'required',

        ];
        $validation_msg = [
            'product_name'     => 'required',
            'product_price'   => 'required',
            'product_desccription'         => 'required',
        ];

        if($product_image && count($product_image)>0){
            $img_counter = 1;
            foreach ($product_image as $imgkey => $img) {
                if(!$id){
                    $validation_fields['image_arr.'.$imgkey]  = 'required';
                }               
                $validation_msg['image_arr.'.$imgkey.'.required']      = 'In Image tab, Image is required for row '.$img_counter.'.';
                $img_counter++;
            }            
        }
        else{
            // $validation_fields['images']       = 'required';
            // $validation_msg['images.required'] = 'Product Image is required!';
        }
        $validator = \Validator::make($request->all(), $validation_fields,$validation_msg);        
        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()->all()]);
        # Validation
        // dd($request->all());
        #Edit
        if ($id) {
            $product_arr  = array(
           
                'product_name'          => ($request->product_name) ? $request->product_name : '',
                'product_price'         => ($request->product_price) ? $request->product_price : 0,
                'product_desccription'   => ($request->product_desccription) ? $request->product_desccription : '',
                'updated_at'    => date('Y-m-d H:i:s'),
            );
            $product_affected =Product::where('id',$id)->update($product_arr);    
            #Image            
            if($product_image && (count($product_image) > 0)){
               
                $file_images  = array();
                if($files){
                    foreach($files as $fkey => $file){
                        $name=time().$fkey.'.'.$file->getClientOriginalExtension();   
                        $file->move('master/products/', $name);
                        $file_images[$fkey]['image']=$name;                       
                    }
                }
                $image_arr = array();
                foreach ($product_image as $key => $image) {                    

                    $image_arr[$key] = array(
                        'id'            => ($image['product_img_id']) ? $image['product_img_id'] : NULL,
                        'product_id'    => $id,
                        'image'         => isset($image['product_img_value']) ? $image['product_img_value'] : '',
                        'created_at'    => date('Y-m-d H:i:s'),
                        'updated_at'    => date('Y-m-d H:i:s'),
                    );
                }
                $final_file  = array_replace_recursive($image_arr, $file_images);                
                Product_image::where('product_id',$id)->delete();
                Product_image::insert($final_file);

            }
            
            if ($product_affected) {
                return response()->json([
                    'success' => 'Record updated successfully!'
                ]);
            } else {
                return response()->json([
                    'error' => 'Record could not update!'
                ]);
            }
         } 
        #Add

        else { 
       
            $product_arr  = array(
                'product_name'          => ($request->product_name) ? $request->product_name : '',
                'product_price'         => ($request->product_price) ? $request->product_price : 0,
                'product_desccription'   => ($request->product_desccription) ? $request->product_desccription : '',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            );         
            $product_id = Product::insertGetId($product_arr);
            if($product_id){
               
                #Image
                $file_images  = array();
                if($files){
                    foreach($files as $key => $file){
                        $name=time().$key.'.'.$file->getClientOriginalExtension();
                        $file->move('master/products/', $name);
                        $file_images[]['image']=$name;
                    }
                }
                if($product_image && (count($product_image) > 0) && count($file_images)>0){
                    $image_arr = array();
                    foreach ($product_image as $key => $image) {
                        $image_arr[] = array(
                            'product_id'    => $product_id,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'updated_at'    => date('Y-m-d H:i:s'),
                        );
                        
                    }
                    $final_file  = array_replace_recursive($image_arr, $file_images);
                    Product_image::insert($final_file);
                }
            
            }
            if ($product_id) {
                return response()->json([
                    'success' => 'Record added successfully!'
                ]);
            } else {
                return response()->json([
                    'error' => 'Record could not add!'
                ]);
            }
        }
    }
    public function productEdit($id)
    {
        $data = DB::table('products')->where(['id' => $id])->first();
        $images  = DB::table('product_images')->where('product_id', $id)->get();
        if($images && count($images)>0){
            foreach ($images as $key => $img) {
                $path = 'master/products/';
                // var_dump(file_exists($path.$img->image));
                if(file_exists($path.$img->image)){
                    $images[$key]->img_path = url('master/products/'.$img->image) ;
                }
                else{
                    $images[$key]->img_path = '' ;
                }                
            }
        }
        return response()->json([
            'success' => 'Record get successfully!',
            'data'                   => $data,
            'images'                 => $images,          

        ]);
     
    }
    public function ProductDelete(Request $request)
    {
        $id = $request->id;
        $userDelete = Product::where('id',$id)->update(['soft_delete'=>1]);
      
           if($userDelete){
               return response()->json(["status" => "0", "message" => "success", "data" => $userDelete]);
           }else{
              return response()->json(["status" => "1", "message" => "Sorry Can not Change Status....!!"]);
           }
    }

    public function logout(){
        auth()->logout();
        return redirect('/');
    }
}
