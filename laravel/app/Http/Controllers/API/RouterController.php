<?php

namespace App\Http\Controllers\API;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RouterController extends Controller
{
    public $successStatus = 200;
    /** 
     * Create Router api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function createRouter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sapId' => 'sometimes|required|unique:routers',
            'hostname' => 'sometimes|required|unique:routers',
            'loopback' => 'sometimes|required|unique:routers',
            'mac_address' => 'sometimes|required|unique:routers',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $routers = DB::table('routers')->insert(
            array('sapId' => $input['sapId'], 'hostname' => $input['hostname'], 'loopback' => $input['loopback'], 'mac_address' => $input['mac_address'])
        );
        if ($routers) {
            return response()->json(['success' => $routers], $this->successStatus);
        } else {
            return response()->json(['error' => 'Invalid Data.'], 401);
        }
    }
    /** 
     * Update Router api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function updateRouter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'sapId' => 'sometimes|required|unique:routers',
            'hostname' => 'sometimes|required|unique:routers',
            'loopback' => 'sometimes|required|unique:routers',
            'mac_address' => 'sometimes|required|unique:routers',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        
        $input = $request->all();
        $routers = DB::table('routers')
                    ->where('id', $input['id'])
                    ->update(array('sapId' => $input['sapId'], 'hostname' => $input['hostname'], 'loopback' => $input['loopback'], 'mac_address' => $input['mac_address']));

        if ($routers) {
            return response()->json(['success' => $routers], $this->successStatus);
        } else {
            return response()->json(['error' => 'Invalid Data.'], 401);
        }
    }
    /** 
     * Delete Router api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function deleteRouter(Request $request)
    {
        $input = $request->all();
        DB::table('routers')->where('id', '=', $input['id'])->delete();
        return response()->json(['success' => $success], $this->successStatus);
    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function details()
    {
        $routers = DB::table('routers')->select('sapId', 'hostname', 'loopback', 'mac_address')->get();
        return response()->json(['success' => $routers], $this->successStatus);
    }
}
