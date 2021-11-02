<?php
namespace app\services;
use Illuminate\Support\Str;
class OrderServices
{

    protected $request;

    public function __construct()
    {
        $this->request = app('request');
    }

    public function makeUniqueOrderId()
    {
        $district = json_encode($this->request->district, true);
        $collectName = substr($district, 1, 3) ?? Str::random(3);
        $newOrderId = "#".strtolower($collectName)."00";
        return $newOrderId;

    }
}
