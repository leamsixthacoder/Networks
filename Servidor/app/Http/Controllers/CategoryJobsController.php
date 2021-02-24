<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use App\Models\category;
use Illuminate\Http\Request;

class CategoryJobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll($idcategoria, $idjobs)
    {
        
    }
    public function index($id)
    {
     $categoria = category::find($id);
     $jobs = Jobs::find($id);
     $data = ['success'=>true,
             'categoria'=>$categoria,
             'jobs'=>$jobs
            ];
            if(is_null($categoria)){
                return response()->json(['message'=>'Category Not Found'], 404);
            }
            else if (is_null($jobs)){
                return response()->json(['message'=>'Job Not Found'], 404);
            }
     return response()->json($data, 200,[]);





       //$jobs = Jobs::find($id);
     //if(is_null($jobs)){
       // return response()->json(['message' => 'Job Not Found'], 404);
    // }
    // return response()->json($jobs::find($id), 200);
          
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        //return  "Mostrando formulario para trabajos que pertenecen a las categorias  "."$id";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        if(!$request->get('id_company')|| !$request->get('workingDay_id') || !$request->get('logo') || !$request->get('Url') || !$request->get('position') || !$request->get('address') || !$request->get('description') || !$request->get('apply') || !$request->get('email') || !$request->get('job_category'))
        {
            return response()->json(['mensaje'=>'Datos Invalidos o Incompletos','codigo'=>'422'],422);
        }
        $category=category::find($id); 
        if (!$category) {
            return response()->json(['mensaje'=>'La categoria no existe','codigo'=> '404'],404);
        }

        Jobs::create([
        'id_company'=>$request->get('id_company'),
        'workingDay_id'=>$request->get('workingDay_id'),
        'logo'=>$request->get('logo'),
        'Url'=>$request->get('Url'),
        'position'=>$request->get('position'),
        'address'=>$request->get('address'),
        'description'=>$request->get('description'),
        'apply'=>$request->get('apply'),
        'email'=>$request->get('email'),
        'job_category'=>$request->get('job_category'),
        'category_id'=>$id
        ]);
        return response()->json(['mensaje'=>'El Trabajo ha sido insertado','codigo'=>'201'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function show($idcategoria,$idjobs)
    {
         $category = category::find($idcategoria);
     if(is_null($category)){
        return response()->json(['message' => 'Job Not Found'], 404);
    }
     return response()->json($category::find($idcategoria), 200);
       
       //Jobsif 

      $jobs = Jobs::find($idjobs);

      if(is_null($jobs)){
        return response()->json(['message' => 'Job Not Found'], 404);
    }
     return response()->json($jobs::find($idjobs), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function edit($idcategoria, $idjobs)
    {
        //return "Mostrando el formulario para editar el trabajo ".$idjobs." de la categoria ".$idcategoria;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$category_id,$idjobs)
    {
     
        $metodo=$request->method();
        $categoria=Jobs::find($idjobs);  
        if (!$categoria) 
        {
         return response()->json(['mensaje'=>'No se encuentra el trabajo','codigo'=>'404'],404);
        }
        
        $j=$categoria->category()->find($category_id);

            if(!$j) 
            {
             return response()->json(['mensaje'=>'No se encuentra el trabajo que pertenece a esta categoria','codigo'=>'404'],404);
            }

            $logo=$request->get('logo');  
            $Url=$request->get('Url');  
            $position=$request->get('position');  
            $apply=$request->get('apply');  
            $address=$request->get('address');
            $description=$request->get('description');
            $email=$request->get('email'); 
            $job_category=$request->get('job_category');
            $workingDay_id=$request->get('workingDay_id');
            $id_company=$request->get('id_company');
            $category_id=$request->get('category_id');

           $flag=false;

        if ($metodo==="PATCH"){
         if ($logo!=null && $logo!='') 
         {
             $j->logo=$logo;
             $flag=true;
         }

         if ($workingDay_id!=null && $workingDay_id!='') 
         {
             $j->workingDay_id=$workingDay_id;
             $flag=true;
         }

         if ($job_category!=null && $job_category!='') 
         {
             $j->job_category=$job_category;
             $flag=true;
         }
         if ($email !=null && $email!='') 
         {
             $j->email=$email;
             $flag=true;
         }
         if ($apply!=null && $apply!='') 
         {
             $j->apply=$apply;
             $flag=true;
         }
         if ($position!=null && $position!='') 
         {
             $j->position=$position;
             $flag=true;
         }
         if ($Url!=null && $Url!='') 
         {
             $j->Url=$Url;
             $flag=true;
         }
         if ($id_company!=null && $id_company!='') 
         {
             $j->id_company=$id_company;
             $flag=true;
         }
         if ($category_id!=null && $category_id!='') 
         {
             $j->category_id=$category_id;
             $flag=true;
         }
         if ($flag) {
            $j->save();
            return response()->json(['mensaje'=>'El Trabajo ha sido editado correctamente','codigo'=>202],202);
         }
         return response()->json(['mensaje'=>'No se han guardado los cambios','codigo'=>200],200);
         
       
        }

        if (!$id_company || $logo || $Url || $position || $apply || $email || $workingDay_id || $job_category )
        {
            return response()->json(['mensaje'=>'Datos Invalidos'],404);
        } 
    
        $j->save();
        return response()->json(['mensaje'=>'El Trabajo ha sido editado correctamente','codigo'=>202],202);




        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function destroy($idcategoria, $idjobs)
    {
        $categoria=category::find($idcategoria);
        if (!$categoria)
        {
        return response()->json(['message'=>'La categoria no se encuentra','codigo'=>'404'], 404);
        }
        $job=$categoria->jobs()->find($idjobs); 
        if (!$job) 
        {
            return response()->json(['message'=>'El  trabajo no se encuentra asociado a la categoria','codigo'=>'404'], 404);
        }
        $job->delete();
        return response()->json(['message'=>'El  trabajo ha sido eliminado','codigo'=>'200'], 200);
      
    }
}
/* public function getJobs(){
        return response()->json(Jobs::all(), 200);
    }

    public function getJobsByCategory($category){
        $jobs = Jobs::find($category);
        if(is_null($jobs)){
            return response()->json(['message' => 'Job Not Found'], 404);
        }
        return response()->json($jobs::find($category), 200);
    }
    
    public function createJobs(Request $request){
        $jobs = Jobs::create($request->all());
        return response($jobs, 201);
    }*/