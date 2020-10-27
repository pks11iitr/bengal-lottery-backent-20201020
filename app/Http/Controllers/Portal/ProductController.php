<?php

namespace App\Http\Controllers\Portal;

use App\Models\MappedCode;
use App\Models\QRCode;
use App\QrCodes;
use Aws\Lambda\Exception\LambdaException;
use Aws\Lambda\LambdaClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RetrievedProducts;
use App\Models\CompanyProducts;
use Illuminate\Support\Facades\Auth;
use App\Traits\ImageUpload;
use Response;

class ProductController extends Controller
{
	use ImageUpload;
	// public function __construct() {
	// 	//die;
	// 	// $this->middleware("auth");

 //    }


//    public function detail(Request $request) {
//        return view('portal.product-detail');
//    }

    public function index(Request $request){
        $user = Auth::user();
    	$products = CompanyProducts::where('user_id',$user->id)->get();

        return view('portal.products',compact("products"));
    }

    public function productSearch(Request $request) {
        $this->validate($request, array(
            "q" => "required",
        ));
        $returnData = array();
        $term = $request->q;
        $comProducts = CompanyProducts::where('name','like',$term.'%')->get();
        if(!empty($comProducts) && count($comProducts) > 0) {
            foreach ($comProducts as $key => $value) {
                if(empty($returnData[$value->name]))
                    $returnData[$value->name] = array('label'=>ucfirst($value->name),'value'=>ucfirst($value->name),'category'=>'My Products');
            }
        }
        $comProducts = RetrievedProducts::where('product_name','like',$term.'%')->get();
        if(!empty($comProducts) && count($comProducts) > 0) {
            foreach ($comProducts as $key => $value) {
                if(empty($returnData[$value->product_name]))
                    $returnData[$value->product_name] = array('label'=>ucfirst($value->product_name),'value'=>ucfirst($value->product_name),'category'=>'Other Products');
            }
        }

        return Response::json(["returnData" => $returnData]);
    }

    public function productDetailAjax(Request $request) {
        $this->validate($request, array(
            "id" => "required",
        ));
        $returnData = array();
        $productId = $request->id;
        $comProduct = CompanyProducts::where('id',$productId)->first();
        $comProduct = json_decode(json_encode($comProduct));
        return Response::json(["returnData" => $comProduct]);
    }

    public function retrieveProductDetailAjax(Request $request) {
        $this->validate($request, array(
            "id" => "required",
        ));
        $returnData = array();
        $productId = $request->id;
        $productData = RetrievedProducts::where('id',$productId)->first();
        $productData = json_decode(json_encode($productData));
        return Response::json(["returnData" => $productData]);
    }



    public function productSearchLicense(Request $request) {
        $this->validate($request, array(
            "q" => "required",
        ));
        $returnData = array();
        $term = $request->q;
        $comProducts = CompanyProducts::where('license','like',$term.'%')->get();
        if(!empty($comProducts) && count($comProducts) > 0) {
            foreach ($comProducts as $key => $value) {
                $returnData[] = array('label'=>$value->license,'value'=>$value->license);
            }
        } else {
            $comProducts = RetrievedProducts::where('license','like',$term.'%')->get();
            if(!empty($comProducts) && count($comProducts) > 0) {
                foreach ($comProducts as $key => $value) {
                    $returnData[] = array('label'=>$value->name,'value'=>$value->name);
                }
            }
        }
        return Response::json(["returnData" => $returnData]);
    }

    public function listing(Request $request){
    	$products = CompanyProducts::get();
    	$products = json_decode(json_encode($products),true);
        return view('portal.products',compact("products"));
    }

    public function addProductStore(Request $request) {
    	$user = Auth::user();
    	$this->validate($request, array(
            "name" => "required",
            "product_image" => "required|max:2048",
            "sku" => "required",
            "sku_size" => "required",
            "license" => "required",
            "antidote_statement" => "required",
            "caution_id" => "required",
            "brand_name" => "required",
        ));

        if (request()->hasFile('product_image')){
        	//$imageFIle = $request->file('product_image');
        	$filePath = $this->imageUpload($request->product_image,'products'); //Passing $data->image as parameter to our created method
	        $image = $filePath;
            $request->request->add(['image' => $image]);
        }

	    $request->request->add(['user_id' => $user->id]);
	    $sts = CompanyProducts::create($request->all());

	    $retrievedProductsObject = RetrievedProducts::where('user_id', $user->id)
            ->where('product_name',$request['name'])
            ->first();
	    if(!isset($retrievedProductsObject)) {
	    	$retrievedProductsObject = new RetrievedProducts();
	        $retrievedProductsObject->user_id = $user->id;
	        $retrievedProductsObject->product_name = $request['name'];
	        $retrievedProductsObject->license = $request['license'];
	        $retrievedProductsObject->save();
	    }
        if($sts) {
            \Session::flash("success", "New product has been created successfully");
            return redirect()->route("products");
        }
    }

    public function editUpdate(Request $request) {
        $user = Auth::user();
        $this->validate($request, array(
            "product_id" => "required",
            "name" => "required",
            "product_image" => "image|max:2048",
            "sku" => "required",
            "sku_size" => "required",
            "license" => "required",
            "antidote_statement" => "required",
            "caution_id" => "required",
            "brand_name" => "required",
        ));

        if (request()->hasFile('product_image')){
            //$imageFIle = $request->file('product_image');
            $filePath = $this->imageUpload($request->product_image,'products'); //Passing $data->image as parameter to our created method
            $image = $filePath;
            $request->request->add(['image' => $image]);
        }

        $request->request->add(['user_id' => $user->id]);
        $companyProduct = CompanyProducts::where("id", $request->product_id)->first();
        $sts = $companyProduct->fill($request->all())->save();

        if($sts) {
            \Session::flash("success", "Product has been updated successfully");
            return redirect()->route("products");
        }
    }

    public function addRtrvProductStore(Request $request) {
        $user = Auth::user();
        $this->validate($request, array(
            "product_name" => "required",
            "license" => "required",
        ));

        $request->request->add(['user_id' => $user->id]);
        $sts = RetrievedProducts::create($request->all());

        if($sts) {
            \Session::flash("success", "New product has been created successfully");
            return redirect()->route("synced.products");
        }
    }

    public function editRtrvUpdate(Request $request) {
        $user = Auth::user();
        $this->validate($request, array(
            "product_id" => "required",
            "product_name" => "required",
            "license" => "required",
        ));


        $request->request->add(['user_id' => $user->id]);
        $product = RetrievedProducts::where("id", $request->product_id)->first();
        $sts = $product->fill($request->all())->save();

        if($sts) {
            \Session::flash("success", "Product has been updated successfully");
            return redirect()->route("synced.products");
        }
    }

    public function addProductForm(Request $request){
        return view('portal.product-add');
    }

    public function syncedProducts(Request $request){

        $user=auth()->user();
        $products=RetrievedProducts::where('user_id', $user->id)
            ->get();

        return view('portal.retrieved-products', compact('products'));

    }

    public function syncProducts(Request $request){

        $user=auth()->user();
        if($request->elements){

            $data=json_decode($request->elements, true);
            foreach($data as $d){

                RetrievedProducts::firstOrCreate([
                    'user_id'=>$user->id,
                    'product_name'=>$d['product']
                ],[
                    'license'=>$d['certificate']
                ]);

            }

        }

    }


}
