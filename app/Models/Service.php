<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Http\Controllers\Api\StorageController;
class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'name',
        'desc',
        'image',
        'createuser_id',
        'updateuser_id',
        'is_active',
        'icon',
          'is_callservice',  
           'expert_percent'
    ];
    //protected $appends= ['image_path','svg_path'];
    protected $hidden= ['image_path','svg_path'];
    public function getSvgPathAttribute(){
        $conv="";
        $strgCtrlr = new StorageController(); 
        if(is_null($this->icon) ){
            $conv =$strgCtrlr->DefaultPath('icon'); 
        }else if($this->icon==''){
            $conv =$strgCtrlr->DefaultPath('icon'); 
        } else {
            $url = $strgCtrlr->ServicePath('icon');
            $conv =  $url.$this->icon;
        }     
       
            return  $conv;
     }
     public function getImagePathAttribute(){
        $conv="";
        $strgCtrlr = new StorageController(); 
        if(is_null($this->image) ){
            $conv =$strgCtrlr->DefaultPath('image'); 
        }else if($this->image==''){
            $conv =$strgCtrlr->DefaultPath('image'); 
        } else {
            $url = $strgCtrlr->ServicePath('image');
            $conv =  $url.$this->image;
        }     
       
            return  $conv;
     }
    public $fullpathimg = "";
    public $fullpathsvg = "";
    public $experts_names = "";
    public function selectedservices(): HasMany
    {
        return $this->hasMany(Selectedservice::class);
    }
    public function expertservices(): HasMany
    {
        return $this->hasMany(ExpertService::class);
    }
    public function inputservices(): HasMany
    {
        return $this->hasMany(InputService::class) ;
    }
    public function pointtransfers(): HasMany
    {
        return $this->hasMany(Pointtransfer::class);
    }
 
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }
    
}
