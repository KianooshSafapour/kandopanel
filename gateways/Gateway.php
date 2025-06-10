<?php
namespace kandopanel;
interface Gateway
{
    public function StartPay();
    public function setInfo($info = []);
    public function Verify($back_data);
}
