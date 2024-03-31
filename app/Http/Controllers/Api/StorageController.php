<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expert;
use App\Models\Selectedservice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use PhpParser\Node\Expr\Cast\Object_;
use Ramsey\Uuid\Type\Decimal;

class StorageController extends Controller
{


  public $path = [];
  public $iconpath = [];
  public $recordpath = [];
  private $defaultimage = "default.png";
  private $defaultsvg = "default.svg";
  public function __construct()
  {
    //inputs
    $this->path['inputs'] = 'images/inputs';
    $this->iconpath['inputs'] = 'images/inputs/icons';
    //experts
    $this->path['experts'] = 'images/experts';

    // $recordpath['experts'] = 'images/experts/records';
    $this->path['experts'] = 'images/experts';
    $this->recordpath['experts'] = 'images/experts/records';

    //clients
    $this->path['clients'] = 'images/clients';
    //services
    $this->path['services'] = 'images/services';
    $this->iconpath['services'] = 'images/services/icons';
    //empty
    $this->path['default'] = 'images/default';
    $this->iconpath['default'] = 'images/default/icons';
    //value
    $this->path['values_services'] = 'images/values';
    $this->recordpath['values_services'] = 'images/values/records';
    //answer
     
    $this->recordpath['answers'] = 'images/answers/records';
  }
  /**
   * Display a listing of the resource.
   */
  public function ExpertPath($type)
  { //image record
    $url = "";

    if ($type == "image") {
      $url = url(Storage::url($this->path['experts'])) . '/';
    } else {
      $url = url(Storage::url($this->recordpath['experts'])) . '/';
    }

    return $url;

  }
  public function InputPath($type)
  { //image icon
    $url = "";

    if ($type == "image") {
      $url = url(Storage::url($this->path['inputs'])) . '/';
    } else {
      $url = url(Storage::url($this->iconpath['inputs'])) . '/';
    }

    return $url;


  }
  public function ClientPath($type)
  { //image record
    $url = "";

    if ($type == "image") {
      $url = url(Storage::url($this->path['clients'])) . '/';
    }
    return $url;

  }

  public function ServicePath($type)
  { //image icon
    $url = "";

    if ($type == "image") {
      $url = url(Storage::url($this->path['services'])) . '/';
    } else {
      $url = url(Storage::url($this->iconpath['services'])) . '/';
    }

    return $url;


  }

  public function DefaultPath($type)
  { //image icon
    $url = "";
    if ($type == "image") {
      $url = url(Storage::url($this->path['default'])) . '/' . $this->defaultimage;
    } else {
      $url = url(Storage::url($this->iconpath['default'])) . '/' . $this->defaultsvg;
    }
    return $url;


  }
  public function ValuePath($type)
  { //image record
    $url = "";
    if ($type == "image") {
      $url = url(Storage::url($this->path['values_services'])) . '/';
    } else {
      $url = url(Storage::url($this->recordpath['values_services'])) . '/';
    }
    return $url;
  }
  public function AnswerPath($type)
  { //image record
    $url = "";
    if ($type == "record") {
      $url = url(Storage::url($this->recordpath['answers'])) . '/';
    }
    return $url;
  }
  public static function CalcPercentVal($percent,$total)
  {
      //10% 200->200*10/100
      $val=$total*$percent/100;
      return $val;
  }
  public static function addZeros($number)
  {
      $number = (int) $number;
      $numLength = strlen($number);
      if ($numLength < 6) {
          $zeroslen = 6 - $numLength;
          $paddedNumber = str_pad($number, 6, '0', STR_PAD_LEFT);
      } else {
          $paddedNumber = str_pad($number, $numLength + 1, '0', STR_PAD_LEFT);
      }
      return $paddedNumber;
  }
  //
  public static function diffTimeinMinutes($start_date, $end_date)
  {
      $minutes = 0;
      if ((!is_null($start_date)) && (!is_null($end_date))) {
          $end = Carbon::parse($end_date);
          $start = Carbon::parse($start_date);

          $minutes = $end->diffInMinutes($start);
      }
      return $minutes;
  }
  
  public static function calcAnswerspeedAvg($expert_id)
  {
    $avg= Selectedservice::where('expert_id',$expert_id)->where('answer_speed','<>',0)->whereNotNull('answer_speed')
    ->select('answer_speed')->average('answer_speed');     
      return $avg;
  }
  public static function calcRateAvg($expert_id)
  {
    $avg= Selectedservice::where('expert_id',$expert_id)->where('rate','<>',0)->whereNotNull('rate')
    ->select('rate')->average('rate');     
      return $avg;
  }
}
